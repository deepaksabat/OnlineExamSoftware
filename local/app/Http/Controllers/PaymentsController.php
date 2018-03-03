<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use \App;
use App\Quiz;
use App\Subject;
use App\QuestionBank;
use App\QuizCategory;
use App\ExamSeries;
use App\LmsSeries;
use Yajra\Datatables\Datatables;
use DB;
use Auth;
use App\Paypal;
use App\Payment;
use Input;
use Softon\Indipay\Facades\Indipay;  
use Excel;
use Carbon;
use Exception;
class PaymentsController extends Controller
{
  public $payment_records = [];
    public function __construct()
    {
    	 $this->middleware('auth');
    }

    /**
     * This method displays the payment transactions made by the user
     * The user info is accessed by the provided slug
     * @param  [type] $slug [description]
     * @return [type]       [description]
     */
    public function index($slug)
    {

       if(!isEligible($slug))
          return back();
      
    	$user = getUserWithSlug($slug);

      $data['is_parent']           = 0;
    $user = getUserWithSlug($slug);

    if(getRoleData($user->role_id)=='parent')
      $data['is_parent']           = 1;

    	$data['user']       		= $user;
    	$data['active_class']       = 'subscriptions';
      $data['title']              = getPhrase('subscriptions_list');
      $data['layout']              = getLayout();

      $payment = new Payment();
      $records = $payment->updateTransactionRecords($user->id);
      foreach($records as $record)
      {
      	$rec = Payment::where('id',$record->id)->first();
      	$this->isExpired($rec);
      }
        
    	return view('student.payments.list', $data);
    }

    public function getDatatable($slug)
    {

      $is_parent = 0;
		$user = getUserWithSlug($slug);

    if(getRoleData($user->role_id)=='parent')
    {
      $is_parent = 1;
      $childs_list = App\User::where('parent_id','=',$user->id)->get();

      $records = Payment::join('users', 'users.id','=','payments.user_id')
      ->where('users.parent_id','=',$user->id)
     ->select(['users.image', 'users.name',  'item_name', 'plan_type', 'start_date', 'end_date', 'payment_gateway','payments.updated_at','payment_status','payments.cost', 'payments.after_discount', 'payments.paid_amount','payments.id' ]);
  
        $ind = 0;
        foreach($childs_list as $child) {
          if($ind++ ==0) {
            $records->where('user_id', '=', $child->id);
            continue;
          }

          $records->orWhere('user_id', '=', $child->id);
        }

        $records->orderBy('updated_at', 'desc');
    }
    else {
		 
     $records = Payment::select(['item_name', 'plan_type', 'start_date', 'end_date', 'payment_gateway', 'updated_at','payment_status','id','cost', 'after_discount', 'paid_amount'])
		 ->where('user_id', '=', $user->id)
            ->orderBy('updated_at', 'desc');
    }
      
        $dta = Datatables::of($records)
        
        ->addColumn('action', function ($records) {
        	if(!($records->payment_status==PAYMENT_STATUS_CANCELLED || $records->payment_status==PAYMENT_STATUS_PENDING)) { 
          		$link_data = ' <a >View More</a>';
            	return $link_data;
        	}
        	return ;
        })
        ->editColumn('payment_status',function($records){

        	$rec = '';
        	if($records->payment_status==PAYMENT_STATUS_CANCELLED)
        	 $rec = '<span class="label label-danger">'.ucfirst($records->payment_status).'</span>';
        	elseif($records->payment_status==PAYMENT_STATUS_PENDING)
        		$rec = '<span class="label label-info">'.ucfirst($records->payment_status).'</span>';
        	elseif($records->payment_status==PAYMENT_STATUS_SUCCESS)
        		$rec = '<span class="label label-success">'.ucfirst($records->payment_status).'</span>';
        	return $rec;
        })
        ->editColumn('plan_type', function($records)
        {
        	return ucfirst($records->plan_type);
        })
        ->editColumn('start_date', function($records)
        {
        	if($records->payment_status==PAYMENT_STATUS_CANCELLED || $records->payment_status==PAYMENT_STATUS_PENDING)
        		return '-';
        	return $records->start_date;
        })
        ->editColumn('end_date', function($records)
        {
        	if($records->payment_status==PAYMENT_STATUS_CANCELLED || $records->payment_status==PAYMENT_STATUS_PENDING)
        		return '-';
        	return $records->end_date;
        })
        ->editColumn('payment_gateway', function($records)
        {
          $text =  ucfirst($records->payment_gateway);

         if($records->payment_status==PAYMENT_STATUS_SUCCESS) {
          $extra = '<ul class="list-unstyled payment-col clearfix"><li>'.$text.'</li>';
          $extra .='<li><p>Cost:'.$records->cost.'</p><p>Aftr Dis.:'.$records->after_discount.'</p><p>Paid:'.$records->paid_amount.'</p></li></ul>';
          return $extra;
        }
          return $text;
        })
        ->removeColumn('id')
        ->removeColumn('action');

        if($is_parent) {
          $dta = $dta->editColumn('image', function($records) {
             return '<img src="'.getProfilePath($records->image).'"  /> '; 
          })
          ->editColumn('name', function($records)
          {
            return ucfirst($records->name);
          });
        }
         
        return $dta->make();    	
    }
    
    /**
     * This method identifies the type of package user is requesting and redirects to the payment gateway
     * The payments are categorized to 3 modules
     * 1) Combo -- Contains the items related to test series [it may have exams or study materials]
     * 2) LMS  -- It only contains Study materials
     * 3) EXAM -- It only contains single exams package
     * @param  [type] $type ['combo', 'lms', 'exam']
     * @param  [type] $slug [description]
     * @return [type]       [description]
     */
    public function paynow(Request $request, $slug)
    {

    
      
     $type = $request->type;
    
    	/**
    	 * Get the Item Details based on Type supplied type
    	 * If item is valid, prepare the data to save after successfull payment
    	 * Preserve the data
    	 * Redirect to payment
    	 * @var [type]
    	 */
      $item = $this->getPackageDetails($type, $slug);

      if(!$item)
      {
      	dd('failed');
      }
      
      $other_details = array();
      $other_details['is_coupon_applied'] = $request->is_coupon_applied;
      $other_details['actual_cost'] 		  = $request->actual_cost;
      $other_details['discount_availed'] 	= $request->discount_availed;
      $other_details['after_discount']    = $request->after_discount;
      $other_details['coupon_id']         = $request->coupon_id;
      
      $other_details['paid_by_parent']    = $request->parent_user;
      $other_details['child_id'] 		      = $request->selected_child_id;

      /**
       * If the total amount is 0 after coupon code is applied, 
       * once validate is user is really getting the discount after the coupon is applied
       * then give subscription for the package
       * @var [type]
       */
      if($request->after_discount==0)
      {
         $token = $this->preserveBeforeSave($item,$type, $request->gateway, $other_details,1);
         if($this->validateAndApproveZeroDiscount($token, $request))
         {
            //Valid 
            flash('success', 'your_subscription_was_successfull', 'overlay');
            $user = Auth::user();
            return redirect(URL_PAYMENTS_LIST.$user->slug);
         }
         else {
            //Cheat
            flash('Ooops...!', 'invalid_payment_or_coupon_code', 'overlay');
            $user = Auth::user();
            return redirect(URL_PAYMENTS_LIST.$user->slug);
         }
         
         return back();
      }

     
      $payment_gateway = $request->gateway;
     
      if($payment_gateway == 'payu')
      {

        if(!getSetting('payu', 'module'))
        {
            flash('Ooops...!', 'this_payment_gateway_is_not_available', 'error');          
            return back();
        }

         $token = $this->preserveBeforeSave($item,$type, $payment_gateway, $other_details);
        $config = config();
        $payumoney = $config['indipay']['payumoney'];

        $payumoney['successUrl'] = URL_PAYU_PAYMENT_SUCCESS.'?token='.$token;
        $payumoney['failureUrl'] = URL_PAYU_PAYMENT_CANCEL.'?token='.$token;

     
        $user = Auth::user();
         $parameters = [
                          'tid'       => $token,
                          'order_id'  => '',
                          'firstname' => $user->name,
                          'email'     =>$user->email,
                          'phone'     => ($user->phone)? $user->phone : '45612345678',
                          'productinfo' => $request->item_name,
                          'amount'    => $request->after_discount,
                          'surl'      => URL_PAYU_PAYMENT_SUCCESS.'?token='.$token,
                          'furl'      => URL_PAYU_PAYMENT_CANCEL.'?token='.$token,
                       ];
      
      return Indipay::purchase($parameters);

        // URL_PAYU_PAYMENT_SUCCESS
        // URL_PAYU_PAYMENT_CANCEL
      }
       else if($payment_gateway=='paypal') 
      {

        if(!getSetting('paypal', 'module'))
        {
            flash('Ooops...!', 'this_payment_gateway_is_not_available', 'error');          
            return back();
        }

        $token = $this->preserveBeforeSave($item,$type, $payment_gateway, $other_details);


        $paypal = new Paypal();
        $paypal->config['return'] 		= URL_PAYPAL_PAYMENT_SUCCESS.'?token='.$token;
        $paypal->config['cancel_return'] 	= URL_PAYPAL_PAYMENT_CANCEL.'?token='.$token;
        $paypal->invoice = $token;
        $paypal->add($item->title, $request->after_discount); //ADD  item
        $paypal->pay(); //Proccess the payment
      }
      else if($payment_gateway=='offline') 
      {
        
        if(!getSetting('offline_payment', 'module'))
        {
            flash('Ooops...!', 'this_payment_gateway_is_not_available', 'error');          
            return back();
        }

        $payment_data = [];
        foreach(Input::all() as $key => $value)
        {
          if($key=='_token')
            continue;
          $payment_data[$key] = $value;
        }

        $data['active_class'] = 'feedback';
        $data['payment_data'] = json_encode($payment_data);
        $data['layout']       = getLayout();
        $data['title']        = getPhrase('offline_payment');
        return view('payments.offline-payment', $data);
       }

    	dd('please wait...');
    }

    /**
     * This method returns the object details
     * @param  [type] $type [description]
     * @param  [type] $slug [description]
     * @return [type]       [description]
     */
    public function getPackageDetails($type, $slug)
    {
    	return $this->getmodelName($type,$slug);
    }

    /**
     * This method returns the Class based on the type of request
     * @param  [type] $type [description]
     * @return [type]       [description]
     */
    public function getModelName($type, $slug)
    {
    	switch($type)
    	{
    		case 'combo':
    			return ExamSeries::where('slug', '=', $slug)->first();
    			break;
    		case 'lms':
    			return LmsSeries::where('slug', '=', $slug)->first();
    			break;
    		case 'exam':
    			return Quiz::where('slug', '=', $slug)->first();
    			break;
    	}

    	return null;
    }


    public function paypal_cancel()
    {

    	if($this->paymentFailed())
    	{
    		//FAILED PAYMENT RECORD UPDATED SUCCESSFULLY
    		//PREPARE SUCCESS MESSAGE
    		  flash('Ooops...!', 'your_payment_was cancelled', 'overlay');
    	}
    	else {
    	//PAYMENT RECORD IS NOT VALID
    	//PREPARE METHOD FOR FAILED CASE
    	  pageNotFound();
    	}

    	//REDIRECT THE USER BY LOADING A VIEW
    	$user = Auth::user();
    	return redirect(URL_PAYMENTS_LIST.$user->slug);
    	 
    }


    public function paypal_success(Request $request)
    {
       if(env('DEMO_MODE')) {
        flash('success', 'your_subscription_was_successfull', 'overlay');
      }

        $user = Auth::user();
         $response = $request->all();

         $package_name = ucwords($response['item_name1']);


    	if($this->paymentSuccess($request))
    	{
    		//PAYMENT RECORD UPDATED SUCCESSFULLY
    		//PREPARE SUCCESS MESSAGE
    		  flash('success', 'your_subscription_was_successfull', 'overlay');
           $email_template = 'subscription_success';
           try{
          sendEmail($email_template, array('username'=>$user->name, 
          'plan' => $package_name,
          'to_email' => $user->email));
        }
        catch(Exception $ex)
       {
        $message .= getPhrase('\ncannot_send_email_to_user, please_check_your_server_settings');
        $exception = 1;
       }

    	}
    	else {
    	//PAYMENT RECORD IS NOT VALID
    	//PREPARE METHOD FOR FAILED CASE
    	  pageNotFound();
    	}
		//REDIRECT THE USER BY LOADING A VIEW
	
    	return redirect(URL_PAYMENTS_LIST.$user->slug);
    	
    }


    public function payu_success(Request $request)
    {

       $response = $request->all();
        $package_name = ucwords($response['productinfo']);

         $user = Auth::user();
        if($this->paymentSuccess($request))
      {
        //PAYMENT RECORD UPDATED SUCCESSFULLY
        //PREPARE SUCCESS MESSAGE
        
        $email_template = 'subscription_success';
        $message = 'your_subscription_was_successfull';
        try{
          sendEmail($email_template, array('username'=>$user->name, 
          'plan' => $package_name,
          'to_email' => $user->email));
        }
        catch(Exception $ex)
       {
        
        $message .= getPhrase('\ncannot_send_email_to_user, please_check_your_server_settings');
        $exception = 1;
       }

          flash('success', $message, 'overlay');
      }
        else {
      //PAYMENT RECORD IS NOT VALID
      //PREPARE METHOD FOR FAILED CASE
        pageNotFound();
      }
    //REDIRECT THE USER BY LOADING A VIEW
     
      return redirect(URL_PAYMENTS_LIST.$user->slug);

    }

     public function payu_cancel(Request $request)
    {
      if($this->paymentFailed())
      {
        //FAILED PAYMENT RECORD UPDATED SUCCESSFULLY
        //PREPARE SUCCESS MESSAGE
          flash('Ooops...!', 'your_payment_was cancelled', 'overlay');
      }
      else {
      //PAYMENT RECORD IS NOT VALID
      //PREPARE METHOD FOR FAILED CASE
        pageNotFound();
      }

      //REDIRECT THE USER BY LOADING A VIEW
      $user = Auth::user();
      return redirect(URL_PAYMENTS_LIST.$user->slug);
       
    }


    /**
     * This method saves the record before going to payment method
     * The exact record can be identified by using the slug 
     * By using slug we will fetch the record and update the payment status to completed
     * @param  [type] $item           [description]
     * @param  [type] $payment_method [description]
     * @return [type]                 [description]
     */
    public function preserveBeforeSave($item, $package_type,$payment_method, $other_details,$coupon_zero=0)
    {
      // dd($item);
      $user = getUserRecord();
     if($other_details['paid_by_parent']) 
	      $user = getUserRecord($other_details['child_id']);

      $payment 					= new Payment();
	    $payment->item_id 		= $item->id;
      $payment->item_name 		= $item->title;
      $payment->plan_type 		= $package_type;
      $payment->payment_gateway = $payment_method;
      $payment->slug 			= $payment::makeSlug(getHashCode());
      $payment->cost 			= $item->cost;
      $payment->user_id     = $user->id;
      $payment->paid_by_parent 		= $other_details['paid_by_parent'];
      $payment->payment_status 	= PAYMENT_STATUS_PENDING;
      $payment->other_details 	= json_encode($other_details);
      if(!$coupon_zero)
      {
        if($payment_method=='offline')
        $payment->notes = $other_details['payment_details'];  
      }
      $payment->save();
      return $payment->slug;
    }

    /**
     * Common method to handle payment failed records
     * @return [type] [description]
     */
    protected function paymentFailed()
    {
      if(env('DEMO_MODE')) {
       return TRUE;
      }

    	$params = explode('?token=',$_SERVER['REQUEST_URI']) ;
    
     if(!count($params))
      return FALSE;
    
    $slug = $params[1];
    	$payment_record = Payment::where('slug', '=', $slug)->first();
     

     	if(!$this->processPaymentRecord($payment_record))
     	{
    		return FALSE;
     	}
	
		$payment_record->payment_status = PAYMENT_STATUS_CANCELLED;
    	$payment_record->save();
    	
    	return TRUE;
    	 
    }

    /**
     * Common method to handle success payments
     * @return [type] [description]
     */
    protected function paymentSuccess(Request $request)
    {

       if(env('DEMO_MODE')) {
       return TRUE;
      }

    	$params = explode('?token=',$_SERVER['REQUEST_URI']) ;
    
     if(!count($params))
      return FALSE;
    
    $slug = $params[1];
    	
    	 
   
    	$payment_record = Payment::where('slug', '=', $slug)->first();
    	
    	if($this->processPaymentRecord($payment_record))
    	{
    		$payment_record->payment_status = PAYMENT_STATUS_SUCCESS;
        $item_details = '';

        if($payment_record->plan_type == 'combo')
        {
          $item_model = new ExamSeries();
        }
        

        if($payment_record->plan_type == 'exam') {
          $item_model = new Quiz();
        }

        if($payment_record->plan_type == 'lms') {
          $item_model = new LmsSeries();
        }

    		$item_details = $item_model->where('id', '=',$payment_record->item_id)->first();
    		 
    		
        $daysToAdd = '+'.$item_details->validity.'days';

    		$payment_record->start_date = date('Y-m-d');
    		$payment_record->end_date = date('Y-m-d', strtotime($daysToAdd));
    		
    		$details_before_payment         = (object)json_decode($payment_record->other_details);
        $payment_record->coupon_applied = $details_before_payment->is_coupon_applied;
        $payment_record->coupon_id      = $details_before_payment->coupon_id;
        $payment_record->actual_cost    = $details_before_payment->actual_cost;
    		$payment_record->discount_amount= $details_before_payment->discount_availed;
    		$payment_record->after_discount = $details_before_payment->after_discount;
    		if($payment_record->payment_gateway=='paypal') {
      		$payment_record->paid_amount = $request->mc_gross;
  			  $payment_record->transaction_id = $request->txn_id;
      		$payment_record->paid_by = $request->payer_email;
        }

    		//Capcture all the response from the payment.
    		//In case want to view total details, we can fetch this record
    		$payment_record->transaction_record = json_encode($request->request->all());
    		
    		$payment_record->save();

        if($payment_record->coupon_applied)
        {
          $this->couponcodes_usage($payment_record);
        }


    		return TRUE;
    	}
      return FALSE;
    }

    public function couponcodes_usage($payment_record)
    {
          $coupon_usage['user_id'] = $payment_record->user_id;
          $coupon_usage['item_id'] = $payment_record->item_id;
          $coupon_usage['item_type'] = $payment_record->plan_type;
          $coupon_usage['item_cost'] = $payment_record->actual_cost;
          $coupon_usage['total_invoice_amount'] = $payment_record->paid_amount;
          $coupon_usage['discount_amount'] = $payment_record->discount_amount;
          $coupon_usage['coupon_id'] = $payment_record->coupon_id;
          $coupon_usage['updated_at'] =  new \DateTime();
          DB::table('couponcodes_usage')->insert($coupon_usage);
          return TRUE;
    }

    /**
     * This method validates the payment record before update the payment status
     * @param  [type]  $payment_record [description]
     * @return boolean                 [description]
     */
    protected function isValidPaymentRecord(Payment $payment_record)
    {
    	$valid = FALSE;
    	if($payment_record)
    	{
    		if($payment_record->payment_status == PAYMENT_STATUS_PENDING || $payment_record->payment_gateway=='offline')
    			$valid = TRUE;
    	}
    	return $valid;
    }

    /**
     * This method checks the age of the payment record
     * If the age is > than MAX TIME SPECIFIED (30 MINS), it will update the record to aborted state
     * @param  payment $payment_record [description]
     * @return boolean                 [description]
     */
    protected function isExpired(Payment $payment_record)
    {

    	$is_expired = FALSE;
    	$to_time = strtotime(Carbon\Carbon::now());
		$from_time = strtotime($payment_record->updated_at);
		$difference_time = round(abs($to_time - $from_time) / 60,2);

		if($difference_time > PAYMENT_RECORD_MAXTIME)
		{
			$payment_record->payment_status = PAYMENT_STATUS_CANCELLED;
			$payment_record->save();
			return $is_expired =  TRUE;
		}
		return $is_expired;
    }

    /**
     * This method Process the payment record by validating through 
     * the payment status and the age of the record and returns boolen value
     * @param  Payment $payment_record [description]
     * @return [type]                  [description]
     */
    protected  function processPaymentRecord(Payment $payment_record)
    {

    	if(!$this->isValidPaymentRecord($payment_record))
    	{
    		flash('Oops','invalid_record', 'error');
    		return FALSE;
    	}

    	if($this->isExpired($payment_record))
    	{
    		flash('Oops','time_out', 'error');
    		return FALSE;
    	}

    	return TRUE;
    }


    /**
     * This method handles the request before payment page
     * It shows the checkout page and gives an option for coupon codes
     * @param  [type] $slug [description]
     * @return [type]       [description]
     */
    public function checkout($type, $slug)
    {

      $record = $this->getModelName($type, $slug);

        if($isValid = $this->isValidRecord($record))
          return redirect($isValid);  
        
        $user = Auth::user();
        //Check if user is already paid to the same item and the item is in valid date
        if(Payment::isItemPurchased($record->id, $type, $user->id))
        {
          //User already purchased this item and it is valid
          //Return the user to back by the message
          flash('Hey '.$user->name, 'you_already_purchased_this_item', 'overlay');
          return back();
        }
        $active_class = 'lms';
        if($type == 'combo' || $type=='exams'|| $type=='exam')
          $active_class = 'exams';
      	$data['active_class']       = $active_class;
        $data['pay_by']             = '';
        $data['title']              = $record->title;
        $data['item_type']          = $type;
        $data['item']               = $record;
        $data['right_bar']          = TRUE;
        $data['right_bar_class']   	= 'order-user-details';
        $data['right_bar_path']     = 'student.payments.billing-address-right-bar';
        $data['right_bar_data']     = array(
                                            'item' => $record,
                                            );

        $data['layout']              = getLayout();
        $data['parent_user'] = FALSE;
        if(checkRole(getUserGrade(7)))
        {
          $data['parent_user'] = TRUE;
          $data['children'] = App\User::where('parent_id', '=', $user->id)->get();
          
        }

       return view('student.payments.checkout', $data);

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
    	return URL_EXAM_SERIES;
    }

    /**
     * This method saves the submitted data from user and waits for the admin approval
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function updateOfflinePayment(Request $request)
    {
     
      $payment_data = json_decode($request->payment_data);
      $item = $this->getPackageDetails($payment_data->type, $payment_data->item_name);

      if(!$item)
      {
        dd('failed');
      }
      
      $other_details = array();
      $other_details['is_coupon_applied'] = $payment_data->is_coupon_applied;
      $other_details['actual_cost']       = $payment_data->actual_cost;
      $other_details['discount_availed']  = $payment_data->discount_availed;
      $other_details['after_discount']    = $payment_data->after_discount;
      $other_details['coupon_id']         = $payment_data->coupon_id;
      $other_details['paid_by_parent']    = $payment_data->parent_user;
      $other_details['child_id']          = $payment_data->selected_child_id;
      $other_details['payment_details']   = $request->payment_details;

      $payment_gateway = $payment_data->gateway;
      $token = $this->preserveBeforeSave($item,$payment_data->type, $payment_gateway, $other_details);
      flash('success', 'your_request_was_submitted_to_admin', 'overlay');          
      return redirect(URL_PAYMENTS_LIST.Auth::user()->slug);
    }

    public function approveOfflinePayment(Request $request)
    {

      $payment_record = Payment::where('id','=',$request->record_id)->first();
       $message = '';

      if($request->submit == 'approve')
      {
        $this->approvePayment($payment_record, $request);
      }
      else {
        $user = getUserRecord($payment_record->user_id);

         $payment_record->payment_status = PAYMENT_STATUS_CANCELLED;
         $payment_record->admin_comments = $request->admin_comment;

        $payment_record->save();
        $message = 'record_was_updated_successfully';
        try{
        sendEmail('offline_subscription_failed', array('username'=>$user->name, 
          'plan' => $payment_record->plan_type,
          'to_email' => $user->email, 'admin_comment'=>$request->admin_comment));
      }
       catch(Exception $ex)
       {
               $message .= getPhrase('\ncannot_send_email_to_user, please_check_your_server_settings');
        $exception = 1;
       }


      }
      flash('success', $message, 'overlay');
      return redirect(URL_OFFLINE_PAYMENT_REPORTS);
    }

    public function overallPayments($slug)
    {
       $paymentObject = new Payment();

      $payments = Payment::where('payment_status', '=', 'success')->get();
      $payments = Payment::all();

      $data['active_class']       = 'analysis';
      $data['title']              = getPhrase('quiz_attempts');

      $data['exam_record']        = $exam_record;
      
        $data['layout']             = getLayout();

      return view('payments.reports.overall-analysis', $data);  
    }


    /**
     * This method redirects the user to view the onlinepayments reports dashboard
     * It contains an optional slug, if slug is null it will redirect the user to dashboard
     * If the slug is success/failed/cancelled/all it will show the appropriate result based on slug status from payments table
     * @param  string $slug [description]
     * @return [type]       [description]
     */
    public function onlinePaymentsReport()
    {

      if(!checkRole(getUserGrade(2)))
      {
        prepareBlockUserMessage();
        return back();
      }


      $data['active_class']       = 'reports';
      $data['title']              = getPhrase('online_payments');
      $data['payments']           = (object)$this->prepareSummaryRecord('online');
      $data['payments_chart_data']= (object)$this->getPaymentStats($data['payments']);
      $data['payments_monthly_data'] = (object)$this->getPaymentMonthlyStats();
      $data['payment_mode']      = 'online';
      $data['layout']             = getLayout();
      return view('payments.reports.payments-report', $data);  
    }

    /**
     * This method list the details of the records
     * @param  [type] $slug [description]
     * @return [type]       [description]
     */
    public function listOnlinePaymentsReport($slug)
    {
     if(!checkRole(getUserGrade(2)))
      {
        prepareBlockUserMessage();
        return back();
      }
      if(!in_array($slug, ['all','pending', 'success','cancelled']))
      {
        pageNotFound();
        return back();
      }

      $payment = new Payment();
       $this->updatePaymentTransactionRecords($payment->updateTransactionRecords('online'));

        $data['active_class']       = 'reports';
        $data['payments_mode']      = getPhrase('online_payments');
        if($slug=='all'){
           $data['title']              = getPhrase('all_payments');
       
        }
        elseif($slug=='success'){
        $data['title']              = getPhrase('success_list');
          }
        elseif($slug=='pending'){
        $data['title']              = getPhrase('pending_list');
          }
       elseif($slug='cancelled'){
           $data['title']              = getPhrase('cancelled_list');
         }
        $data['layout']             = getLayout();
        $data['ajax_url']           = URL_ONLINE_PAYMENT_REPORT_DETAILS_AJAX.$slug;
        $data['payment_mode']       = 'online';
        return view('payments.reports.payments-report-list', $data);   
    }

    public function updatePaymentTransactionRecords($records)
    {

      foreach($records as $record)
      {
        $rec = Payment::where('id',$record->id)->first();
        $this->isExpired($rec);
      }
    }

     public function getOnlinePaymentReportsDatatable($slug)
    {

      if(!checkRole(getUserGrade(2)))
      {
        prepareBlockUserMessage();
        return back();
      }
    
     $records = Payment::join('users', 'users.id','=','payments.user_id')

     ->select(['users.image', 'users.name',  'item_name', 'plan_type', 'start_date', 'end_date', 'payment_gateway','payments.updated_at','payment_status','payments.cost', 'payments.after_discount', 'payments.paid_amount','payments.id' ])
     ->where('payment_gateway', '!=', 'offline')
     ->orderBy('updated_at', 'desc');
     if($slug!='all')
      $records->where('payment_status', '=', $slug);
      return Datatables::of($records)
      
        ->editColumn('payment_status',function($records){

          $rec = '';
          if($records->payment_status==PAYMENT_STATUS_CANCELLED)
           $rec = '<span class="label label-danger">'.ucfirst($records->payment_status).'</span>';
          elseif($records->payment_status==PAYMENT_STATUS_PENDING)
            $rec = '<span class="label label-info">'.ucfirst($records->payment_status).'</span>';
          elseif($records->payment_status==PAYMENT_STATUS_SUCCESS)
            $rec = '<span class="label label-success">'.ucfirst($records->payment_status).'</span>';
          return $rec;
        })
        ->editColumn('image', function($records) {
           return '<img src="'.getProfilePath($records->image).'"  /> '; 
        })
        ->editColumn('name', function($records)
        {
          return ucfirst($records->name);
        })
        
        ->editColumn('plan_type', function($records)
        {
          return ucfirst($records->plan_type);
        })
        ->editColumn('payment_gateway', function($records)
        {
          $text =  ucfirst($records->payment_gateway);

         if($records->payment_status==PAYMENT_STATUS_SUCCESS) {
          $extra = '<ul class="list-unstyled payment-col clearfix"><li>'.$text.'</li>';
          $extra .='<li><p>Cost:'.$records->cost.'</p><p>Aftr Dis.:'.$records->after_discount.'</p><p>Paid:'.$records->paid_amount.'</p></li></ul>';
          return $extra;
        }
          return $text;
        })
        ->editColumn('start_date', function($records)
        {
          if($records->payment_status==PAYMENT_STATUS_CANCELLED || $records->payment_status==PAYMENT_STATUS_PENDING)
            return '-';
          return $records->start_date;
        })
        ->editColumn('end_date', function($records)
        {
          if($records->payment_status==PAYMENT_STATUS_CANCELLED || $records->payment_status==PAYMENT_STATUS_PENDING)
            return '-';
          return $records->end_date;
        })
        
        ->removeColumn('id')
        ->removeColumn('users.image')
        ->removeColumn('action')
        ->make();     
    }


    /**
     * This method redirects the user to view the onlinepayments reports dashboard
     * It contains an optional slug, if slug is null it will redirect the user to dashboard
     * If the slug is success/failed/cancelled/all it will show the appropriate result based on slug status from payments table
     * @param  string $slug [description]
     * @return [type]       [description]
     */
    public function offlinePaymentsReport()
    {
      if(!checkRole(getUserGrade(2)))
      {
        prepareBlockUserMessage();
        return back();
      }

      $data['active_class']       = 'reports';
      $data['title']              = getPhrase('offline_payments');
      $data['payments']           = (object)$this->prepareSummaryRecord('offline');

      $data['payments_chart_data'] = (object)$this->getPaymentStats($data['payments']);
      $data['payments_monthly_data'] = (object)$this->getPaymentMonthlyStats('offline', '=');
      $data['payment_mode']       = 'offline';

      
      $data['layout']             = getLayout();

      return view('payments.reports.payments-report', $data);  
    }

    /**
     * This method list the details of the records
     * @param  [type] $slug [description]
     * @return [type]       [description]
     */
    public function listOfflinePaymentsReport($slug)
    {
      if(!in_array($slug, ['all','pending', 'success','cancelled']))
      {
        pageNotFound();
        return back();
      }


        $data['active_class']       = 'reports';
        $data['payments_mode']      = getPhrase('offline_payments');
         if($slug=='all'){
           $data['title']              = getPhrase('all_payments');
       
        }
        elseif($slug=='success'){
        $data['title']              = getPhrase('success_list');
          }
        elseif($slug=='pending'){
        $data['title']              = getPhrase('pending_list');
          }
       elseif($slug='cancelled'){
           $data['title']              = getPhrase('cancelled_list');
         }   
        $data['layout']             = getLayout();
        $data['ajax_url']           = URL_OFFLINE_PAYMENT_REPORT_DETAILS_AJAX.$slug;
        $data['payment_mode']       = 'offline';


        return view('payments.reports.payments-report-list', $data);   
    }

    /**
     * This method gets the list of records 
     * @param  [type] $slug [description]
     * @return [type]       [description]
     */
    public function getOfflinePaymentReportsDatatable($slug)
    {
      if(!checkRole(getUserGrade(2)))
      {
        prepareBlockUserMessage();
        return back();
      }
    
     $records = Payment::join('users', 'users.id','=','payments.user_id')

     ->select(['users.image', 'users.name',  'item_name', 'plan_type', 'start_date', 'end_date', 'payment_gateway', 'payments.updated_at','payment_status','payments.id','payments.cost', 'payments.after_discount', 'payments.paid_amount'])
     ->where('payment_gateway', '=', 'offline')
     ->orderBy('updated_at', 'desc');
     if($slug!='all')
      $records->where('payment_status', '=', $slug);
      return Datatables::of($records)
      
        ->editColumn('payment_status',function($records){

          $rec = '';
          if($records->payment_status==PAYMENT_STATUS_CANCELLED)
           $rec = '<span class="label label-danger">'.ucfirst($records->payment_status).'</span>';
          elseif($records->payment_status==PAYMENT_STATUS_PENDING) {
            $rec = '<span class="label label-info">'.ucfirst($records->payment_status).'</span>&nbsp;<button class="btn btn-primary btn-sm" onclick="viewDetails('.$records->id.');">'.getPhrase('view_details').'</button>';
          }
          elseif($records->payment_status==PAYMENT_STATUS_SUCCESS)
            $rec = '<span class="label label-success">'.ucfirst($records->payment_status).'</span>';
          return $rec;
        })
        ->editColumn('image', function($records){
           return '<img src="'.getProfilePath($records->image).'"  /> '; 
        })
        ->editColumn('name', function($records)
        {
          return ucfirst($records->name);
        })
         ->editColumn('payment_gateway', function($records)
        {
          $text =  ucfirst($records->payment_gateway);

         if($records->payment_status==PAYMENT_STATUS_SUCCESS) {
          $extra = '<ul class="list-unstyled payment-col clearfix"><li>'.$text.'</li>';
          $extra .='<li><p>Cost:'.$records->cost.'</p><p>Aftr Dis.:'.$records->after_discount.'</p><p>Paid:'.$records->paid_amount.'</p></li></ul>';
          return $extra;
        }
          return $text;
        })
        
        ->editColumn('plan_type', function($records)
        {
          return ucfirst($records->plan_type);
        })
        ->editColumn('start_date', function($records)
        {
          if($records->payment_status==PAYMENT_STATUS_CANCELLED || $records->payment_status==PAYMENT_STATUS_PENDING)
            return '-';
          return $records->start_date;
        })
        ->editColumn('end_date', function($records)
        {
          if($records->payment_status==PAYMENT_STATUS_CANCELLED || $records->payment_status==PAYMENT_STATUS_PENDING)
            return '-';
          return $records->end_date;
        })
        
        ->removeColumn('id')
        ->removeColumn('users.image')
        ->removeColumn('action')
        ->make();     
    }

    /**
     * This method prepares different variations of reports based on the type
     * This is a common method to prepare online, offline and overall reports
     * @param  string $type [description]
     * @return [type]       [description]
     */
    public function prepareSummaryRecord($type='overall')
    {

      $payments = [];
      if($type=='online') {
        $payments['all'] = $this->getRecordsCount('online');

        $payments['success'] = $this->getRecordsCount('online', 'success');
        $payments['cancelled'] = $this->getRecordsCount('online', 'cancelled');
        $payments['pending'] = $this->getRecordsCount('online', 'pending');
      }
      else if($type=='offline') {
        $payments['all'] = $this->getRecordsCount('offline');

        $payments['success'] = $this->getRecordsCount('offline', 'success');
        $payments['cancelled'] = $this->getRecordsCount('offline', 'cancelled');
        $payments['pending'] = $this->getRecordsCount('offline', 'pending');
      }

      return $payments;
    }

    /**
     * This is a helper method for fetching the data and preparing payment records count
     * @param  [type] $type   [description]
     * @param  string $status [description]
     * @return [type]         [description]
     */
    public function getRecordsCount($type, $status='')
    {
      $count = 0;
      if($type=='online') {
        if($status=='')
          $count = Payment::where('payment_gateway', '!=', 'offline')->count();

        else
        {
          $count = Payment::where('payment_gateway', '!=', 'offline')
                            ->where('payment_status', '=', $status)
                            ->count();
        }
      }      
      else if($type=='offline')
      {
         if($status=='')
          $count = Payment::where('payment_gateway', '=', 'offline')->count();

        else
        {
          $count = Payment::where('payment_gateway', '=', 'offline')
                            ->where('payment_status', '=', $status)
                            ->count();
        } 
      }


      return $count;
    }

    /**
     * This method prepares the chart data for success and failed records
     * @param  [type] $payment_data [description]
     * @return [type]               [description]
     */
    public function getPaymentStats($payment_data)
    {
      if(!checkRole(getUserGrade(2)))
      {
        prepareBlockUserMessage();
        return back();
      }
        
            $payment_dataset = [$payment_data->success, $payment_data->cancelled, $payment_data->pending];
            $payment_labels = [getPhrase('success'), getPhrase('cancelled'), getPhrase('pending')];
            $payment_dataset_labels = [getPhrase('total')];

            $payment_bgcolor = [getColor('',4),getColor('',9),getColor('',18)];
            $payment_border_color = [getColor('background',4),getColor('background',9),getColor('background',18)]; 

          $payments_stats['data']    = (object) array(
                                        'labels'            => $payment_labels,
                                        'dataset'           => $payment_dataset,
                                        'dataset_label'     => $payment_dataset_labels,
                                        'bgcolor'           => $payment_bgcolor,
                                        'border_color'      => $payment_border_color
                                        );
           $payments_stats['type'] = 'bar'; 
             $payments_stats['title'] = getPhrase('overall_statistics');

           return $payments_stats;
    }

     /**
     * This method returns the overall monthly summary of the payments made with status success
     * @return [type] [description]
     */
    public function getPaymentMonthlyStats($type = 'offline',$symbol='!=')
    {
      if(!checkRole(getUserGrade(2)))
      {
        prepareBlockUserMessage();
        return back();
      }
          $paymentObject = new App\Payment();
            $payment_data = (object)$paymentObject->getSuccessMonthlyData('',$type, $symbol);
            

            $payment_dataset = [];
            $payment_labels = [];
            $payment_dataset_labels = [getPhrase('total')];
            $payment_bgcolor = [];
            $payment_border_color = []; 


            foreach($payment_data as $record)
            {
              $color_number = rand(0,999);;
              $payment_dataset[] = $record->total;
              $payment_labels[]  = $record->month;
              $payment_bgcolor[] = getColor('',$color_number);
              $payment_border_color[] = getColor('background', $color_number);

            }

          $payments_stats['data']    = (object) array(
                                        'labels'            => $payment_labels,
                                        'dataset'           => $payment_dataset,
                                        'dataset_label'     => $payment_dataset_labels,
                                        'bgcolor'           => $payment_bgcolor,
                                        'border_color'      => $payment_border_color
                                        );
           $payments_stats['type'] = 'line'; 
           $payments_stats['title'] = getPhrase('payments_reports_in').' '.getCurrencyCode(); 

           return $payments_stats;
    }

    /**
     * This method displays the form for export payments list with different combinations
     * @return [type] [description]
     */
    public function exportPayments()
    {
      if(!checkRole(getUserGrade(2)))
      {
        prepareBlockUserMessage();
        return back();
      }
        $data['active_class']       = 'reports';
        $data['title']              = getPhrase('export_payments_report');
        $data['layout']             = getLayout();
        $data['record']             = FALSE;

        return view('payments.reports.payments-export', $data);        
    }

    public function doExportPayments(Request $request)
    {
      if(!checkRole(getUserGrade(2)))
      {
        prepareBlockUserMessage();
        return back();
      }
        $columns = array(
        'all_records'  => 'bail|required'
        );

        if($request->all_records==0)
        {
          $columns['from_date'] = 'bail|required';
          $columns['to_date']    = 'bail|required';
        }

        $this->validate($request,$columns);

        $payment_status = $request->payment_status;
        $payment_type = $request->payment_type;
        $record_type  = $request->all_records;
        $from_date = '';
        $to_date = '';
        
        if(!$record_type)
        {
          $from_date = $request->from_date;
          $to_date = $request->to_date;
        }
        $records = [];
        $query = '';
        
        if($payment_status=='all' && $payment_type=='all' && $record_type=='1')
        {

          $query =  Payment::whereRaw("1 = 1");
        }
        else {
        
            if($record_type==0)
            {
              $query = Payment::where('created_at', '>=', $from_date) 
                                ->where('created_at', '<=', $to_date);

            }
            else {

              $query =  Payment::whereRaw("1 = 1");
            }
            
            if($payment_type!='all')
            {

              if($payment_type=='online') {
              $query->where('payment_gateway','!=','offline');
            }
            else {
              $query->where('payment_gateway','=','offline');
            }


            }

            if($payment_status!='all')
            {
              $query->where('payment_status', '=', $payment_status);
            }
          
        }
        $records = $query->get();
        $this->payment_records = $records;

     $this->downloadExcel();
       
    }

  public function getPaymentRecords()
  {
    return $this->payment_records;
  }
  
  public function downloadExcel()
  {
  if(!checkRole(getUserGrade(2)))
      {
        prepareBlockUserMessage();
        return back();
      }
    Excel::create('payments_report', function($excel) {
      $excel->sheet('payments_records', function($sheet) {
      $sheet->row(1, array('sno','ItemID', 'Purchased Item Name','User ID','Plan Startdate','Plan Enddate','Subscription Type', 'Payment Gateway', 'TransactionID','Paid by parent', 'Paid UserID', 'Cost', 'Coupon Applied', 'CouponID', 'Actual Cost', 'Discount Amount', 'After Discount', 'Paid Amount', 'Payment status', 'created_datetime','updated_datetime'));
      $records = $this->getPaymentRecords();
      $cnt = 2;
      foreach ($records as $item) {
        $item_type = ucfirst($item->plan_type);
        if($item->plan_type=='combo')
          $item_type = 'Exam Series';

        $sheet->appendRow($cnt, array(($cnt-1), $item->item_id, $item->item_name, $item->user_id, $item->start_date, $item->end_date, $item_type, $item->payment_gateway, $item->transaction_id, $item->paid_by_parent, $item->paid_by, $item->cost, $item->coupon_applied, $item->coupon_id, $item->actual_cost, $item->discount_amount, $item->after_discount, $item->paid_amount, $item->payment_status, $item->created_at, $item->updated_at));
        $cnt++;
      }
    });
 

    })->download('xlsx');
}

public function getPaymentRecord(Request $request)
{
  if(!checkRole(getUserGrade(2)))
      {
        prepareBlockUserMessage();
        return back();
      }
  $payment_record = Payment::where('id','=',$request->record_id)->first();
  $result['status'] = 0;
  $result['record'] = null;
  if($payment_record)
  {
    $result['status'] = 1;
    $result['record'] = $payment_record;
  }
  return json_encode($result);
}

public function validateAndApproveZeroDiscount($token, Request $request)
{
  
    $payment_record = Payment::where('slug','=',$token)->first();
    
     
    return $this->approvePayment($payment_record,$request, 1);
     
}

public function approvePayment(Payment $payment_record,Request $request ,$iscoupon_zero = 0)
{

      

        if($payment_record->plan_type == 'combo')
        {
          $item_model = new ExamSeries(); 
        }
        

        if($payment_record->plan_type == 'exam') {
          $item_model = new Quiz();
        }

        if($payment_record->plan_type == 'lms') {
          $item_model = new LmsSeries();
        }
        
        $item_details = $item_model->where('id', '=',$payment_record->item_id)->first();
         
        $daysToAdd = '+'.$item_details->validity.'days';

        $payment_record->start_date = date('Y-m-d');
        $payment_record->end_date = date('Y-m-d', strtotime($daysToAdd));
        
        $details_before_payment         = (object)json_decode($payment_record->other_details);
        $payment_record->coupon_applied = $details_before_payment->is_coupon_applied;
        $payment_record->coupon_id      = $details_before_payment->coupon_id;
        $payment_record->actual_cost    = $details_before_payment->actual_cost;
        $payment_record->discount_amount= $details_before_payment->discount_availed;
        $payment_record->after_discount = $details_before_payment->after_discount;
        $payment_record->paid_amount = $details_before_payment->after_discount;
        if(!$iscoupon_zero)
          $payment_record->admin_comments = $request->admin_comment;

        $payment_record->payment_status = PAYMENT_STATUS_SUCCESS;
        
        $user = getUserRecord($payment_record->user_id);

        $email_template = 'offline_subscription_success';
        try{
        if($iscoupon_zero){
          $email_template = 'subscription_success';
        
          sendEmail($email_template, array('username'=>$user->name, 
          'plan' => $payment_record->plan_type,
          'to_email' => $user->email));
        }


        else {
          sendEmail($email_template, array('username'=>$user->name, 
          'plan' => $payment_record->plan_type,
          'to_email' => $user->email, 'admin_comment'=>$request->admin_comment));
        }
      }
        catch(Exception $ex)
       {
        
        $message .= getPhrase('\ncannot_send_email_to_user, please_check_your_server_settings');
        $exception = 1;
       }

         $payment_record->save();

        if($payment_record->coupon_applied)
        {
          $this->couponcodes_usage($payment_record);
        }

        return TRUE;
  }
    
}
