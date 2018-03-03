<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use \App;
use App\User;
use DB;
use SMS;
use Exception;


class SMSAgent extends Model
{
	public $users    = [];
	public $message = '';
	public $role_id = 0;
	public $categories = [];
	public $final_users = [];
	public $current_user = [];
    
    public function sendSMS()
    {
		$this->users = User::where('role_id','=',$this->role_id)->get();
		$this->filterUsersOnCategories();
		foreach ($this->final_users as $user) {
			$user = (object)$user;
			$this->setCurrentUser($user);
            try{
		  SMS::send($this->message, null, function($sms) {
        		  $current_user = $this->getCurrentUser();
        		  $sms->to($current_user->phone);
		      });
        }
        catch(Exception $e)
        {

        }

	}

 
		return TRUE;
    }

    public function setCurrentUser($user)
    {
    	$this->current_user = $user;
    }

    public function getCurrentUser()
    {
    	return $this->current_user;
    }

    public function filterUsersOnCategories()
    {
    	foreach($this->users as $user)
    	{
    		if($user->phone )
    		{
    			if(count($this->categories)) {
    			if($user->settings) {
    			$settings = array_keys((array)json_decode($user->settings)->user_preferences);
    			if(array_intersect($settings, $this->categories))
    			{
    				$this->final_users[$user->id]['name'] = $user->name;
    				$this->final_users[$user->id]['phone'] = $user->phone;
    			}
    		}
    	}
    	else{
    			$this->final_users[$user->id]['name'] = $user->name;
    			$this->final_users[$user->id]['phone'] = $user->phone;
    	}

    		}
    	}
    	return TRUE;
    }
}
