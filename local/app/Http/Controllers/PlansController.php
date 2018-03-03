<?php

namespace App\Http\Controllers;

use \App;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Plan;
use App\Course;
use Yajra\Datatables\Datatables;
use DB;
use Spatie\Activitylog\Models\Activity;

class PlansController extends Controller
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
        $data['active_class']       = 'subscriptions';
        $data['title']              = getPhrase('plans_master');
        $data['right_bar']          = TRUE;
        $recent_activity            = Activity::inLog('course_module') 
                                        ->orderBy('updated_at','DESC')->limit(10)->get();
        $data['right_bar_path']     = 'mastersettings.course.activity-right-bar';
        $data['right_bar_data']     = array('recent_activity' => $recent_activity);

    	return view('plans.list', $data);
    }

    /**
     * This method returns the datatables data to view
     * @return [type] [description]
     */
    public function getDatatable()
    {
        // DB::statement(DB::raw('set @rownum=0'));

         $records = Plan::select([ 'title', 'name','amount','type','description', 'id','slug'])->orderBy('updated_at','desc');
        
        return Datatables::of($records)
        ->addColumn('action', function ($records) {
           
            return '<div class="dropdown more">
                        <a id="dLabel" type="button" class="more-dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="mdi mdi-dots-vertical"></i>
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="dLabel">
                            <li><a href="/subscription/plans/edit/'.$records->slug.'"><i class="icon-packages"></i>'.getPhrase("edit").'</a></li>
                            
                            <li><a href="javascript:void(0);" onclick="deleteRecord(\''.$records->slug.'\');"><i class="icon-packages"></i>'. getPhrase("delete").'</a></li>
                        </ul>
                    </div>';
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
    	$data['record']         	= FALSE;
    	$data['active_class']       = 'subscriptions';
    	
    	 
    	$data['title']              = getPhrase('add_plan');

        $data['right_bar']          = TRUE;
        $recent_activity            = Activity::inLog('course_module') 
                                        ->orderBy('updated_at','DESC')->limit(10)->get();
        $data['right_bar_path']     = 'mastersettings.course.activity-right-bar';
        $data['right_bar_data']     = array('recent_activity' => $recent_activity);

    	return view('plans.add-edit', $data);
    }

    /**
     * This method loads the edit view based on unique slug provided by user
     * @param  [string] $slug [unique slug of the record]
     * @return [view with record]       
     */
    public function edit($slug)
    {
    	$record = Plan::where('slug', $slug)->get()->first();
    	$data['record']       		= $record;
    
    	$data['active_class']       = 'subscriptions';
        $data['title']              = getPhrase('edit_plan');
        $data['right_bar']          = TRUE;
        $recent_activity            = Activity::inLog('course_module') 
                                        ->orderBy('updated_at','DESC')->limit(10)->get();
        $data['right_bar_path']     = 'mastersettings.course.activity-right-bar';
        $data['right_bar_data']     = array('recent_activity' => $recent_activity);
    	return view('plans.add-edit', $data);
    }

    /**
     * Update record based on slug and reuqest
     * @param  Request $request [Request Object]
     * @param  [type]  $slug    [Unique Slug]
     * @return void
     */
    public function update(Request $request, $slug)
    {

        $record                 = Plan::where('slug', $slug)->get()->first();
        
          $this->validate($request, [
       	 'title'          		 => 'bail|required|max:20',
         'name'       			=> 'bail|required|max:20|unique:plans,name,'.$record->id,
         'amount'          	 	=> 'bail|required'
         
          ]);

        $name 					        = $request->name;
       
       /**
        * Check if the title of the record is changed, 
        * if changed update the slug value based on the new title
        */
        if($name != $record->name)
            $record->slug = $record->makeSlug($name);
    	
     
        $record->name = $name;
        $record->title					= $request->title;
        $record->amount					= $request->amount;
        $record->type					= $request->type;
        $record->description 			= $request->description;
        $record->record_updated_by 		= getUserRecord()->id;
        $record->save();

    	flash('success','record_updated_successfully', 'success');
    	return redirect('subscription/admin/plans');
    }

    /**
     * This method adds record to DB
     * @param  Request $request [Request Object]
     * @return void
     */
    public function store(Request $request)
    {
       $this->validate($request, [
         'title'          		=> 'bail|required|max:20',
         'name'           		=> 'bail|required|max:20|unique:plans,name',
         'amount'          	 	=> 'bail|required'
            ]);
    	$record = new Plan();
        $name 					        = $request->name;
        $record->name 					= $name;
        $record->slug 			        = $record->makeSlug($name);
        $record->title					= $request->title;
        $record->type					= $request->type;
        $record->amount					= $request->amount;
        $record->description 			= $request->description;
        $record->save();
        flash('success','record_added_successfully', 'success');
    	return redirect('subscription/admin/plans');
    }

}
