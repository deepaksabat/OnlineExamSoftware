<?php

namespace App\Http\Controllers;
use \App;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Lmscategory;
use App\LmsContent;
use App\Plan;
use Yajra\Datatables\Datatables;
use DB;
use Auth;
 

class SubscriptionsController extends Controller
{
     
    public function __construct()
    {
    	$this->middleware('auth');
    }

    public function index($user_slug='')
    {
        if(isSubscribed())
        {
            flash('success', 'you already subscribed to use this system...', 'overlay');
            return back();
        }
        $user = FALSE;
        if($user_slug)
        $user                       =  getUserWithSlug($user_slug);
        $data['user']               = $user;
        $data['active_class']       = 'subscriptions';
    	$data['plans']              = Plan::all();
        $data['title']              = getPhrase('subscription_plans');
        $data['layout']             = getLayout();
    	return view('payments.payform', $data);
    }

    /**
     * This method does the subscription process
     * If User slug is passed as parameter the subscription will be done to 
     * the specified slug user
     * If the slug is empty, the subscription will be done to the loggedin user
     * @param  Request $request   [description]
     * @param  [type]  $plan_slug [description]
     * @return [type]             [description]
     */
    public function subscribe(Request $request, $plan_slug, $user_slug='')
    {   
         if(isSubscribed())
        {
            flash('success', 'you already subscribed to use this system...', 'overlay');
            return back();
        }
        
        $record           = Plan::where('slug', $plan_slug)->get()->first();
		$cardToken        = $request->stripeToken;
		$cardEmail        = $request->stripeEmail;
        
        $user             = getUserWithSlug();
        if($user_slug)
            $user = getUserWithSlug($user_slug);

       $result              = $user->newSubscription($record->type, strtolower($record->name))
                            ->create($cardToken);
       $data['active_class'] = 'subscriptions';
       $data['title']       = getPhrase('subscription_was_successfull');
       $data['id']          = $result->stripe_id;
       $data['plan']        = $result->stripe_plan;
       $data['layout']      = getLayout();
       
       sendEmail('subscription', 
                    array('to_email' => $user->email,'username'=>$user->name, 
                        'plan' => $result->stripe_plan, 
                        'id' => $result->stripe_id)
                    );
       return view('payments.payment-status', $data);
    }   

    /**
     * This method allows to view the list of subscriptions made by user
     * @return [type] [description]
     */
    public function listInvoices($slug)
    {

         $record        = getUserWithSlug($slug);
         if($isValid    = $this->isValidRecord($record))
         return redirect($isValid);
       
       /**
        * Validate the non-admin user wether is trying to access other user profile
        * If so return the user back to previous page with message
        */

        if(!isEligible($slug))
          return back();

        if(!isSubscribed())
        {
            flash('Ooops...!', 'currently_you_have_not_subscribed_to_any_plan', 'overlay');
            return back();
        }


        $data['active_class']       = 'subscriptions';
        $data['invoices']           = $record->invoices();
        $data['title']              = getPhrase('invoices');
        $data['layout']             = getLayout();

        if(checkRole(['parent']))
            $data['active_class']       = 'children';
        return view('payments.invoices', $data);
    }

    /**
     * This method allows to generate the detailed PDF report
     * @param  Request $request   [description]
     * @param  [type]  $invoiceId [description]
     * @return [type]             [description]
     */
    function downloadInvoice(Request $request, $invoiceId) {
        $settings = getSettings('subscription');
    return $request->user()->downloadInvoice($invoiceId, [
        'vendor'  => $settings->invoice_company_name,
        'product' => $settings->invoice_product_name,
    ]);
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
      return '/';
    }
}
