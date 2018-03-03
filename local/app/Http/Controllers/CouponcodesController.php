<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App;
use App\Http\Requests;
use App\Couponcode;
use Yajra\Datatables\Datatables;
use DB;
use Auth;


class CouponcodesController extends Controller
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
      if(!checkRole(getUserGrade(2)))
      {
        prepareBlockUserMessage();
        return back();
      }

        $data['active_class']       = 'coupons';
        $data['title']              = getPhrase('coupon_codes');
    	return view('coupons.list', $data);
    }

    /**
     * This method returns the datatables data to view
     * @return [type] [description]
     */
    public function getDatatable($slug = '')
    {

      if(!checkRole(getUserGrade(2)))
      {
        prepareBlockUserMessage();
        return back();
      }

        $records = array();
 
             

            $records = Couponcode::select(['title', 'coupon_code', 'discount_type', 'discount_value', 'minimum_bill','discount_maximum_amount','usage_limit', 'status', 'id','slug' ])
            ->orderBy('updated_at', 'desc');
             

        return Datatables::of($records)
        ->addColumn('action', function ($records) {
         
          $link_data = '<div class="dropdown more">
                        <a id="dLabel" type="button" class="more-dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="mdi mdi-dots-vertical"></i>
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="dLabel">
                            <li><a href="'.URL_COUPONS_EDIT.$records->slug.'"><i class="fa fa-pencil"></i>'.getPhrase("edit").'</a></li>';
                            
                           $temp = '';
                           if(checkRole(getUserGrade(1))) {
                    $temp .= ' <li><a href="javascript:void(0);" onclick="deleteRecord(\''.$records->slug.'\');"><i class="fa fa-trash"></i>'. getPhrase("delete").'</a></li>';
                      }
                    
                    $temp .='</ul></div>';

                    $link_data .=$temp;
            return $link_data;
            })
        ->editColumn('status', function($records)
        {
            return ($records->status == 'Active') ? '<i class="fa fa-check text-success"></i>' : '<i class="fa fa-times text-danger"></i>';
        })
        
        ->removeColumn('id')
        ->removeColumn('slug')
        ->removeColumn('tags')
         
        ->make();
    }

    /**
     * This method loads the create view
     * @return void
     */
    public function create()
    {
      if(!checkRole(getUserGrade(2)))
      {
        prepareBlockUserMessage();
        return back();
      }
    	$data['record']         	= FALSE;
    	$data['active_class']       = 'coupons';
        $data['categories']           =array('exam'=>getPhrase('Quizzes'), 'combo'=>getPhrase('Examseries'), 'lms'=> getPhrase('LMS'));
    	$data['title']              = getPhrase('create_coupon');
    	return view('coupons.add-edit', $data);
    }

    /**
     * This method loads the edit view based on unique slug provided by user
     * @param  [string] $slug [unique slug of the record]
     * @return [view with record]       
     */
    public function edit($slug)
    {
      if(!checkRole(getUserGrade(2)))
      {
        prepareBlockUserMessage();
        return back();
      }

    	$record = Couponcode::getRecordWithSlug($slug);
    	if($isValid = $this->isValidRecord($record))
    		return redirect($isValid);

    	$data['record']       		= $record;
    	$data['active_class']     = 'coupons';
    	$data['settings']       	= FALSE;
       $data['categories']           =array('exam'=>getPhrase('Quizzes'), 'combo'=>getPhrase('Examseries'), 'lms'=> getPhrase('LMS'));
      	$data['title']            = getPhrase('edit_coupon');
    	return view('coupons.add-edit', $data);
    }

    /**
     * Update record based on slug and reuqest
     * @param  Request $request [Request Object]
     * @param  [type]  $slug    [Unique Slug]
     * @return void
     */
    public function update(Request $request, $slug)
    {
      if(!checkRole(getUserGrade(2)))
      {
        prepareBlockUserMessage();
        return back();
      }

    	$record = Couponcode::getRecordWithSlug($slug);
		 $rules = [
         'title'          	=> 'bail|required|max:60' ,
         'coupon_code'      => 'bail|unique:couponcodes,coupon_code,'.$record->id ,
         'discount_value'   => 'bail|required|numeric' ,
         'minimum_bill'     => 'bail|required|numeric' ,
         'discount_maximum_amount' => 'bail|required|numeric' ,
         'valid_from' 		=> 'bail|required|date' ,
         'valid_to' 		=> 'bail|required|date',
         'usage_limit' 		=> 'bail|required|integer',
            ];
         /**
        * Check if the title of the record is changed, 
        * if changed update the slug value based on the new title
        */
       $name = $request->title;
        if($name != $record->title)
            $record->slug = $record->makeSlug($name);
      
       //Validate the overall request
       $this->validate($request, $rules);

          $record->title          = $name;
        $record->coupon_code     = $request->coupon_code;
        $record->discount_type          = $request->discount_type;
        $record->discount_value     = $request->discount_value;
        $record->minimum_bill       = $request->minimum_bill;
        $record->discount_maximum_amount = $request->discount_maximum_amount;
        $record->valid_from         = $request->valid_from;
        $record->valid_to           = $request->valid_to;
        $record->usage_limit        = $request->usage_limit;
        $record->status             = $request->status;
        $record->record_updated_by  = Auth::user()->id;

        $applicable_categories['categories'] = [];
        if($request->has('applicability'))
        {
            foreach($request->applicability as $key=>$value)
                $applicable_categories['categories'][] = $key;
        }
        $record->coupon_code_applicability = json_encode($applicable_categories);
        $record->save();
        flash('success','record_updated_successfully', 'success');
    	return redirect(URL_COUPONS);
    }

    /**
     * This method adds record to DB
     * @param  Request $request [Request Object]
     * @return void
     */
    public function store(Request $request)
    {
      if(!checkRole(getUserGrade(2)))
      {
        prepareBlockUserMessage();
        return back();
      }

	    $rules = [
         'title'          	=> 'bail|required|max:60' ,
         'coupon_code'      => 'bail|unique:couponcodes,coupon_code' ,
         'discount_value'   => 'bail|required|numeric' ,
         'minimum_bill'     => 'bail|required|numeric' ,
         'discount_maximum_amount' => 'bail|required|numeric' ,
         'valid_from' 		=> 'bail|required|date' ,
         'valid_to' 		=> 'bail|required|date',
         'usage_limit' 		=> 'bail|required|integer',
            ];
        $this->validate($request, $rules);
        $record = new Couponcode();
      	$name  						=  $request->title;
		    $record->title 				= $name;
       	$record->slug 				= $record->makeSlug($name);
        $record->coupon_code		= $request->coupon_code;
        $record->discount_type			= $request->discount_type;
        $record->discount_value		= $request->discount_value;
        $record->minimum_bill		= $request->minimum_bill;
        $record->discount_maximum_amount = $request->discount_maximum_amount;
        $record->valid_from			= $request->valid_from;
        $record->valid_to			= $request->valid_to;
        $record->usage_limit		= $request->usage_limit;
        $record->status				= $request->status;
       	$record->record_updated_by 	= Auth::user()->id;

         $applicable_categories['categories'] = [];
        if($request->has('applicability'))
        {
            foreach($request->applicability as $key=>$value)
                $applicable_categories['categories'][] = $key;
        }
        $record->coupon_code_applicability = json_encode($applicable_categories);
        
        $record->save();


        $record->save();
        flash('success','record_added_successfully', 'success');
    	return redirect(URL_COUPONS);
    }
 
    /**
     * Delete Record based on the provided slug
     * @param  [string] $slug [unique slug]
     * @return Boolean 
     */
    public function delete($slug)
    {
      if(!checkRole(getUserGrade(2)))
      {
        prepareBlockUserMessage();
        return back();
      }
      /**
       * Delete the questions associated with this quiz first
       * Delete the quiz
       * @var [type]
       */
        $record = Couponcode::where('slug', $slug)->first();
        try{
            if(!env('DEMO_MODE')) {
                $record->delete();
            }
            $response['status'] = 1;
            $response['message'] = getPhrase('record_deleted_successfully');
        }
         catch ( \Illuminate\Database\QueryException $e) {
                 $response['status'] = 0;
           if(getSetting('show_foreign_key_constraint','module'))
            $response['message'] =  $e->errorInfo;
           else
            $response['message'] =  getPhrase('this_record_is_in_use_in_other_modules');
       }
        return json_encode($response);
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
    	return URL_COUPONS;
    }


    /**
     * Returns the list of subjects based on the requested subject
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function validateCoupon(Request $request)
    {
    	$coupon_code 		= $request->coupon_code;
        $user = getUserRecord($request->student_id);
    	$item_type 			= $request->item_type;
    	$purchased_amount 	= $request->cost;

    	$item 				= null;
    	if($item_type=='combo')
    	{
    		$item = App\ExamSeries::where('slug', '=', $request->item_name)->first();
    	}
        else if($item_type=='exam'){
            $item = App\Quiz::where('slug', '=', $request->item_name)->first();
        }
        else if($item_type=='lms'){
            $item = App\LmsSeries::where('slug', '=', $request->item_name)->first();
        }

    	if(!$item)
    		return json_encode(array('status'=>'0', 'message'=>'invalid item'));
    	

    	$couponObject 		= new Couponcode();
    	$couponRecord 		= $couponObject->checkValidity($coupon_code, $item_type);
    	$status 			= 0;
    	$discount_availed 	= 0;
    	$message 			= 'invalid';
    	$amount_to_pay 		= $purchased_amount;
    	$coupon_id			= 0;

    	if($couponRecord)
    	{
          	if($this->checkCouponUsage($couponRecord, $item, $item_type, $user))
    		{
    			//Coupon is valid
    			//Limit is not reached so do the follwoing operations
    			// 1) Check the minimum amount critria
    			// 2) Calculate discount eligiblity
    			// 3) Return the status message to user
    			if($purchased_amount>=$couponRecord->minimum_bill){
    				$discount_amount = $this->calculateDiscount($couponRecord, $purchased_amount);
    				$amount_to_pay = $purchased_amount - $discount_amount;
    				$discount_availed = $discount_amount;
    				if($amount_to_pay<0)
    					$amount_to_pay = 0;
    				$message 	= 'hey_you_are_eligible_for_discount';
    				$status 	= 1;
    				$coupon_id	= $couponRecord->id;
    			}
    			else {
    				$message = 'minimum_bill_not_reached. this_is_valid_for_minimum_purchase_of'.' '.getCurrencyCode().$couponRecord->minimum_bill;
    			}

    		}
    		else {
    			$message = 'limit_reached';
    		}

    	}
    	else
    	{
    		$message = 'invalid_coupon';
    	}

    	return json_encode(array(
    				'status'		=> $status, 
    				'message'		=> getPhrase($message), 
    				'amount_to_pay'	=> $amount_to_pay,
    				'discount' 		=> $discount_availed,
    				'coupon_id'		=> $coupon_id
    				));
    }

    /**
     * This method calculates the eligible discount for using for this coupon
     * @param  [type] $couponRecord     [description]
     * @param  [type] $purchased_amount [description]
     * @return [type]                   [description]
     */
    public function calculateDiscount($couponRecord, $purchased_amount)
    {
    	$discount_amount = 0;
    	if($couponRecord->discount_type == 'percent')
    	{
    		$actual_discount = ($purchased_amount * ($couponRecord->discount_value / 100));
    		if($actual_discount > $couponRecord->discount_maximum_amount)
    		{
    			$actual_discount = $couponRecord->discount_maximum_amount;
    		}
    		$discount_amount = $actual_discount;
    		if($discount_amount<0)
    			$discount_amount = 0;
    	}
    	else {
    		$discount_amount = $couponRecord->discount_value;
    	}

    	return $discount_amount;
    }

    /**
     * This method checks if the user is reached his limit for using this coupon
     * If the user reached, it returns FALSE
     * If the user not reached it returns TRUE
     * @param  [type] $couponRecord [description]
     * @param  [type] $item         [description]
     * @param  [type] $type         [description]
     * @param  [type] $user         [description]
     * @return [type]               [description]
     */
    public function checkCouponUsage($couponRecord, $item, $item_type, $user)
    {

        $recs = DB::table('couponcodes_usage')
                        ->where('user_id','=',$user->id)
                        ->where('coupon_id', '=', $couponRecord->id)
                        ->get();
    	
          $count = count($recs);
    	if($count >= $couponRecord->usage_limit)
    		return FALSE;
    	return TRUE;
    }
    
    public function getCouponUsage($value='')
    {
      if(!checkRole(getUserGrade(2)))
      {
        prepareBlockUserMessage();
        return back();
      }

        $data['active_class']       = 'coupons';
        $data['title']              = getPhrase('coupons_usage');
      return view('coupons.coupon-usage-list', $data);
    }
    /**
     * This method returns the ajax list of coupons
     * @return [type]       [description]
     */
    public function getCouponUsageData()
    {

    }

  


}
