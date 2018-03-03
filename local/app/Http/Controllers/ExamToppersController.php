<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App;
use App\Http\Requests;
use App\Quiz;
use App\Subject;
use App\QuestionBank;
use App\QuizCategory;
use App\ExamSeries;
use App\QuizResult;
use App\ExamTopper;
use Yajra\Datatables\Datatables;
use DB;
use Auth;
use File;
use Input;

class ExamToppersController extends Controller
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

      $data['active_class']       = 'analysis';
      $data['title']              = getPhrase('exam_toppers');
    	return view('exams.toppers.list', $data);
    }

    public function compare($user_result_slug, $compare_slug='')
    {
      if(!$user_result_slug)
      {
        return;
      }
      $topperObject = new ExamTopper();
       // $topperObject->validateWithExamTopper('11','4','100');
      $result                 = (object) $topperObject->getResultRecords($user_result_slug, $compare_slug);

      
      $data['topper_record']  = $result->topper_record;
      $data['user_record']    = $result->user_record;
      $data['total_users']    = $result->total_users;
      $data['quiz_record']    = $result->quiz_record;
      $data['active_class']   = 'analysis';
      $data['layout']         = getLayout();
      $data['title']          = getPhrase('exam_toppers');

      $rank = $topperObject->rankOfUserInQuiz($result->quiz_record->id, $result->user_record->user_id);
      $data['rank']          = $rank;
      $data['right_bar']          = TRUE;
      $userid = Auth::user()->id;
      $toppers_list            =   $result->toppers;
      $data['right_bar_path']     = 'student.toppers.toppers-right-bar';
      $data['right_bar_data']     = array(
                                            'right_bar_data' => $toppers_list,
                                            'user_result_slug' => $user_result_slug
                                            );

      return view('student.toppers.compare', $data);
    }

    
    
}
