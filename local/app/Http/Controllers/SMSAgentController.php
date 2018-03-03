<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use \App;
use App\User;
use SMS;
use Input;
use App\SMSAgent;
class SMSAgentController extends Controller
{
	  public $payment_records = [];
    public function __construct()
    {
    	 $this->middleware('auth');
    }
    
    public function index()
    {
        
    	if(!checkRole(getUserGrade(2)))
        {
          prepareBlockUserMessage();
          return back();
        }

    	$data['active_class']       = 'sms';
        $data['title']              = getPhrase('send_sms');
        $data['layout']             = getLayout();
        $data['record']             = FALSE;
        $data['categories']           =array('quiz_categories'=>'Quizzes', 'lms_categories'=> 'LMS');

        return view('sms.sending-sms', $data);     
    }

    /**
     * This method sends SMS with the sent settings
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function sendSMS(Request $request)
    {
    	$columns = array(
        'message'  => 'bail|required|'
        );
		$this->validate($request,$columns);

    	if(!checkRole(getUserGrade(2)))
        {
          prepareBlockUserMessage();
          return back();
        }

    	$smsObject = new SMSAgent();
    	$smsObject->message = $request->message;
    	$smsObject->role_id = getRoleData($request->sms_to);
    	$categories = [];
    	if(!$request->for_category) {
    	$categories = [];
    	foreach($request->categories as $key=>$value)
    		$categories[] = $key;
    	}
    	else
    	{
    		$smsObject->categories = [];
    	}

    	$smsObject->categories = $categories;
    	$smsObject->sendSMS();
    	$message = 'No_users_available_with_the_combination';
    	$type = 'info';
    	if(count($smsObject->final_users)) {
    		$message = 'messges_sent_successfully_for_'.count($smsObject->final_users).'_users';
    		$type = 'success';
    	}
    	flash($type,$message,'overlay');
    	return redirect(URL_SEND_SMS);
    }
      
}
