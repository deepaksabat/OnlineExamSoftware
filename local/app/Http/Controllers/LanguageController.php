<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App;
use App\Http\Requests;
use App\Language;
use Yajra\Datatables\Datatables;
use DB;


class LanguageController extends Controller
{
    public function __construct()
    {
       $this->middleware('auth');
      
    }

    /**
     * Plans listing method
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function index()
    {
      if(!checkRole(getUserGrade(2)))
      {
        prepareBlockUserMessage();
        return back();
      }
         
        $data['active_class']       = 'languages';
        $data['title']              = getPhrase('languages');
        $data['layout']             = getLayout();
        return view('languages.list', $data);
    }

    public function myMethod()
    {
        dd('testing');
    }
    /**
     * This method returns the datatables data to view
     * @return [type] [description]
     */
    public function showme()
    {
    	if(!checkRole(getUserGrade(2)))
      {
        prepareBlockUserMessage();
        return back();
      }

         $records = Language::select([ 'language', 'code','is_rtl','is_default','id','slug'])->orderBy('updated_at','desc');
        
        return Datatables::of($records)
        ->addColumn('action', function ($records) {
           $link_data = '<div class="dropdown more">
                        <a id="dLabel" type="button" class="more-dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="mdi mdi-dots-vertical"></i>
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="dLabel">
                            <li><a href="/languages/edit/'.$records->slug.'"><i class="fa fa-pencil"></i>'.getPhrase("edit").'</a></li>';
                            $temp = '';
                       if(checkRole(getUserGrade(1)))  {
                            $temp = '<li><a href="javascript:void(0);" onclick="deleteRecord(\''.$records->slug.'\');"><i class="fa fa-trash"></i>'. getPhrase("delete").'</a></li>';
                         }
                        $temp .= '</ul></div>';

                        $link_data = $link_data. $temp;
            return $link_data;
            })
        ->editColumn('code',function ($records)
        {
        	return strtoupper($records->code);
        })
        ->editColumn('is_rtl',function ($records)
        {
        	 if($records->is_rtl)
            return '<i class="fa fa-check text-success" title="'.getPhrase('enable').'"></i>';
            return '<i class="fa fa-close text-danger" title="'.getPhrase('disable').'"></i>';
        })
         ->editColumn('is_default',function ($records)
        {
        	 if($records->is_default)
            return '<i class="fa fa-check text-success" title="'.getPhrase('enable').'"></i>';
            return '<a href="/languages/make-default/'.$records->slug.'" class="btn btn-info btn-xs">'.getPhrase('set_default').'</a>';
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
    	$data['active_class']       = 'languages';
    	
      $data['title']              = getPhrase('add_language');
    	$data['layout']             = getLayout();

        return view('languages.add-edit', $data);
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

    	$record = Language::where('slug', $slug)->get()->first();
    	if($isValid = $this->isValidRecord($record))
    		return redirect($isValid);
    			
    	  $data['record']       		= $record;
    	  $data['active_class']       = 'languages';
        $data['title']              = getPhrase('edit_language');
        $data['layout']             = getLayout();
        return view('languages.add-edit', $data);
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

        $record                 = Language::where('slug', $slug)->get()->first();
        
        if($isValid = $this->isValidRecord($record))
    		return redirect($isValid);

          $this->validate($request, [
         'language'          		=> 'bail|required|max:20|unique:languages,language,'.$record->id,
         'code'           		=> 'bail|required|max:20|unique:languages,code,'.$record->id,
         'is_rtl'          	 	=> 'bail|required'
            ]);

        $name 					        = $request->language;
       
       /**
        * Check if the title of the record is changed, 
        * if changed update the slug value based on the new title
        */
        if($name != $record->language)
            $record->slug = $record->makeSlug($name);
    	
     	$record->language 			 = $name;
        $record->slug 			   = $record->makeSlug($name);
        $record->code					 = $request->code;
        $record->is_rtl				 = $request->is_rtl;
        $record->save();
        flash('success','record_updated_successfully', 'success');
    	return redirect('languages/list');
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

       $this->validate($request, [
         'language'          	=> 'bail|required|max:20|unique:languages,language',
         'code'           		=> 'bail|required|max:4|unique:languages,code',
         'is_rtl'          	 	=> 'bail|required'
            ]);
    	$record = new Language();
        $name 					        = $request->language;
        $record->language 				= $name;
        $record->slug 			        = $record->makeSlug($name);
        $record->code					= $request->code;
        $record->is_rtl					= $request->is_rtl;
        $record->save();
        flash('success','record_added_successfully', 'success');
    	return redirect('languages/list');
    }

    /**
     * This method will change the default language by
     * Unset all is_default fields to 0
     * Set the is_default to the specified slug by user
     * @param  [type] $slug [description]
     * @return [type]       [description]
     */
    public function changeDefaultLanguage($slug)
    {
      if(!checkRole(getUserGrade(2)))
      {
        prepareBlockUserMessage();
        return back();
      }

    	$record = Language::where('slug', '=', $slug)->first();
    	$zero = 0;
    	if($isValid = $this->isValidRecord($record))
    		return redirect($isValid);


        	Language::where('id','!=' ,$zero)->update(['is_default'=> $zero]);
        	Language::where('slug', '=', $slug)->update(['is_default'=> 1]);
            Language::resetLanguage();


    	flash('success','record_updated_successfully', 'success');
    	return redirect('languages/list');	
    }

    /**
     * Delete the language is the language is not set to default
     * @param  [type] $slug [description]
     * @return [type]       [description]
     */
    public function delete($slug)
    {
      if(!checkRole(getUserGrade(2)))
      {
        prepareBlockUserMessage();
        return back();
      }

    	$record = Language::where('slug', '=', $slug)->first();

      /**
       * Check if the record is set to current default language
       * If so do not delete the record and send the appropriate message
       */
      
    if($record->is_default)
        {
            //Topics exists with the selected, so done delete the subject
            $response['status'] = 0;
            $response['message'] = getPhrase('it_is_set_to_default_language');
            return json_encode($response);
        }
        else {
            $record->delete();
            $response['status'] = 1;
            $response['message'] = getPhrase('record_deleted_successfully');
            return json_encode($response);
            }

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
      return '/languages/list';
    }

}
