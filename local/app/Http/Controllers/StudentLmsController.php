<?php
namespace App\Http\Controllers;
use \App;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\LmsCategory;
use App\LmsContent;
use App\LmsSeries;
use Yajra\Datatables\Datatables;
use DB;
use Auth;
use Image;
use ImageSettings;
use File;
use Response;
class StudentLmsController extends Controller
{
     public function __construct()
    {
    	$this->middleware('auth');
    }

     /**
     * Listing method
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function index()
    {
      if(checkRole(getUserGrade(2)))
      {
        return back();
      }
        $data['active_class']       = 'lms';
        $data['title']              = 'LMS'.' '.getPhrase('categories');
        $data['layout']              = getLayout();
        $data['categories']         = [];
        $user = Auth::user();
        $interested_categories      = null;
        if($user->settings)
        {
          $interested_categories =  json_decode($user->settings)->user_preferences;
        }
        
        if($interested_categories)    {
         if(count($interested_categories->lms_categories))
        $data['categories']         = Lmscategory::
                                      whereIn('id',(array) $interested_categories->lms_categories)
                                      ->paginate(getRecordsPerPage());
        }
        
        $data['user'] = $user;
        return view('student.lms.categories', $data);
    }

    public function viewCategoryItems($slug)
    {
        $record = LmsCategory::getRecordWithSlug($slug); 

        
        if($isValid = $this->isValidRecord($record))
          return redirect($isValid); 

         $data['active_class']       = 'lms';
         $data['user']               = Auth::user();
        $data['title']              = 'LMS'.' '.getPhrase('series');
        $data['layout']             = getLayout();
        $data['series']             = LmsSeries::where('lms_category_id','=',$record->id)
                                        ->where('start_date','<=',date('Y-m-d'))
                                        ->where('end_date','>=',date('Y-m-d'))        
                                        ->paginate(getRecordsPerPage());
        return view('student.lms.lms-series-list', $data);
    }

    /**
     * This method displays the list of series available
     * @return [type] [description]
     */
    public function series()
    {
        if(checkRole(getUserGrade(2)))
      {
        return back();
      }

        $data['active_class']       = 'lms';
        $data['title']              = 'LMS'.' '.getPhrase('series');
        $data['layout']             = getLayout();
        $data['series']             = [];

    $user = Auth::user();
    $interested_categories      = null;
    if($user->settings)
    {
      $interested_categories =  json_decode($user->settings)->user_preferences;
    }
    if($interested_categories){
    if(count($interested_categories->lms_categories))
        $data['series']             = LmsSeries::
                                        where('start_date','<=',date('Y-m-d'))
                                        ->where('end_date','>=',date('Y-m-d'))
                                        ->whereIn('lms_category_id',(array) $interested_categories->lms_categories)
                                        ->paginate(getRecordsPerPage());
    }
    $data['user']               = $user;

    return view('student.lms.lms-series-list', $data);
        
    }

      /**
     * This method displays all the details of selected exam series
     * @param  [type] $slug [description]
     * @return [type]       [description]
     */
    public function viewItem($slug, $content_slug='')
    { 
        
        $record = LmsSeries::getRecordWithSlug($slug); 
        
        if($isValid = $this->isValidRecord($record))
          return redirect($isValid);  
        $content_record = FALSE;
        if($content_slug) {
          $content_record = LmsContent::getRecordWithSlug($content_slug);
          if($isValid = $this->isValidRecord($content_record))
          return redirect($isValid);  
        }
        

        if($content_record){
            if($record->is_paid) {
            if(!isItemPurchased( $record->id, 'lms'))
            {
                prepareBlockUserMessage();
                return back();
            }
        }
        }

        $data['active_class']       = 'lms';
        $data['pay_by']             = '';
        $data['title']              = $record->title;
        $data['item']               = $record;
        $data['content_record']     = $content_record;
    
        $data['layout']              = getLayout();

       return view('student.lms.series-view-item', $data);
    }

    public function verifyPaidItem($slug, $content_slug)
    {

      if(!checkRole(getUserGrade(13)))
      { 
        prepareBlockUserMessage();
        return back();
      }
        $record = LmsSeries::getRecordWithSlug($slug); 
        
        if($isValid = $this->isValidRecord($record))
          return redirect($isValid);  
       
          $content_record = LmsContent::getRecordWithSlug($content_slug);
          
          if($isValid = $this->isValidRecord($content_record))
          return redirect($isValid);  
     
         if($content_record){
            if($record->is_paid) {
            if(!isItemPurchased($record->id, 'lms'))
            {
                return back();
            }
            else{
             
             $pathToFile= "uploads/lms/content"."/".$content_record->file_path;
              
              return Response::download($pathToFile);

            }
          }

          else{
            $pathToFile= "uploads/lms/content"."/".$content_record->file_path;
              
              return Response::download($pathToFile);
          }
        }
        else{
          flash('Ooops','File Does Not Exit','overlay');
          return back();
        }


    }

    public function content(Request $request, $req_content_type)
    {
    	$content_type = $this->getRequestContentType($req_content_type);
    	$category = FALSE;

    	$query = LmsContent::where('content_type', '=', $content_type)
    						->where('is_approved',1);

    	if($request->has('category')){
    		$category = $request->category;
    		$category_record = Lmscategory::getRecordWithSlug($category);
    		$query->where('category_id',$category_record->id);
    	}
    	
    	$data['category'] = $category;
    	$data['content_type'] = $req_content_type;

    	$data['list'] = $query->get();
    	// dd($data['list']);
    	$data['active_class']       = 'lms';
        $data['title']              = $req_content_type;
        $data['categories']         = Lmscategory::all();
        return view('student.lms.content-categories', $data);
    }

    public function getRequestContentType($type)
    {
    	if($type == 'video-course' || $type == 'video-courses')
    		return 'vc';
    	if($type == 'community-links')
    		return 'cl';
    	return 'sm';
    }

    public function getContentTypeFullName($type)
    {
    	if($type=='sm')
    		return 'study-materal';
    	if($type=='vc')
    		return 'video-courses';
    	return 'community-links';
    }

    public function showContent($slug)
    {

    	$record = Lmscontent::getRecordWithSlug($slug);
    	if($isValid = $this->isValidRecord($record))
    		return redirect($isValid);


    	$data['active_class']       = 'lms';
	    $data['title']              = $record->title;
	    $data['category']           = $record->category;
	    $data['record']             = $record;
	    
	    $data['content_type'] 		= $this->getContentTypeFullName($record->content_type);
 		$data['series'] 			= array();
 		if($record->is_series){
 			$parent_id = $record->id;
 			
 			if($record->parent_id != 0)
 				$parent_id = $record->parent_id;
 			$data['series'] 		= LmsContent::where('parent_id', $parent_id)->get();
 		}
 		
		return view('student.lms.show-content', $data);  
    	 

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
    	return URL_LMS_CONTENT;
    }

    

}
