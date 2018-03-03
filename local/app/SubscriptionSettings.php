<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SubscriptionSettings extends Model
{
    ////////////////////////////
    // Subscription settings  //
    ////////////////////////////
    protected  $settings = array(
     'live_mode'				=> FALSE,
     'test_secret_key'			=> 'sk_test_vzXssRGOW23fFOlBqaHZnRd4',
     'test_public_key'			=> 'pk_test_m7tw4GCJaZk9BlonvnViwZV7',
     'live_secret_key'			=> 'sk_live_4RCGpc2RsLflnrO9g1L5vpTk',
     'live_public_key'			=> 'pk_live_W9rCDZthMpRPHO3KSDl4iB4m',
     'invoice_company_name'     => 'Conquerors Technologies',
     'invoice_product_name'     => 'Premium Subscription'
     );


    /**
     * This method returns the settings related to Subscriptions System
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
