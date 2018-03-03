<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use \App;

use App\Notification;
use Yajra\Datatables\Datatables;
use DB;
use Auth;

class NotificationsController extends Controller
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

        $data['active_class']       = 'notifications';
        $data['title']              = getPhrase('notifications');
        $data['layout']              = getLayout();
    	return view('notifications.list', $data);
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
 
             

            $records = Notification::select(['title', 'valid_from', 'valid_to', 'url', 'id','slug' ])
            ->orderBy('updated_at', 'desc');
             

        return Datatables::of($records)
        ->addColumn('action', function ($records) {
         
          $link_data = '<div class="dropdown more">
                        <a id="dLabel" type="button" class="more-dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="mdi mdi-dots-vertical"></i>
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="dLabel">
                            <li><a href="'.URL_ADMIN_NOTIFICATIONS_EDIT.$records->slug.'"><i class="fa fa-pencil"></i>'.getPhrase("edit").'</a></li>';
                            
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
    	$data['active_class']       = 'notifications';
     	$data['title']              = getPhrase('add_notification');
     	$data['layout']              = getLayout();
    	return view('notifications.add-edit', $data);
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

    	$record = Notification::getRecordWithSlug($slug);
    	if($isValid = $this->isValidRecord($record))
    		return redirect($isValid);

    	$data['record']       		= $record;
    	$data['active_class']     	= 'notifications';
    	$data['settings']       	= FALSE;
      	$data['title']            	= getPhrase('edit_notification');
      	$data['layout']             = getLayout();
    	return view('notifications.add-edit', $data);
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

    	$record = Notification::getRecordWithSlug($slug);
		 $rules = [
        'title'          	=> 'bail|required|max:50' ,
         
         'valid_from'      	=> 'bail|required',
         'valid_to'      	=> 'bail|required',
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

        $record->title          	= $name;
        $record->valid_from			= $request->valid_from;
        $record->valid_to			= $request->valid_to;
        $record->url				= $request->url;
        $record->short_description		= $request->short_description;
        $record->description		= $request->description;
       	$record->record_updated_by 	= Auth::user()->id;
        $record->save();
        flash('success','record_updated_successfully', 'success');
    	return redirect(URL_ADMIN_NOTIFICATIONS);
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
         'title'          	=> 'bail|required|max:50' ,
          
         'valid_from'      	=> 'bail|required' ,
         'valid_to'      	=> 'bail|required' ,
            ];
        $this->validate($request, $rules);
        $record = new Notification();
      	$name  						=  $request->title;
		$record->title 				= $name;
       	$record->slug 				= $record->makeSlug($name);
        $record->valid_from			= $request->valid_from;
        $record->valid_to			= $request->valid_to;
        $record->url				= $request->url;
        $record->short_description	= $request->short_description;
        $record->description		= $request->description;
       	$record->record_updated_by 	= Auth::user()->id;

        $record->save();
        flash('success','record_added_successfully', 'success');
    	return redirect(URL_ADMIN_NOTIFICATIONS);
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
        $record = Notification::where('slug', $slug)->first();
        if(!env('DEMO_MODE')) {
            $record->delete();
        }

        $response['status'] = 1;
        $response['message'] = getPhrase('record_deleted_successfully');
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
    	return URL_ADMIN_NOTIFICATIONS;
    }

    public function usersList()
    {

        $data['active_class']       = 'notifications';
        $data['title']              = getPhrase('notifications');
        $data['layout']              = getLayout();
        $date = date('Y-m-d');
        $data['notifications']  	= Notification::where('valid_from', '<=', $date)
        											->where('valid_to', '>=', $date)->paginate(getRecordsPerPage());
        
    	return view('notifications.users-list', $data);    	
    }

    public function display($slug)
    {
        $record = Notification::getRecordWithSlug($slug);
        if($isValid = $this->isValidRecord($record))
            return redirect($isValid);

        $data['active_class']       = 'notifications';
        $data['title']              = $record->title;
        $data['layout']             = getLayout();
        $data['notification']       = $record;
        
        return view('notifications.details', $data);  
    }
}
