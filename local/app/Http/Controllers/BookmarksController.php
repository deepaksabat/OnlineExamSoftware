<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App;
use App\Http\Requests;
use App\Bookmark;
use Yajra\Datatables\Datatables;
use DB;
use Auth;

class BookmarksController extends Controller
{
    public function __construct()
    {
    	$this->middleware('auth');
    }

    /**
     * Course listing method
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function index($slug)
    {
     
        $record = App\User::where('slug', $slug)->get()->first();
       
        if($isValid = $this->isValidRecord($record))
         return redirect($isValid);
       /**
        * Validate the non-admin user wether is trying to access other user profile
        * If so return the user back to previous page with message
        */

        if(!isEligible($slug))
          return back();

        $data['user']       		= $record;
        $data['active_class']       = '';
        $data['layout']       = getLayout();
        $data['title']              = getPhrase('my_bookmarks');
    	return view('student.bookmarks.list', $data);
    }

    /**
     * This method returns the datatables data to view
     * @return [type] [description]
     */
    public function getDatatable($slug)
    {

       $user_record = App\User::where('slug', $slug)->get()->first();
       
        if($isValid = $this->isValidRecord($user_record))
         return redirect($isValid);
       /**
        * Validate the non-admin user wether is trying to access other user profile
        * If so return the user back to previous page with message
        */

        if(!isEligible($slug))
          return back();

        $records = array();

        $records = Bookmark::join('questionbank', 'questionbank.id', '=', 'bookmarks.item_id')
            ->select(['question_type', 'question','marks','bookmarks.id','bookmarks.user_id'])
            ->where('user_id','=',$user_record->id)
            ->orderBy('bookmarks.updated_at', 'desc');

        return Datatables::of($records)
        ->addColumn('action', function ($records) {
            return '<a title="'.getPhrase('remove_from_bookmarks').'" href="javascript:void(0);" onclick="deleteRecord(\''.$records->id.'\');" class="btn btn-danger" ><i class="fa fa-trash"></i> </a>';
            })
        ->editColumn('question_type', function($records)
        {
          return ucfirst($records->question_type);
        })
        ->removeColumn('id')
        ->removeColumn('user_id')
        ->make();
    }

    /**
     * This method loads the create view
     * @return void
     */
    public function create(Request $request)
    {
      	 $user_record = Auth::user();

      $records = Bookmark::where('item_id', '=', $request->item_id)
      						->where('user_id', '=', $user_record->id)
      						->where('item_type', '=', $request->item_type)->get();
      if(count($records))
      {
      	//Already Bookmarked Item is available, donot bookmark it again
      	return json_encode(array('status'=>'0', 'message'=>getPhrase('bookmark_already_available')));
      	// return json_encode(array('status'=>FALSE, 'message'=>count($records)));
      }

       $bookmark_record = new Bookmark();
       /**
        * Validate the non-admin user wether is trying to access other user profile
        * If so return the user back to previous page with message
        */

        if(!isEligible($user_record->slug))
          return back();


       $bookmark_record->user_id 	= $user_record->id;
       $bookmark_record->item_id 	= $request->item_id;
       $bookmark_record->item_type 	= $request->item_type;
       $bookmark_record->save();
       return json_encode(array('status'=>'1', 'message'=>getPhrase('added_to_bookmarks')));
    }

    
 
    /**
     * Delete Record based on the provided slug
     * @param  [string] $slug [unique slug]
     * @return Boolean 
     */
    public function delete($item_id)
    {
      $user = Auth::user();
       $record = Bookmark::where('item_id', '=',$item_id )
                  ->where('user_id', '=', $user->id)
                  ->where('item_type', '=', 'questions')
                  ->first();
        $record->delete();
        $response['status'] = 1;
        $response['message'] = getPhrase('bookmark_removed');
        return json_encode($response);
    }

    /**
     * Delete Record based on the provided slug
     * @param  [string] $slug [unique slug]
     * @return Boolean 
     */
    public function deleteById($item_id)
    {
    	$user = Auth::user();
       $record = Bookmark::where('id', '=',$item_id )
       						->first();
        $record->delete();
        $response['status'] = 1;
        $response['message'] = getPhrase('bookmark_removed');
        return json_encode($response);
    }

      public function getSavedBookmarks(Request $request)
      {
      	$user = Auth::user();
      	$records = Bookmark::select('id', 'item_id')
      						->where('user_id', '=', $user->id)
       						->where('item_type', '=', $request->item_type)
       						->get();
       	return json_encode($records);
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
      return URL_BOOKMARKS;
    }
}
