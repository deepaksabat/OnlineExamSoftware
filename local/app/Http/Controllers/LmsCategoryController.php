<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App;
use App\Http\Requests;
use App\LmsCategory;
use App\LmsSettings;
use Yajra\Datatables\Datatables;
use DB;
use Auth;
use Image;
use ImageSettings;
use File;

class LmsCategoryController extends Controller
{
    public function __construct()
    {
    	$this->middleware('auth');
    }

    protected  $examSettings;

    public function setSettings()
    {
        $this->examSettings = getSettings('lms');
    }

    public function getSettings()
    {
        return $this->examSettings;
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
        $data['active_class']       = 'lms';
        $data['title']              = 'LMS'.' '.getPhrase('categories');
    	return view('lms.lmscategories.list', $data);
        
    }

    /**
     * This method returns the datatables data to view
     * @return [type] [description]
     */
    public function getDatatable()
    {
        if(!checkRole(getUserGrade(2)))
      {
        prepareBlockUserMessage();
        return back();
      }

         $records = LmsCategory::select([   
         	'category', 'image', 'description', 'id','slug']);
        $this->setSettings();
        return Datatables::of($records)
        ->addColumn('action', function ($records) {
         

            return '<div class="dropdown more">
                        <a id="dLabel" type="button" class="more-dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="mdi mdi-dots-vertical"></i>
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="dLabel">
                            <li><a href="'.URL_LMS_CATEGORIES_EDIT.$records->slug.'"><i class="fa fa-pencil"></i>'.getPhrase("edit").'</a></li>
                            
                            <li><a href="javascript:void(0);" onclick="deleteRecord(\''.$records->slug.'\');"><i class="fa fa-trash"></i>'. getPhrase("delete").'</a></li>
                        </ul>
                    </div>';
            })
        ->removeColumn('id')
        ->removeColumn('slug')
        ->editColumn('image', function($records){
            $image = '<img src="'.IMAGE_PATH_UPLOAD_LMS_DEFAULT.'" height="100" width="100" />';
            if($records->image)
            $image = '<img src="'.IMAGE_PATH_UPLOAD_LMS_CATEGORIES.$records->image.'" height="100" width="100" />';
        return $image;
        })
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
    	$data['active_class']       = 'lms';
    	$data['title']              = getPhrase('create_category');
    	return view('lms.lmscategories.add-edit', $data);
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
    	$record = LmsCategory::getRecordWithSlug($slug);
    	if($isValid = $this->isValidRecord($record))
    		return redirect($isValid);

    	$data['record']       		= $record;
    	$data['active_class']       = 'lms';
    	$data['title']              = getPhrase('edit_category');
    	return view('lms.lmscategories.add-edit', $data);
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
    	$record = LmsCategory::getRecordWithSlug($slug);


		$rules = [
         'category'          	   => 'bail|required|max:60' ,
          ];
         /**
        * Check if the title of the record is changed, 
        * if changed update the slug value based on the new title
        */
       $name = $request->category;
        if($name != $record->category)
            $record->slug = $record->makeSlug($name,TRUE);
      
       //Validate the overall request
       $this->validate($request, $rules);
    	$record->category 			= $name;
        $record->description		= $request->description;
        $record->record_updated_by 	= Auth::user()->id;
        $record->save();
 		 $file_name = 'catimage';
 		if ($request->hasFile($file_name))
        {

             $rules = array( $file_name => 'mimes:jpeg,jpg,png,gif|max:10000' );
              $this->validate($request, $rules);

              $record->image      = $this->processUpload($request, $record,$file_name);
              $record->save();
        }

        flash('success','record_updated_successfully', 'success');
    	return redirect(URL_LMS_CATEGORIES);
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
         'category'          	   => 'bail|required|max:60' ,
            ];
        $this->validate($request, $rules);
        $record = new LmsCategory();
      	$name  						=  $request->category;
		$record->category 			= $name;
       	$record->slug 				= $record->makeSlug($name,TRUE);
        $record->description		= $request->description;
        $record->record_updated_by 	= Auth::user()->id;
        $record->save();
 		 $file_name = 'catimage';
        if ($request->hasFile($file_name))
        {

            $rules = array( $file_name => 'mimes:jpeg,jpg,png,gif|max:10000' );
            $this->validate($request, $rules);
		    $this->setSettings();
            $examSettings = $this->getSettings();
	        $path = $examSettings->categoryImagepath;
	        $this->deleteFile($record->image, $path);

              $record->image      = $this->processUpload($request, $record,$file_name);
              $record->save();
        }

        flash('success','record_added_successfully', 'success');
    	return redirect(URL_LMS_CATEGORIES);
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
        $record = LmsCategory::where('slug', $slug)->first();
 
        try{
        $this->setSettings();
        
        $examSettings = $this->getSettings();
        $path = IMAGE_PATH_UPLOAD_LMS_CATEGORIES;
        $r =  $record;
        if(!env('DEMO_MODE')) {
            $record->delete();
            $this->deleteFile($r->image, $path);
        }
        
            $response['status'] = 1;
            $response['message'] = getPhrase('category_deleted_successfully');
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
    	 return URL_LMS_CATEGORIES;
    }

     public function deleteFile($record, $path, $is_array = FALSE)
    {
        if(env('DEMO_MODE')) {
            return '';
        }
        $files = array();
        $files[] = $path.$record;
        File::delete($files);
    }

     /**
     * This method process the image is being refferred
     * by getting the settings from ImageSettings Class
     * @param  Request $request   [Request object from user]
     * @param  [type]  $record    [The saved record which contains the ID]
     * @param  [type]  $file_name [The Name of the file which need to upload]
     * @return [type]             [description]
     */
     public function processUpload(Request $request, $record, $file_name)
     {
        if(env('DEMO_MODE')) {
            return 'demo';
        }

         if ($request->hasFile($file_name)) {
          $settings = json_decode((new LmsSettings())->getSettings());
          
          
          $destinationPath      = $settings->categoryImagepath;
          $fileName = $record->id.'-'.$file_name.'.'.$request->$file_name->guessClientExtension();
          
          $request->file($file_name)->move($destinationPath, $fileName);
         
         //Save Normal Image with 300x300
          Image::make($destinationPath.$fileName)->fit($settings->imageSize)->save($destinationPath.$fileName);
         return $fileName;
        }
     }
}
