<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Settings extends Model
{
    protected $table = "settings";
    
  
    public static function getRecordWithSlug($slug)
    {
        return Settings::where('slug', '=', $slug)->first();
    }

    /**
     * This method validates and sends the setting value
     * @param  [type] $setting_type [description]
     * @param  [type] $key          [description]
     * @return [type]               [description]
     */
    public static function getSetting($key, $setting_module)
    {

       $setting_module     = strtolower($setting_module);
        $key      =  strtolower($key);
        // dd(Settings::isSettingAvailable($key, $setting_module));
        return Settings::isSettingAvailable($key, $setting_module);
    }    

    /**
     * This method finds the key is available in module or not
     * If available, It will return the value of that setting_module[key]
     * If not available, it will fetch from db and stores in session and returns the value
     * @param  [type]  $key            [description]
     * @param  [type]  $setting_module [description]
     * @return boolean                 [description]
     */
    public static function isSettingAvailable($key, $setting_module)
    {
        if(!session()->has('settings'))
        {
            if(!Settings::loadSettingsModule($setting_module))
                return getPhrase('invalid_setting');
        }

      $settings =(array) json_decode(session('settings'));
      
      /**
       * Check if key exists in specified module settings data
       * If not exists return invalid setting
       */
      if(!array_key_exists($setting_module, $settings)) {


            if(!Settings::loadSettingsModule($setting_module))
            {
                return getPhrase('invalid_setting');
            }

         $settings =(array) json_decode(session('settings'));
        }
    //     var_dump(array_key_exists($setting_module, $settings));
    // dd($settings);
        $sub_settings = (array) $settings[$setting_module];

        if(!array_key_exists($key, $sub_settings))
        {
            return getPhrase('invalid_setting');
        }
            return $sub_settings[$key]->value;
    }

    /**
     * This method fetches the setting module and 
     * Get the record with the sent key from DB
     * Validate the record, if not valid return false
     * Append the record to existing setting varable
     * @param  [type] $setting_module [description]
     * @return [type]                 [description]
     */
    public static function loadSettingsModule($setting_module)
    {

        $setting_record = Settings::where('key','=',$setting_module)->first();
        
        if(!$setting_record)
            return FALSE;
        
        $data = json_decode($setting_record->settings_data);
        $global_settings =(array) json_decode(session('settings'));
        unset($global_settings[$setting_module]);
        $global_settings[$setting_module] = $data;

        // dd($global_settings[$setting_module]);
        session()->put('settings', json_encode($global_settings));
         // $settings =(array) json_decode(session('settings'));
         // dd($settings);
        return TRUE;

    }




}
