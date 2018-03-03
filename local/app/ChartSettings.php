<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ChartSettings extends Model
{
     protected  $settings = array(
     'categoryImagepath'     	=> "uploads/exams/categories/",
     'imageSize'                => 300,
     'examMaxFileSize'          => 10000,
     );

     protected $chartType 		= 'bar';

     protected  $defaultBackgroundColor= [
                'rgba(255, 99, 132, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(153, 102, 255, 0.2)',
                'rgba(255, 159, 64, 0.2)'
            ];
     protected $defaultBorderColor = [
                'rgba(255,99,132,1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)',
                'rgba(255, 159, 64, 1)'
            ];

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

    public function getBackgroundColor()
    {
    	return $this->defaultBackgroundColor;
    }
 	

    public function getBorderColor()
    {
    	return $this->defaultBorderColor;
    }

    function getRandomColors($total = 1)
    {
    	$this->defaultBackgroundColor = array();
    	$this->defaultBorderColor = array();
    	for($i=1; $i <= $total; $i++)
    	{
    		$color = [];
    		$color = $this->getColor(rand(0,999));
    		$this->defaultBackgroundColor[] = 'rgba('.$color[0].','.$color[1].','.$color[2].',0.2)';
    		$this->defaultBorderColor[] 	= 'rgba('.$color[0].','.$color[1].','.$color[2].',1)';
    	}
    	return array('bgcolor'=>$this->defaultBackgroundColor, 'border_color' => $this->defaultBorderColor);
    }

    function getColor($num) {
    $hash = md5('color' . $num); // modify 'color' to get a different palette
    return array(
        hexdec(substr($hash, 0, 2)), // r
        hexdec(substr($hash, 2, 2)), // g
        hexdec(substr($hash, 4, 2))); //b
}
}
