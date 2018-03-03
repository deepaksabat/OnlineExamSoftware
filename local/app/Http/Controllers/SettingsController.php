<?php

namespace App\Http\Controllers;
use \App;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Settings;

use Yajra\Datatables\Datatables;
use DB;
use Input;
use Image;
use ImageSettings;
use File;
class SettingsController extends Controller
{
    public function __construct()
    {
    	$this->middleware('auth');
    }

    /**
     * Course listing method
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function index()
    {
      if(!checkRole(getUserGrade(1)))
      {
        prepareBlockUserMessage();
        return back();
      }
        $data['active_class']       = 'master_settings';
        $data['title']              = getPhrase('settings');
    	return view('mastersettings.settings.list', $data);
    }

    /**
     * This method returns the datatables data to view
     * @return [type] [description]
     */
    public function getDatatable()
    {
      if(!checkRole(getUserGrade(1)))
      {
        prepareBlockUserMessage();
        return back();
      }

         $records = Settings::select([ 'title', 
            'key', 'description','slug','id', 'updated_at'])
         ->orderBy('updated_at','desc');

         // $records = Settings::select([  
         // 	'subject_id','parent_id', 'topic_name','description','slug', 'id']);
        
        return Datatables::of($records)
        ->addColumn('action', function ($records) {
           $link_data = '<div class="dropdown more">
                        <a id="dLabel" type="button" class="more-dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="mdi mdi-dots-vertical"></i>
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="dLabel">
                            <li><a href="'.URL_SETTINGS_EDIT.$records->slug.'"><i class="fa fa-pencil"></i>'.getPhrase("edit").'</a></li>
                            <li><a href="'.URL_SETTINGS_VIEW.$records->slug.'"><i class="fa fa-eye"></i>'.getPhrase("view").'</a></li>';
                     
                        
                    $temp = '';
                   
                    $temp .=    '</ul></div>';
                    $link_data .= $temp;

            return $link_data;
            })
        ->editColumn('title', function($records){
        	return '<a href='.URL_SETTINGS_VIEW.$records->slug.'>'.ucwords($records->title).'</a>';
        })
        ->removeColumn('id')
        ->removeColumn('slug')
        ->removeColumn('updated_at')
        ->make();
    }

    /**
     * This method loads the create view
     * @return void
     */
    public function create()
    {	
      if(!checkRole(getUserGrade(1)))
      {
        prepareBlockUserMessage();
        return back();
      }
    	$data['record']         	= FALSE;
    	$data['active_class']       = 'master_settings';
    	// $data['parent_topics']      = array();
    	// $list 						= App\Subject::all();
    	// $data['subjects']			= array_pluck($list, 'subject_title', 'id');
     //    $data['subjects'][0]        = getPhrase('select');
     //    $data['parent_topics'][0]   = getPhrase('select');
        
    	$data['title']              = getPhrase('add_setting');
    	return view('mastersettings.settings.add-edit', $data);
    }

    /**
     * This method loads the edit view based on unique slug provided by user
     * @param  [string] $slug [unique slug of the record]
     * @return [view with record]       
     */
    public function edit($slug)
    {
      if(!checkRole(getUserGrade(1)))
      {
        prepareBlockUserMessage();
        return back();
      }

    	$record = Settings::where('slug', $slug)->get()->first();
    	
    	if($isValid = $this->isValidRecord($record))
            return redirect($isValid);

    	$data['record']       		= $record;
    	// $list 						= App\Subject::all();
    	// $data['subjects']			= array_pluck($list, 'subject_title', 'id');
    	// $data['parent_topics']		= array_pluck(Settings::getTopics($record->subject_id,0),'topic_name','id');
	   	// $data['parent_topics'][0] = 'Parent';
    	$data['active_class']       = 'master_settings';
        $data['title']              = getPhrase('edit_settings');
    	return view('mastersettings.settings.add-edit', $data);
    }

    /**
     * Update record based on slug and reuqest
     * @param  Request $request [Request Object]
     * @param  [type]  $slug    [Unique Slug]
     * @return void
     */
    public function update(Request $request, $slug)
    {

      if(!checkRole(getUserGrade(1)))
      {
        prepareBlockUserMessage();
        return back();
      }
        $record                 = Settings::where('slug', $slug)->get()->first();
        
        if($isValid = $this->isValidRecord($record))
            return redirect($isValid);

        $name = $request->key;	
          $this->validate($request, [
       	  'key'        		  => 'bail|required|max:30|unique:settings,key,'.$record->id,
          ]);
	       $name 					        = $request->key;
       
       /**
        * Check if the title of the record is changed, 
        * if changed update the slug value based on the new title
        */
        if($name != $record->key)
            $record->slug = $record->makeSlug($name);
    	$record->title                 =$request->title;
        $record->key 			        = $name;
        $record->description 			= $request->description;
         
        $record->save();

           if($request->hasFile('image'))
        {
            $old_image = $record->image;
            $record->image = $this->processUpload($request,'image', true);
            $record->save();
            $this->deleteFile($old_image, IMAGE_PATH_SETTINGS);
        }
       
    	flash('success','record_updated_successfully', 'success');
    	return redirect(URL_SETTINGS_LIST);
    }

    /**
     * This method adds record to DB
     * @param  Request $request [Request Object]
     * @return void
     */
    public function store(Request $request)
    {
     
     if(!checkRole(getUserGrade(1)))
      {
        prepareBlockUserMessage();
        return back();
      }

       $this->validate($request, [
         'key'          	 	=> 'bail|required|max:50|unique:settings,key',
         'title'                => 'bail|required',
         // 'image'                => 'bail|mimes:png,jpg,jpeg|max:2048',
         ]);
    	$record = new Settings();
        $record->title                  = $request->title;
        $name 					        = $request->key;
        $record->key 					= $name;
        $record->slug 			        = $record->makeSlug($name);
        $record->description 			= $request->description;
        $record->save();
        
        if($request->hasFile('image'))
        {
            $old_image = $record->image;
            $record->image = $this->processUpload($request,'image', true);
            $record->save();
            $this->deleteFile($old_image, IMAGE_PATH_SETTINGS);
        }

        
        flash('success','record_added_successfully', 'success');
    	return redirect(URL_SETTINGS_LIST);
    }

     
   

    /**
     * Delete Record based on the provided slug
     * @param  [string] $slug [unique slug]
     * @return Boolean 
     */
    public function delete($slug)
    {
        $record = Settings::where('slug', $slug)->first();
        /**
         * Check if any questions are related to this specific topic.
         * If no questions exists, delete this topic else give appropriate message
         */
        if(count($record->getQuestions->all()) > 0)
        {
            //Questions exists with the selected, so done delete the topic
            $response['status'] = 0;
            $response['message'] = getPhrase('this_topic_question');
            return json_encode($response);
        }
        else {
            $record->delete();
            $response['status'] = 1;
            $response['message'] = getPhrase('record_deleted_successfully');
            return json_encode($response);
        }
    }

    public function viewSettings($slug)
    {
        if(!checkRole(getUserGrade(1)))
        {
            prepareBlockUserMessage();
            return back();
        }

        $record                 = Settings::where('slug', $slug)->get()->first();
        
        if($isValid = $this->isValidRecord($record))
            return redirect($isValid);
        // dd($record);
        $data['settings_data']      = getArrayFromJson($record->settings_data);
        $data['record']             = $record;
        $data['active_class']       = 'master_settings';
        $data['title']              = $record->title;
       
        $data['layout']             = getLayout();

        // if($record->key=='site_settings')
        // {
        //     return view('mastersettings.settings.site-settings/add-edit', $data);            
        // }

    	return view('mastersettings.settings.sub-list', $data);
    }

    public function addSubSettings($slug)
    {


      if(!checkRole(getUserGrade(1)))
      {
        prepareBlockUserMessage();
        return back();
      }
        $record                 = Settings::where('slug', $slug)->get()->first();
        
        if($isValid = $this->isValidRecord($record))
            return redirect($isValid);
        $data['record']				= $record;
        $data['active_class']       = 'master_settings';
        $data['title']              = $record->key;
        



    	return view('mastersettings.settings.sub-list-add-edit', $data);
    }

    public function storeSubSettings(Request $request, $slug)
    {
        
      if(!checkRole(getUserGrade(1)))
      {
        prepareBlockUserMessage();
        return back();
      }
      $record                 = Settings::where('slug', $slug)->get()->first();
        
      if($isValid = $this->isValidRecord($record))
        return redirect($isValid);

        $validation_rules['key'] = 'bail|required|max:50';
        $validation_rules['type'] = 'bail|required';

        if($request->type=='file')
        {
            $validation_rules['value'] = 'bail|mimes:png,jpg,jpeg|max:2048';
        }

        if($request->type=='select')
        {
            $validation_rules['value'] = 'bail|required|integer';
        }

    	$this->validate($request, $validation_rules);


       $settings_data = (array) json_decode($record->settings_data);
       
      $value = '';
     
      $processed_data = (object)$this->processSettingValue($request);
        
       $values = array(
                        'type'=>$request->type, 
                        'value'=>$processed_data->value, 
                        'extra'=>$processed_data->extra,
                        'tool_tip'=>$processed_data->tool_tip
                       );
       $settings_data[$request->key] = $values;
       $record->settings_data = json_encode($settings_data);
      
       $record->save();

       flash('success','record_updated_successfully', 'success');
       return redirect(URL_SETTINGS_VIEW.$record->slug);

    }

    /**
     * This method finds the value of the setting type
     * The value may be of file or any single field entity
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function processSettingValue(Request $request)
    {
        $value = '';
        $extra = '';
        $tool_tip = '';

         if($request->type=='text'      || 
            $request->type=='number'    ||
            $request->type=='email'     ||
            $request->type=='textarea'  ||
            $request->type=='checkbox'  
            )

            $value = 0;
        if($request->has('value'))
         $value = $request->value;

        if($request->type=='file') {
            if($request->hasFile('value'))
                $value = $this->processUpload($request);
        }


        else if($request->type=='select') {
        
          $value = '';
            $extra['total_options'] = $request->total_options;
            $options = [];
            for($index=0; $index<$request->total_options; $index++)
            {
                $options[$request->option_value[$index]] = $request->option_text[$index];
            }
            
            $extra['options'] = $options;
            $value = $request->option_value[$request->value];
           

        }



         $tool_tip = $request->tool_tip;
         
       
        return array('value'=>$value, 'extra'=>$extra, 'tool_tip'=>$tool_tip);
    }

    /**
     * This method verifies if the request is the type of enverionment varable
     * @param  Request $request [description]
     * @return boolean          [description]
     */
    public function isEnvSetting(Request $request)
    {
        $env_keys = array(
                            'mail_driver',
                            'payu_merchant_key',
                            'one_signal_user_id',
                            'system_timezone',
                            'facebook_client_id',
                            'nexmo_key'
                            );

        foreach ($env_keys as $key => $value) 
        {
            if($request->has($value))            
                return TRUE;
        } 

        return FALSE;       
    }

    /**
     * [prepareEnvData description]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function prepareEnvData(Request $request)
    {
        $request_data = Input::all();
        $data = array();

        foreach ($request_data as $key => $value) {
            if($key=='_token' || $key=='_method' || $value=='')
                continue;
            if(isset($value['value']))
            $data[strtoupper($key)] = $value['value'];
        }
        return $data;
    }

    /**
     * This method is used to update the subsettings of the settings module
     * 
     * @param  Request $request [description]
     * @param  [type]  $slug    [description]
     * @return [type]           [description]
     */
    public function updateSubSettings(Request $request, $slug)
    {
         
        /**
         * Check if the request is of env varable
         * if yes, update env file
         */

     
       
     if(!checkRole(getUserGrade(1)))
      {
        prepareBlockUserMessage();
        return back();
      }
      $record                 = Settings::where('slug', $slug)->get()->first();
    
      if($isValid = $this->isValidRecord($record))
        return redirect($isValid);

    $input_data = Input::all();

    
 
    $extra = '';
    
    foreach ($input_data as $key => $value) {

            if($key=='_token' || $key=='_method' || $value=='')
                continue;
            $submitted_value = (object)$value;
            $value = 0;
            if(isset($submitted_value->value))
                $value = $submitted_value->value;
            
             $old_values = json_decode($record->settings_data);
            
            /**
             * For File type of settings, first check if the file is changed or not
             * If not changed just keep the old values as it is
             * If file changed, first upload the new file and delete the old file
             * @var [type]
             */
            if($submitted_value->type=='file')
            {
                if($request->hasFile($key)) {
                    $isNew = false;
                        $value = $this->processUpload($request, $key, $isNew);
                        
                         $this->deleteFile($old_values->$key->value, IMAGE_PATH_SETTINGS);
                }
                else
                {
                    $value = $old_values->$key->value;
                }
            }

            //*** File Answer type end **//

           if($submitted_value->type == 'select')
           {
                $extra = $old_values->$key->extra;
           }
            
            $data[$key] = array('value'=>$value, 'type'=>$submitted_value->type, 'extra'=>$extra, 'tool_tip'=>$submitted_value->tool_tip);
           
        }	 
       
       
       $record->settings_data = json_encode($data);
       if(!env('DEMO_MODE')) {
       $record->save();

        if($this->isEnvSetting($request))
        {

            $data = $this->prepareEnvData($request);
          
            $this->updateEnvironmentFile($data);
        }
       
       // dd($record);
        Settings::loadSettingsModule($record->key);
       (new App\EmailSettings())->getDbSettings();
   }
       flash('success','record_updated_successfully', 'success');
    	return redirect(URL_SETTINGS_VIEW.$record->slug);

    }


    public function deleteFile($record, $path, $is_array = FALSE)
    {
        $imageObject = new ImageSettings();
        $destinationPath      = $imageObject->getSettingsImagePath();
        $files = array();
        $files[] = $destinationPath.$record;
        File::delete($files);
    }

    public function isValidRecord($record)
    {
      if ($record === null) {

        flash('Ooops...!', getPhrase("page_not_found"), 'error');
        return $this->getRedirectUrl();
    }

    return FALSE;
    }

    public function getReturnUrl()
    {
      return URL_SETTINGS_LIST;
    }


     public function processUpload(Request $request, $sfname='value', $isNew = true)
     {
        
         if ($request->hasFile($sfname)) {
          
          $imageObject = new ImageSettings();
          
          $destinationPath      = $imageObject->getSettingsImagePath();
          
          $random_name = str_random(15);
          $fileName = '';
          if($isNew){
              $path = $_FILES[$sfname]['name'];
          $ext = pathinfo($path, PATHINFO_EXTENSION);

       
              $fileName = $random_name.'.'.$ext; 
              $request->file($sfname)->move($destinationPath, $fileName);
          }
          else {
              
              $path = $_FILES[$sfname]['name'];
        
              $ext = pathinfo($path['value'], PATHINFO_EXTENSION);

            $fileName = $random_name.'.'.$ext;//$request->$sfname['value']->guessClientExtension();
            
            move_uploaded_file($_FILES[$sfname]['tmp_name']['value'], $destinationPath.$fileName);
        }
          
          return $fileName;
 
        }
     }


    /**
     * This method updates the Environment File which contains all master settings
     * @param  array  $data [description]
     * @return [type]       [description]
     */
    public function updateEnvironmentFile($data = array())
    {
      if(count($data)>0) {
       $env = file_get_contents(base_path() . '/.env');
       $env = preg_split('/\s+/', $env);
       
        foreach((array)$data as $key => $value){

                // Loop through .env-data
                foreach($env as $env_key => $env_value){

                    // Turn the value into an array and stop after the first split
                    // So it's not possible to split e.g. the App-Key by accident
                    $entry = explode("=", $env_value, 2);

                    // Check, if new key fits the actual .env-key
                    if($entry[0] == $key){
                        // If yes, overwrite it with the new one
                        $env[$env_key] = $key . "=" . $value;
                    } else {
                        // If not, keep the old one
                        $env[$env_key] = $env_value;
                    }
                }
            }
             $env = implode("\n", $env);
              file_put_contents(base_path() . '/.env', $env);
      return TRUE;
    }
    else
    {
      return FALSE;
    }

  }

}
