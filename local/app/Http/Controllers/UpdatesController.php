<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App;
use App\Http\Requests;

class UpdatesController extends Controller
{
     public function __construct()
    {
     
         $this->middleware('auth');
    
    }

    /**
     * This is the first patch which updates the currency code to
     * Site Settings module
     * This can be used by the existing users
     * To access this method, user need to type the following url
     * http://sitename/updates/patch1
     * @return [type] [description]
     */
    public function patch1()
    {

      if(!checkRole(getUserGrade(1)))
      {
        prepareBlockUserMessage();
        return back();
      }
    	$record                 = App\Settings::where('slug', 'site-settings')->first();
    	 
    	$settings_data = (array) json_decode($record->settings_data);
        
       $values = array(
                        'type'=>'text', 
                        'value'=>'$', 
                        'extra'=>'',
                        'tool_tip'=>'Enter currency symbol'
                       );
       $settings_data['currency_code'] = $values;
       $record->settings_data = json_encode($settings_data);
     
       $record->save();

       flash('success','system_upgraded_successfully', 'success');
       return redirect(URL_SETTINGS_VIEW.'site-settings');
    }
}
