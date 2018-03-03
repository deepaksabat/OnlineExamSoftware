<?php

namespace App;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use App\Http\Requests;
use Mail;
class EmailSettings extends Model
{
    protected $settings = array(
    								'provider'     => 'mailtrap',
    								'type' 		   => 'mailtrap',
                                    'record_type'  => array('content'=>'Content', 
                                    'header'       =>'Header', 'footer'=>'Footer' )
                                    
    							);

   
    public function getSettings()
    {
        return json_encode($this->settings);
        
    }

    public function getDbSettings()
    {
         $dta = Settings::where('key','email_settings')->first();
         session()->put('email_settings', $dta->settings_data);
    }

  
}
