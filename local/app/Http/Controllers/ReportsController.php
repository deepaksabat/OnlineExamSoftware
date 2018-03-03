<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use \App;
use App\Http\Requests;
use App\User;
use App\GeneralSettings as Settings;
use App\QuizResult;
use App\Quiz;
use App\QuestionBank;
 
use Image;
use ImageSettings;
use Yajra\Datatables\Datatables;
use DB;
use Illuminate\Support\Facades\Hash;

use Input;

class ReportsController extends Controller
{
    public function __construct()
    {
         $currentUser = \Auth::user();
     
         $this->middleware('auth');
    
    }

    public function viewExamAnswers($exam_slug, $result_slug)
    {

    	$exam_record = Quiz::getRecordWithSlug($exam_slug);
    	if($isValid = $this->isValidRecord($exam_record))
        	return redirect($isValid); 

         $result_record = QuizResult::getRecordWithSlug($result_slug);
         $user_details   = App\User::where('id','=',$result_record->user_id)->get()->first();

        if($isValid = $this->isValidRecord($result_record))
        	return redirect($isValid); 


       
        $prepared_records        = (object) $exam_record
                                    ->prepareQuestions($exam_record->getQuestions());
        $data['questions']       = $prepared_records->questions;
        $data['subjects']        = $prepared_records->subjects;
                                    

        $data['exam_record']        = $exam_record;
        $data['result_record']      = $result_record;
        $data['user_details']        = $user_details;
        $data['active_class']       = 'analysis';
        $data['title']              = $exam_record->title.' '.getPhrase('answers');
        $data['layout']             = getLayout();
    	return view('student.exams.results.answers', $data);
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
    	return URL_STUDENT_EXAM_CATEGORIES;
    }
}
