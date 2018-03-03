<?php

namespace App\Http\Controllers;
use \App;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Topic;
use App\Subject;
use Yajra\Datatables\Datatables;
use DB;
use Input;
use Excel;

class TopicsController extends Controller
{
    public $excel_data = '';
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

        $data['active_class']       = 'exams';
        $data['title']              = getPhrase('topics_list');
    	return view('mastersettings.topics.list', $data);
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
         $records = Topic::join('subjects', 'topics.subject_id', '=' ,'subjects.id')
         ->select([  
            'subject_title','parent_id', 'topic_name','description','topics.slug', 'topics.id', 'topics.updated_at'])
         ->orderBy('updated_at','desc');

        return Datatables::of($records)
        ->addColumn('action', function ($records) {
           $link_data = '<div class="dropdown more">
                        <a id="dLabel" type="button" class="more-dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="mdi mdi-dots-vertical"></i>
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="dLabel">
                            <li><a href="'.URL_TOPICS_EDIT.'/'.$records->slug.'"><i class="fa fa-pencil"></i>'.getPhrase("edit").'</a></li>';
                     
                        
                    $temp = '';
                    if(checkRole(getUserGrade(1)))
                    {
                        $temp .=' <li><a href="javascript:void(0);" onclick="deleteRecord(\''.$records->slug.'\');"><i class="fa fa-trash"></i>'. getPhrase("delete").'</a></li>';
                    }
                    $temp .=    '</ul></div>';
                    $link_data .= $temp;

            return $link_data;
            })
        ->editColumn('topic_name', function($records)
        {
          return $records->topic_name.' ('.$records->id.')';
        })
        ->removeColumn('id')
        ->removeColumn('slug')
        ->removeColumn('updated_at')
        ->editColumn('parent_id', function($records){
        	return ($records->parent_id == 0) ? '<i class="fa fa-check text-success"></i>' : $records->topic_name;
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
    	$data['active_class']       = 'exams';
    	$data['parent_topics']      = array();
    	$list 						= App\Subject::all();
    	$subjects			= array_pluck($list, 'subject_title', 'id');
      $data['subjects'] = array(''=>getPhrase('select')) + $subjects;

      
      
        $data['parent_topics'][0]   = getPhrase('select');
        
    	$data['title']              = getPhrase('add_topic');
    	return view('mastersettings.topics.add-edit', $data);
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
    	$record = Topic::where('slug', $slug)->get()->first();

        if($isValid = $this->isValidRecord($record))
            return redirect($isValid);

    	$data['record']       		= $record;
    	$list 						= App\Subject::all();
    	$data['subjects']			= array_pluck($list, 'subject_title', 'id');
    	$data['parent_topics']		= array_pluck(Topic::getTopics($record->subject_id,0),'topic_name','id');
	   	$data['parent_topics'][0] = 'Parent';
    	$data['active_class']       = 'exams';
        $data['title']              = getPhrase('edit_topic');
    	return view('mastersettings.topics.add-edit', $data);
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

        $record                 = Topic::where('slug', $slug)->get()->first();
        
        if($isValid = $this->isValidRecord($record))
            return redirect($isValid);

          $this->validate($request, [
       	  'subject_id'        => 'bail|required|integer',
          'parent_id'         => 'bail|required|integer',
          'topic_name'        => 'bail|required|max:40',
          ]);

        $name 					        = $request->topic_name;
       
       /**
        * Check if the title of the record is changed, 
        * if changed update the slug value based on the new title
        */
        if($name != $record->topic_name)
            $record->slug = $record->makeSlug($name);
    	
        $record->topic_name 			= $name;
        $record->slug 			        = $record->makeSlug($name);
        $record->parent_id				= $request->parent_id;
        $record->subject_id				= $request->subject_id;
        $record->description      = '';
        if(isset($request->description))
        $record->description 			= $request->description;
        $record->save();

    	flash('success','record_updated_successfully', 'success');
    	return redirect(URL_TOPICS);
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
         'subject_id'          	 => 'bail|required|integer',
         'parent_id'             => 'bail|required|integer',
         'topic_name'          	 => 'bail|required|max:40',
         ]);
    	$record = new Topic();
        $name 					        = $request->topic_name;
        $record->topic_name 			= $name;
        $record->slug 			        = $record->makeSlug($name);
        $record->parent_id				= $request->parent_id;
        $record->subject_id				= $request->subject_id;
        $record->description 			= $request->description;
        $record->save();

        flash('success','record_added_successfully', 'success');
    	return redirect(URL_TOPICS);
    }

   

    /**
     * Delete Record based on the provided slug
     * @param  [string] $slug [unique slug]
     * @return Boolean 
     */
    public function delete($slug)
    {
        $record = Topic::where('slug', $slug)->first();
        /**
         * Check if any questions are related to this specific topic.
         * If no questions exists, delete this topic else give appropriate message
         */
      try {
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

    /**
     * Returns the parent topics based on selected subject
     * @param  [type] $subject_id [description]
     * @return [type]             [description]
     */
    public function getParentTopics($subject_id)
    {
        if(!checkRole(getUserGrade(2)))
      {
        prepareBlockUserMessage();
        return back();
      }


    	$list = Topic::getTopics($subject_id, 0);
    		 
    	$parents =  array();
    	array_push($parents, array('id'=>0, 'text' => 'Parent'));

    	foreach ($list as $key => $value) {
    		$r = array('id'=>$value->id, 'text' => $value->topic_name);
            array_push($parents, $r);
    	}
    	return json_encode($parents);
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
      return URL_TOPICS_LIST;
    }

    /**
    * Display a Import Users page
    *
    * @return Response
    */
     public function import()
     {
        if(!checkRole(getUserGrade(2)))
        {
          prepareBlockUserMessage();
          return back();
        }
      
        $data['records']      = FALSE;
        $data['active_class'] = 'exams';
        $data['heading']      = getPhrase('topics');
        $data['title']        = getPhrase('import_topics');
        $data['layout']        = getLayout();
        return view('mastersettings.topics.import.import', $data);
     }

     public function isValidSubject($subject_id)
     {
      $subject_id = (int) $subject_id;
       return Subject::where('id','=',$subject_id)->get()->count();
     }
     /**
      * This method returns the list of childs and parents by filtering on condition
      * It also inserts the parent records to db and collects the ids of the parent
      * To place those for child records
      * @param  string $value [description]
      * @return [type]        [description]
      */
     public function getParentAndChilds($records)
     {
      
       $parent_records  = [];
       $child_records   = [];
       $failed_list     = [];
       $success_list    = [];

       foreach($records as $record)
       {
          if(!$this->isValidSubject($record->subject_id))
            {
               $temp['record'] = $record;
               $temp['type']  = getPhrase('invalid_subject_id');
              $failed_list[count($failed_list)]  = (object)$temp;
              continue;
            }

          if(!$record->parent_id) {
            
             if(!$parent_records[(int)$record->id] = $this->pushToDb($record)) {
                $temp['record'] = $record;
                $temp['type']  = getPhrase('unknown_error_occurred');
                $failed_list[count($failed_list)]  = (object)$temp;
                continue;
             }

             $success_list[] = $record;
          }
          else
            $child_records[] = $record;
       }

       return array(
                    'parent_records'  => $parent_records,
                    'child_records'   => $child_records,
                    'failed_records'  => $failed_list,
                    'success_records' => $success_list
                    );
     }

     public function readExcel(Request $request)
     {
         $rules = [
         'excel'               => 'bail|required' ,
            ];
        $this->validate($request, $rules);

       if(!checkRole(getUserGrade(2)))
        {
          prepareBlockUserMessage();
          return back();
        }
       $success_list = [];
       $failed_list = [];
       try{
        if(Input::hasFile('excel')){
          $path = Input::file('excel')->getRealPath();
          $data = Excel::load($path, function($reader) {
          })->get();
          
          $all_records  = array();
          $excel_record = array();
          $final_records =array();
          $isHavingDuplicate = 0;
          if(!empty($data) && $data->count()){
            foreach ($data as $key => $value) {
              foreach($value as $record)
              {
                $all_records[] = $record;
              }

            }

            /**
             * 1) Validate the excel data by verifing the subject id validity and filter only valid recods
             * 2) First Insert the parent topic records and capture the id of the parent
             * 3) Get the list of child records, before insert the child record check the parent 
             *   id in the captured array or it exists in db
             * 4) Insert only valid parent id records.
             * 5) Maintain Failed and Success List with error messages.
             * 
             * @var [type]
             */
            $processed_records = (object) $this->getParentAndChilds($all_records);
          
              $parent_records = $processed_records->parent_records;
              $child_records  = $processed_records->child_records;
              $failed_list    = $processed_records->failed_records;
              $success_list   = $processed_records->success_records;

              foreach($child_records as $record)
              {
                $record = $record;

                $temp_parent_id = (int)$record->parent_id;

                if( !array_key_exists($temp_parent_id, $parent_records) && 
                    !$this->isRecordExists('id',$temp_parent_id)) 
                {
                  $temp['record'] = $record;
                  $temp['type']   = getPhrase('Invalid Subject Id');
                  $failed_list[count($failed_list)] = (object)$temp;
                  continue;
                }
                $record['parent_id'] =  $parent_records[$record->parent_id];
                 

              if( $this->pushToDb($record))
                $success_list[] = $record;

              }
         
          }
        }
       
       $data['failed_list']   =   $failed_list;
       $data['success_list']  =    $success_list;
       $this->excel_data['failed'] = $failed_list;
       $this->excel_data['success'] = $success_list;
         flash('success','record_added_successfully', 'success');
       $this->downloadExcel();
        }
     catch( \Illuminate\Database\QueryException $e)
     {
       if(getSetting('show_foreign_key_constraint','module'))
       {

          flash('oops...!',$e->errorInfo, 'error');
       }
       else {
          flash('oops...!','improper_sheet_uploaded', 'error');
       }
     }
        // URL_USERS_IMPORT_REPORT
         $data['failed_list']   =   $failed_list;
       $data['success_list']  =    $success_list;
       $data['records']      = FALSE;
       $data['layout']       = getLayout();
       $data['active_class'] = 'settings';
       $data['heading']      = getPhrase('users');
       $data['title']        = getPhrase('report');
       return view('mastersettings.topics.import.import-result', $data);
 
     }

     public function getFailedData()
{
  return $this->excel_data;
}

public function downloadExcel()
{
    Excel::create('topics_report', function($excel) {
      $excel->sheet('Failed', function($sheet) {
      $sheet->row(1, array('Reason','topic_name', 'parent_id','subject_id','description'));
      $data = $this->getFailedData();
      $cnt = 2;
      foreach ($data['failed'] as $data_item) {
        $item = $data_item->record;
        $sheet->appendRow($cnt++, array($data_item->type, $item->topic_name, $item->parent_id, $item->subject_id, $item->description));
      }
    });

    $excel->sheet('Success', function($sheet) {
      $sheet->row(1, array('topic_name', 'parent_id','subject_id','description'));
      $data = $this->getFailedData();
      $cnt = 2;
      foreach ($data['success'] as $data_item) {
        $item = $data_item;
       $sheet->appendRow($cnt++, array($item->topic_name, $item->parent_id, $item->subject_id, $item->description));
      }

    });

    })->download('xlsx');
}


     /**
      * This method verifies if the record exists with the title or code
      * If Exists it returns true else it returns false
      * @param  [type]  $value [description]
      * @param  string  $type  [description]
      * @return boolean        [description]
      */
     public function isRecordExists($record_value, $type='id')
     {
        return Topic::where($type,'=',$record_value)->get()->count();
     }

     /**
      * This method inserts the array of records to db
      * @param  [type] $records [description]
      * @return [type]          [description]
      */
     public function pushToDb($request)
     {
      
        $topic                = new Topic();
        $name                 = $request->topic_name;
        $topic->topic_name    = $name;
        $topic->parent_id     = $request->parent_id;
        $topic->slug          = $topic->makeSlug(getHashCode());
        $topic->subject_id    = $request->subject_id;
        $topic->description   = '';
        if($request->description)
        $topic->description   = $request->description;
       $topic->save();
        return $topic->id;
     }
 
}
