<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LmsSettings extends Model
{
     protected  $settings = array(
     'categoryImagepath'        => "uploads/lms/categories/",
     'contentImagepath'     	=> "uploads/lms/content/",
     'seriesImagepath'          => "uploads/lms/series/",
     'seriesThumbImagepath'     => "uploads/lms/series/thumb/",
     'defaultCategoryImage'     => "default.png",
     'imageSize'                => 300,
     'examMaxFileSize'          => 10000,
     'content_types'            => array(
                                    'file' => 'File',
                                    'video' => 'Video File',
                                    'audio' => 'Audio File',
                                    'video_url' => 'Video URL',
                                    'iframe' => 'Iframe',
                                    'audio_url' => 'Audio URL',
                                    'url' => 'URL'
                                    )
     );

      

 

    /**
     * This method returns the settings related to Library System
     * @param  boolean $key [For specific setting ]
     * @return [json]       [description]
     */
    public function getSettings($key = FALSE)
    {
    	if($key && array_key_exists($key,$settings))
    		return json_encode($this->settings[$key]);
    	return json_encode($this->settings);
    }
}
