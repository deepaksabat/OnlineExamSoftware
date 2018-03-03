<?php

namespace App\Http\Controllers;
use \App;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use App\Http\Requests;
use App\Quiz;
use App\Subject;
use App\QuestionBank;
use App\QuizCategory;
use App\QuizResult;
use Yajra\Datatables\Datatables;
use App\EmailSettings;
use DB;
use Auth;
use App\User;
use Input;
use Exception;


class StudentQuizController extends Controller
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

        $data['active_class']       = 'exams';
        $data['title']              = getPhrase('quiz_categories');
        $data['categories']         = [];
        $user = Auth::user();
        $interested_categories      = null;
        if($user->settings)
        {
          $interested_categories =  json_decode($user->settings)->user_preferences;
        }
        if($interested_categories) {
        if(count($interested_categories->quiz_categories))

        $data['categories']         = QuizCategory::
                                      whereIn('id',(array) $interested_categories->quiz_categories)
                                      ->paginate(getRecordsPerPage());
        }
        $data['layout']              = getLayout();
        $user = Auth::user();

    	return view('student.exams.categories', $data);
    }

    /**
     * List the categories available
     * @param  [type] $slug [description]
     * @return [type]       [description]
     */
    public function exams($slug='')
    {
      $category = FALSE;
      if($slug)
    	$category = QuizCategory::getRecordWithSlug($slug);
    	
    	$data['category']       	= $category;
    	$data['active_class']     = 'exams';
      $data['title']            = getphrase('all_exams');

      if($category)
      $data['title']            = $category->category;
      $data['layout']           = getLayout();
      
        return view('student.exams.list', $data);
    }

    /**
     * Displays the instructions before start of the exam
     * @param  [type] $slug [description]
     * @return [type]       [description]
     */
    public function instructions($slug)
    {
      
      $instruction_page = '';
      $record = Quiz::getRecordWithSlug($slug);

      if($isValid = $this->isValidRecord($record))
        return redirect($isValid);

      if($record->instructions_page_id)
      $instruction_page = App\Instruction::where('id',$record->instructions_page_id)->first();
      
      $data['instruction_data'] = '';
      
      if($instruction_page){
        $data['instruction_data'] = $instruction_page->content;
        $data['instruction_title'] = $instruction_page->title;
      }

     
      //If Other than student tries to attempt the exam 
      //Restrict the access to that exam
      if(!checkRole(['student']))
      {
        prepareBlockUserMessage();
        return redirect($this->getReturnUrl());
      }

     	$data['record']       	  = $record;
      $data['active_class']     = 'exams';
    	$data['layout']           = getLayout();
        $data['title']          = $record->title;
         $data['block_navigation']          = TRUE;
        return view('student.exams.instructions', $data);
    }

    /**
     * This method manages session based on provided key [exam_started, exam_completed, check]
     * @param  [type] $key [description]
     * @return [type]      [description]
     */
    public function examSession($key)
    {

        switch ($key) {
            case 'exam_started':
                              session()->put($key, '1');
                break;
            case 'exam_completed':
                            session()->forget('exam_started');
                break;
            case 'check':
                            if(session()->get('exam_started') == null) {
                                return TRUE;
                            }
                            return FALSE; break;
        }

        return;
    }
    /**
     * The Exam will start from this method
     * @param  [type] $slug [description]
     * @return [type]       [description]
     */
    public function startExam($slug)
    {
        /**
         * Fetch the questions for the specified slug
         * Fetch the quiz details
         * 
         */

        $quiz = Quiz::getRecordWithSlug($slug);

        /**
         * Check if exam has already been started
         * If started it will enter into this block and does the following operations
         * 1 Enter the log as exam aborted by refresh key
         * 2 Removes the session as exam started
         * 3 Redirect to other page by a message
         */
       if(!$this->examSession('check'))
        {
           flash('Ooops..!','exam_aborted', 'error');
           $this->examSession('exam_completed');
           return redirect($this->getRedirectUrl());
        }

        $user = Auth::user();

        /**
         * Prepare the general questions list to display on user page
         * It should contain the follwoing list of elements in each record
         * question_id, question, subject_id, subject_name, marks
         */
        $prepared_records   = (object) $quiz->prepareQuestions($quiz->getQuestions());
        $final_questions    = $prepared_records->questions;
        $final_subjects     = $prepared_records->subjects;
        $data['questions']          = $final_questions;
      
        $bookmarks                  = array_pluck($final_questions, 'id');
        $data['bookmarks']          = $bookmarks;
        $data['subjects']           = $final_subjects;
        $time                       = $this->convertToHoursMins($quiz->dueration);

        $data['time_hours']         = makeNumber($time['hours'],2,'0','left');
        $data['time_minutes']       = makeNumber($time['minutes'],2,'0','left');

        $data['quiz']               = $quiz;
        $data['active_class']       = 'exams';
        $data['title']              = $quiz->title;
        $data['right_bar']          = TRUE;
        $data['block_navigation']          = TRUE;
        $data['right_bar_path']     = 'student.exams.exam-right-bar';
        $data['right_bar_data']     = array(
                                            'questions'     => $final_questions, 
                                            'quiz'          => $quiz, 
                                            'time_hours'    => $data['time_hours'], 
                                            'time_minutes'  => $data['time_minutes']
                                            );
        $this->examSession('exam_started');
        return view('student.exams.exam-form', $data);
    	 
    }

    /**
     * Convert minutes to Hours and minutes
     */

    function convertToHoursMins($time, $format = '%02d:%02d') 
    {
        if ($time < 1) {
            return;
        }
        $hours = floor($time / 60);
        $minutes = ($time % 60);
        $result['hours'] = $hours;
        $result['minutes'] = $minutes;
        return $result;
    }

    /**
     * After the exam complets the data will be submitted to this method
     * @param  Request $request [description]
     * @param  [type]  $slug    [description]
     * @return [type]           [description]
     */
    public function finishExam(Request $request, $slug)
    {
 
        $quiz = Quiz::getRecordWithSlug($slug);

        if($this->examSession('check'))
        {
             flash('Ooops..!','exam_already_submitted', 'info');
             return redirect($this->getRedirectUrl()); 
        }
        
        $this->examSession('exam_completed');

        if($isValid = $this->isValidRecord($quiz))
            return redirect($isValid);

        $input_data = Input::all();
        $answers = array();
        $time_spent = $request->time_spent;
       
        //Remove _token key from answers data prepare the list of answers at one place
        foreach ($input_data as $key => $value) {
            if($key=='_token' || $key=='time_spent')
                continue;
            $answers[$key] = $value;
        }


        //Get the list of questions and prepare the list at one place
        //This is to find the unanswered questions
        //List the unanswered questions list at one place
        $questions = DB::table('questionbank_quizzes')->select('questionbank_id', 'subject_id')
                     ->where('quize_id','=',$quiz->id)
                     ->get();
        
         
        $subject                  = [];
        $time_spent_not_answered  = [];
        $not_answered_questions   = [];

        foreach($questions as $q)
        {
          
          $subject_id = $q->subject_id;
           if(! array_key_exists($q->subject_id, $subject)) {
              $subject[$subject_id]['subject_id']       = $subject_id;
              $subject[$subject_id]['correct_answers']  = 0;
              $subject[$subject_id]['wrong_answers']    = 0;
              $subject[$subject_id]['not_answered']     = 0;
              $subject[$subject_id]['time_spent']       = 0;
              $subject[$subject_id]['time_to_spend']       = 0;
              $subject[$subject_id]['time_spent_correct_answers']    = 0;
              $subject[$subject_id]['time_spent_wrong_answers']    = 0;
            }
            if(! array_key_exists($q->questionbank_id, $answers)){
              $subject[$subject_id]['not_answered']     += 1;
              $not_answered_questions[] = $q->questionbank_id;
              $time_spent_not_answered[$q->questionbank_id]['time_to_spend'] = 0;
              $time_spent_not_answered[$q->questionbank_id]['time_spent'] = $time_spent[$q->questionbank_id];
              $subject[$subject_id]['time_spent']      += $time_spent[$q->questionbank_id];
            }
        }
        
        $result =   $this->processAnswers($answers, $subject, $time_spent, $quiz->negative_mark);
        $result['not_answered_questions'] = json_encode($not_answered_questions);
        $result['time_spent_not_answered_questions'] = json_encode($time_spent_not_answered);
        
        $result = (object) $result;
        $answers = json_encode($answers);
        
        $record = new QuizResult();
        $record->quiz_id = $quiz->id;
        $record->user_id = Auth::user()->id;
        $record->marks_obtained = $result->marks_obtained;
        $record->total_marks = $quiz->total_marks;
        $record->percentage = $this->getPercentage($result->marks_obtained, $quiz->total_marks);
        
        $exam_status = 'pending';
        if($record->percentage >= $quiz->pass_percentage)
            $exam_status = 'pass';
        else
            $exam_status = 'fail';

        $record->exam_status = $exam_status;
        $record->answers = $answers;
        $record->subject_analysis = $result->subject_analysis;
        $record->correct_answer_questions = $result->correct_answer_questions;
        $record->wrong_answer_questions = $result->wrong_answer_questions;
        $record->not_answered_questions = $result->not_answered_questions;
        $record->time_spent_correct_answer_questions = $result->time_spent_correct_answer_questions;
        $record->time_spent_wrong_answer_questions = $result->time_spent_wrong_answer_questions;
        $record->time_spent_not_answered_questions = $result->time_spent_not_answered_questions;

        $record->slug = getHashCode();
        $user_record = Auth::user();
        
        $content = 'You have attempted exam. The score percentage is '.formatPercentage($record->percentage);
       
        $record->save();

         try{
         sendEmail('exam-result', array('user_name' => $user->username,'content'=> $content, 'to_email' => Auth::user()->email));
       }
       catch(Exception $ex)
       {

       }

        $topperStatus = false;
        $data['isUserTopper']       = $topperStatus;
        $data['rank_details']       = FALSE;
        $data['quiz']               = $quiz;
        $data['active_class']       = 'exams';
        $data['title']              = $quiz->title;
        $data['record']             = $record;

        $data['user']               = $user_record;
         
        //Chart Data START
        $color_correct = getColor('background', rand(1,999));
        $color_wrong = getColor('background', rand(1,999));
        $color_not_attempted = getColor('background', rand(1,999));

        $labels_marks = [getPhrase('correct'), getPhrase('wrong'), getPhrase('not_answered')];
        $dataset_marks = [count(json_decode($record->correct_answer_questions)),
                          count(json_decode($record->wrong_answer_questions)), 
                          count(json_decode($record->not_answered_questions))];

        $dataset_label_marks = "Marks";
        $bgcolor  = [$color_correct,$color_wrong,$color_not_attempted];
        $border_color = [$color_correct,$color_wrong,$color_not_attempted];
        $chart_data['type'] = 'doughnut';
         $chart_data['data']   = (object) array(
            'labels'            => $labels_marks,
            'dataset'           => $dataset_marks,
            'dataset_label'     => $dataset_label_marks,
            'bgcolor'           => $bgcolor,
            'border_color'      => $border_color
            );
        
        $data['marks_data'][] = (object)$chart_data; 

 
        $time_spent = 0;
        foreach(json_decode($record->time_spent_correct_answer_questions) as $rec)
        {
          $time_spent += $rec->time_spent;
        }
        foreach(json_decode($record->time_spent_wrong_answer_questions) as $rec)
        {
          $time_spent += $rec->time_spent;
        }
        foreach(json_decode($record->time_spent_not_answered_questions) as $rec)
        {
          $time_spent += $rec->time_spent;
        }

        //Time Chart Data
        $color_correct       = getColor('background', rand(1,999));
        $color_wrong          = getColor('background', rand(1,999));
        $color_not_attempted  = getColor('background', rand(1,999));
        $total_time           = $quiz->dueration*60;
        $total_time_spent     = ($time_spent);
 
        $labels_time          = [getPhrase('total_time').' (sec)', getPhrase('consumed_time').' (sec)'];
        $dataset_time         = [ $total_time, $time_spent];

        $dataset_label_time   = "Time in sec";
        $bgcolor              = [$color_correct,$color_wrong,$color_not_attempted];
        $border_color         = [$color_correct,$color_wrong,$color_not_attempted];
        $chart_data['type']   = 'pie';
         $chart_data['data']  = (object) array(
                                                'labels'          => $labels_time,
                                                'dataset'         => $dataset_time,
                                                'dataset_label'   => $dataset_label_time,
                                                'bgcolor'         => $bgcolor,
                                                'border_color'    => $border_color
                                                );
        
        $data['time_data'][]  = (object)$chart_data; 
 
        //Chart Data END

        $quizrecordObject     = new QuizResult();
        $history              = array();
        $history              = $quizrecordObject->getHistory();

        $toppers              = array();

        $data['toppers']      = $toppers;
        $data['block_navigation']          = TRUE;
        
        return view('student.exams.results', $data);
    }

    /**
     * Pick grade record based on percentage from grades table
     * @param  [type] $percentage [description]
     * @return [type]             [description]
     */
    public function getPercentageRecord($percentage)
    {
        return DB::table('grades')
                ->where('percentage_from', '<=',$percentage)
                ->where('percentage_to', '>=',$percentage)
                ->get();
    }

    /**
     * This below method process the submitted answers based on the 
     * provided answers and quiz questions
     * @param  [type] $answers [description]
     * @return [type]          [description]
     */
    public function processAnswers($answers, $subject, $time_spent, $negative_mark = 0)
    {

        $obtained_marks     = 0;
        $correct_answers    = 0;
        $obtained_negative_marks = 0;

        $corrent_answer_question            = [];
        $wrong_answer_question              = [];
        $time_spent_correct_answer_question = [];
        $time_spent_wrong_answer_question   = [];
        
        foreach ($answers as $key => $value) {
          if( is_numeric( $key ))
         {
            $question_record  = $this->getQuestionRecord($key);
            $question_type    = $question_record->question_type;
            $actual_answer    = $question_record->correct_answers;
          
            $subject_id       = $question_record->subject_id;
            if(! array_key_exists($subject_id, $subject)) {
              $subject[$subject_id]['subject_id']       = $subject_id;
              $subject[$subject_id]['correct_answers']  = 0;
              $subject[$subject_id]['wrong_answers']    = 0;
              $subject[$subject_id]['time_spent_correct_answers']    = 0;
              $subject[$subject_id]['time_spent_wrong_answers']    = 0;
              $subject[$subject_id]['time_spent']       = 0;
             
            }

             $subject[$subject_id]['time_spent']       += $time_spent[$question_record->id];
             $subject[$subject_id]['time_to_spend']    += $question_record->time_to_spend;
            switch ($question_type) {
                case 'radio':
                                if($value[0] == $actual_answer)
                                {
                                    $correct_answers++;
                                    $obtained_marks                 += $question_record->marks;
                                    $corrent_answer_question[]       = $question_record->id;
                                    $subject[$subject_id]['correct_answers'] +=1;
                                    $subject[$subject_id]['time_spent_correct_answers'] += $time_spent[$question_record->id];

                                    $time_spent_correct_answer_question[$question_record->id]['time_to_spend'] 
                                                                    = $question_record->time_to_spend;
                                    $time_spent_correct_answer_question[$question_record->id]['time_spent'] 
                                                                    = $time_spent[$question_record->id];
                                    
                                }
                                else {
                                  
                                    $wrong_answer_question[]          = $question_record->id;
                                    $subject[$subject_id]['wrong_answers'] += 1;
                                    $obtained_marks                   -= $negative_mark;
                                    $obtained_negative_marks          += $negative_mark;
                                    $subject[$subject_id]['time_spent_wrong_answers']    
                                                                += $time_spent[$question_record->id];
                                    $time_spent_wrong_answer_question[$question_record->id]['time_to_spend'] 
                                                                    = $question_record->time_to_spend;
                                    $time_spent_wrong_answer_question[$question_record->id]['time_spent'] 
                                                                     = $time_spent[$question_record->id];
                                }
                               
                                break;

                case 'checkbox':
                                $actual_answer = json_decode($actual_answer);
                                $i=0;
                                $flag= 1;
                                foreach($value as $answer_key => $answer_value )
                                {
                                    if(isset($actual_answer[$answer_key]))
                                    {
                                        if( $actual_answer[$answer_key]->answer != 
                                            $answer_value )
                                        {
                                            $flag = 0; break;
                                        }
                                    }
                                    else {
                                        $flag = 0; break;
                                    }

                                }

                                if($flag)
                                {
                                    $correct_answers++;
                                    $obtained_marks += $question_record->marks;
                                    $corrent_answer_question[] = $question_record->id;
                                    $subject[$subject_id]['correct_answers'] +=1;
                                    $subject[$subject_id]['time_spent_correct_answers'] 
                                                                += $time_spent[$question_record->id];
                                    $time_spent_correct_answer_question[$question_record->id]['time_to_spend'] 
                                                                    = $question_record->time_to_spend;
                                    $time_spent_correct_answer_question[$question_record->id]['time_spent'] 
                                                                    = $time_spent[$question_record->id];

                                }
                                else {
                                    $wrong_answer_question[]          = $question_record->id;
                                    $subject[$subject_id]['wrong_answers'] += 1;
                                     $subject[$subject_id]['time_spent_wrong_answers']    
                                                                += $time_spent[$question_record->id];
                                    $obtained_marks                   -= $negative_mark;
                                    $obtained_negative_marks          += $negative_mark;
                                    $time_spent_wrong_answer_question[$question_record->id]['time_to_spend'] 
                                                                       = $question_record->time_to_spend;
                                    $time_spent_wrong_answer_question[$question_record->id]['time_spent'] 
                                                                       = $time_spent[$question_record->id];
                                }
                                
                                break;
                case 'blanks': 
                                $actual_answer = json_decode($actual_answer);
                                 $i=0;
                                $flag= 1;
                                foreach($actual_answer as $answer)
                                {
                                    if(strcasecmp(
                                        trim($answer->answer),
                                        trim($value[$i++])) != 0)
                                    {
                                        $flag = 0; break;
                                    }
                                }

                                if($flag)
                                {
                                    $correct_answers++;
                                    $obtained_marks += $question_record->marks;
                                    $corrent_answer_question[] = $question_record->id;
                                    $subject[$subject_id]['correct_answers'] +=1;
                                     $subject[$subject_id]['time_spent_correct_answers'] 
                                                                += $time_spent[$question_record->id];
                                    $time_spent_correct_answer_question[$question_record->id]['time_to_spend'] 
                                                                    = $question_record->time_to_spend;
                                    $time_spent_correct_answer_question[$question_record->id]['time_spent'] 
                                                                    = $time_spent[$question_record->id];


                                }
                                else
                                {
                                    $wrong_answer_question[] = $question_record->id;
                                    $subject[$subject_id]['wrong_answers'] += 1;
                                    $subject[$subject_id]['time_spent_wrong_answers']    
                                                                += $time_spent[$question_record->id];
                                    $obtained_marks                   -= $negative_mark;
                                    $obtained_negative_marks          += $negative_mark;
                                    $time_spent_wrong_answer_question[$question_record->id]['time_to_spend'] 
                                                                       = $question_record->time_to_spend;
                                    $time_spent_wrong_answer_question[$question_record->id]['time_spent'] 
                                                                       = $time_spent[$question_record->id];
                                }
                                
                                break;
                    case (  $question_type == 'para'  || 
                            $question_type == 'audio' || 
                            $question_type == 'video' 
                          ):
                                 $actual_answer = json_decode($actual_answer);
                                 $indidual_marks = $question_record->marks/$question_record->total_correct_answers;
                                $i=0;
                                $flag= 0;
                                foreach($value as $answer_key => $answer_value )
                                {
                                    if($actual_answer[$answer_key]->answer == $answer_value)
                                    {
                                        $flag=1;
                                        $obtained_marks += $indidual_marks;    
                                    }
                                }

                                if($flag)
                                {
                                    $correct_answers++;
                                    $corrent_answer_question[] = $question_record->id;
                                    $subject[$subject_id]['correct_answers'] +=1;
                                    $subject[$subject_id]['time_spent_correct_answers'] 
                                                                += $time_spent[$question_record->id];
                                    $time_spent_correct_answer_question[$question_record->id]['time_to_spend'] 
                                                                    = $question_record->time_to_spend;
                                    $time_spent_correct_answer_question[$question_record->id]['time_spent'] 
                                                                    = $time_spent[$question_record->id];

                                }
                                else
                                {
                                    $wrong_answer_question[] = $question_record->id;
                                    $subject[$subject_id]['wrong_answers'] += 1;
                                     $subject[$subject_id]['time_spent_wrong_answers']    
                                                                += $time_spent[$question_record->id];
                                    $obtained_marks                   -= $negative_mark;
                                    $obtained_negative_marks          += $negative_mark;
                                    $time_spent_wrong_answer_question[$question_record->id]['time_to_spend'] 
                                                                       = $question_record->time_to_spend;
                                    $time_spent_wrong_answer_question[$question_record->id]['time_spent'] 
                                                                       = $time_spent[$question_record->id];
                                }
                              
                                break;
                case 'match':
                                $actual_answer = json_decode($actual_answer);
                                $indidual_marks = $question_record->marks/$question_record->total_correct_answers;
                                $i=0;
                                 $flag= 0;
                                foreach($actual_answer as $answer)
                                {
                                    if($answer->answer == $value[$i++])
                                    {
                                       $flag=1;
                                        $obtained_marks += $indidual_marks;
                                    }
                                }

                                if($flag)
                                {
                                    $correct_answers++;
                                    $corrent_answer_question[] = $question_record->id;
                                    $subject[$subject_id]['correct_answers'] +=1;
                                    $subject[$subject_id]['time_spent_correct_answers'] 
                                                                += $time_spent[$question_record->id];
                                    $time_spent_correct_answer_question[$question_record->id]['time_to_spend'] 
                                                                    = $question_record->time_to_spend;
                                    $time_spent_correct_answer_question[$question_record->id]['time_spent'] 
                                                                    = $time_spent[$question_record->id];

                                }
                                else
                                {
                                    $wrong_answer_question[] = $question_record->id;
                                    $subject[$subject_id]['wrong_answers'] += 1;
                                     $subject[$subject_id]['time_spent_wrong_answers']    
                                                                += $time_spent[$question_record->id];
                                    $obtained_marks                   -= $negative_mark;
                                    $obtained_negative_marks          += $negative_mark;
                                    $time_spent_wrong_answer_question[$question_record->id]['time_to_spend'] 
                                                                       = $question_record->time_to_spend;
                                    $time_spent_wrong_answer_question[$question_record->id]['time_spent'] 
                                                                       = $time_spent[$question_record->id];
                                }
                    break;
                
            }

          }
  

        }
        // dd($time_spent_correct_answer_question);
          return array(
                        'total_correct_answers' => $correct_answers,
                        'marks_obtained'        => $obtained_marks,
                        'negative_marks'        => $obtained_negative_marks,
                        'subject_analysis'      => json_encode($subject),
                        'correct_answer_questions' => json_encode($corrent_answer_question),
                        'wrong_answer_questions' => json_encode($wrong_answer_question),
                        'time_spent_correct_answer_questions' => json_encode($time_spent_correct_answer_question),
                        'time_spent_wrong_answer_questions' => json_encode($time_spent_wrong_answer_question),
                        );

    }

    /**
     * Returns the percentage of the number
     * @param  [type] $total [description]
     * @param  [type] $goal  [description]
     * @return [type]        [description]
     */
    public function getPercentage($total, $goal)
    {
        return ($total / $goal) * 100;
    }

    /**
     * Returns the specific question record based on question_id
     * @param  [type] $question_id [description]
     * @return [type]              [description]
     */
    function getQuestionRecord($question_id)
    {
        return QuestionBank::where('id','=',$question_id)->first();
    }

     /**
     * This method returns the datatables data to view
     * @return [type] [description]
     */
    public function getDatatable($slug = '')
    {
        $records = array();

        if($slug=='all')
        {
             

            $records = Quiz::join('quizcategories', 'quizzes.category_id', '=', 'quizcategories.id')
            ->select(['title', 'dueration', 'category', 'is_paid', 'total_marks','tags','quizzes.slug','quizzes.validity','quizzes.cost' ])
            ->where('total_marks', '!=', 0)
            ->where('start_date','<=',date('Y-m-d'))
            ->where('end_date','>=',date('Y-m-d'))
            ->get();

        }
        else {
            $category = QuizCategory::getRecordWithSlug($slug);
        
        $records = Quiz::join('quizcategories', 'quizzes.category_id', '=', 'quizcategories.id')
            ->select(['title', 'dueration', 'category', 'is_paid', 'total_marks','quizzes.slug', 'quizzes.validity','quizzes.cost' ])
            ->where('quizzes.category_id', '=', $category->id)
            ->where('total_marks', '!=', 0)
            ->where('start_date','<=',date('Y-m-d'))
            ->where('end_date','>=',date('Y-m-d'))
            ->get();
        }


        return Datatables::of($records)
        ->addColumn('action', function ($records) {
         
            if(!checkRole(['student']))
              if($records->is_paid)
                return '<a href="'.URL_PAYMENTS_CHECKOUT.'exam/'.$records->slug.'">'.getPhrase('buy_now').'</a>';
              else 
                return '-';
            return '<div class="dropdown more">
                        <a id="dLabel" type="button" class="more-dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="mdi mdi-dots-vertical"></i>
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="dLabel">
                            <li><a onClick="showInstructions(\''.URL_STUDENT_TAKE_EXAM.$records->slug.'\')" href="javascript:void(0);"><i class="fa fa-pencil"></i>'.getPhrase("take_exam").'</a></li>
                            
                        </ul>
                    </div>';

            })
        ->editColumn('is_paid', function($records)
        {
          $status = ($records->is_paid) ? '<span class="label label-primary">'.getPhrase('paid') .'</span>' : '<span class="label label-success">'.getPhrase('free').'</span>';
            
         if($records->is_paid) {
          $extra = '<ul class="list-unstyled payment-col clearfix"><li>'.$status.'</li>';
          $extra .='<li><p>Cost: '.getCurrencyCode().' '.$records->cost.'</p><p>Validity: '.$records->validity.' '.getPhrase("days").'</p></li></ul>';
          return $extra;
        }
          return $status;

        })
        ->editColumn('dueration', function($records)
        {
            return $records->dueration . ' '.getPhrase('mins');
        })
        ->editColumn('title', function($records) 
        {
          if(!checkRole(['student'])) {
            if($records->is_paid) {
            return '<a href="'.URL_PAYMENTS_CHECKOUT.'exam/'.$records->slug.'">'.$records->title.'</a>';
            }
           return $records->title;
          }

            $paid_type =  false;
            if($records->is_paid && !isItemPurchased($records->id, 'exam')) 
            $paid_type = true;



          if($paid_type) {
            return '<a href="'.URL_PAYMENTS_CHECKOUT.'exam/'.$records->slug.'">'.$records->title.'</a>';
            }
          
          return '<a onClick="showInstructions(\''.URL_STUDENT_TAKE_EXAM.$records->slug.'\')" href="javascript:void(0);">'.$records->title.'</a>';
        })
        ->removeColumn('tags')
        ->removeColumn('id')
        ->removeColumn('slug')
        ->removeColumn('validity')
        ->removeColumn('cost')
         
        ->make();
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


    public function reports($slug)
    {
        dd(User::getRecordWithSlug($slug));
        dd($slug);
    }

    /**
     * This method fetches the list of exam attempts made by the user based on the slug
     * @param  string $slug [description]
     * @return [type]       [description]
     */
    public function examAttempts($slug, $exam_slug = '')
    {
      $user = User::getRecordWithSlug($slug);

      if($isValid = $this->isValidRecord($user))
        return redirect($isValid);  

      if(!isEligible($slug))
          return back();

      $exam_record = FALSE;

      if($exam_slug)
      {
        $exam_record = Quiz::getRecordWithSlug($exam_slug);
      }

     
        $marks = array();
       
       if(!$exam_slug)
        {
          $marks = App\QuizResult::where('user_id', '=', $user->id)
           ->orderBy('updated_at','desc')->get();
      }
       else {
        $marks = App\QuizResult::where('user_id', '=', $user->id)
        ->where('quiz_id', '=', $exam_record->id)
           ->orderBy('updated_at','desc')->get();
       }
       
        $chartSettings = new App\ChartSettings();
        $colors = (object) $chartSettings->getRandomColors(count($marks));
        $i=0;
        $labels = [];
        $dataset = [];
        $dataset_label = [];
        $bgcolor = [];
        $border_color = [];
        foreach($marks as $record) {
            $quiz_record = $record->quizName;
            $labels[] = $quiz_record->title.' '.$record->updated_at;
            $dataset[] = $record->percentage;
            $dataset_label = $quiz_record->title.' ('.$record->percentage.'%)';
            $bgcolor[] = $colors->bgcolor[$i];
            $border_color[] = $colors->border_color[$i++];

        }
        
        
        $chart_data['type'] = 'line'; 
        //horizontalBar, bar, polarArea, line, doughnut, pie
        $chart_data['title'] = getPhrase('exam_attempts_and_score');  

        $chart_data['data']   = (object) array(
            'labels'            => $labels,
            'dataset'           => $dataset,
            'dataset_label'     => getPhrase('percentage').' (%)',
            'bgcolor'           => $bgcolor,
            'border_color'      => $border_color
            );
        
        $data['chart_data'] = (object)$chart_data;
       
      $data['active_class']       = 'analysis';
      $data['title']              = getPhrase('quiz_attempts');
      $data['user']               = $user;
      $data['exam_record']        = $exam_record;
      
        $data['layout']             = getLayout();

      return view('student.exams.attempts-history', $data);     

    }

    /**
     * This method returns the datatable for the student exam attempts
     * @param  [type] $slug [description]
     * @return [type]       [description]
     */
    public function getExamAttemptsData($slug, $exam_slug = '')
    {

        $user = User::getRecordWithSlug($slug);

         $exam_record = FALSE;
        if($exam_slug)
        {
          $exam_record = Quiz::getRecordWithSlug($exam_slug);
        
        }
         $records = array();
          if(!$exam_slug)
             $records = Quiz::join('quizresults', 'quizzes.id', '=', 'quizresults.quiz_id')
            ->select(['title','is_paid' , 'marks_obtained', 'exam_status','quizresults.created_at', 'quizzes.total_marks','quizzes.slug', 'quizresults.slug as resultsslug','user_id' ])
            ->where('user_id', '=', $user->id)
            ->orderBy('quizresults.updated_at', 'desc')
            ->get();
          else
            $records = Quiz::join('quizresults', 'quizzes.id', '=', 'quizresults.quiz_id')
            ->select(['title','is_paid' , 'marks_obtained', 'exam_status','quizresults.created_at', 'quizzes.total_marks','quizzes.slug', 'quizresults.slug as resultsslug','user_id' ])
            ->where('user_id', '=', $user->id)
            ->where('quiz_id', '=', $exam_record->id )
            ->orderBy('quizresults.updated_at', 'desc')
            ->get();

        return Datatables::of($records)
         ->addColumn('action', function($records)
        {

          $options = '<div class="dropdown more">
                        <a id="dLabel" type="button" class="more-dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="mdi mdi-dots-vertical"></i>
                        </a>

                        <ul class="dropdown-menu" aria-labelledby="dLabel">
                           <li><a href="'.URL_RESULTS_VIEW_ANSWERS.$records->slug.'/'.$records->resultsslug.'"><i class="fa fa-pencil"></i>'.getPhrase("view_answers").'</a></li>';
                      
                           $certificate_link = '';
                        if(checkRole(getUserGrade(5))){
                          if(getSetting('certificate','module'))
                          {
                            $certificate_link = '<li><a href="'.URL_GENERATE_CERTIFICATE.$records->resultsslug.'" target="_blank"><i class="fa fa-certificate"></i>'. getPhrase("generate_certificate").'</a></li>';
                           }
                         }
                           
                            
                           
                           $tail = '</ul> </div>';
          return $options.$certificate_link.$tail;
        })
        ->editColumn('title', function($records)
        {
           $user = User::where('id', '=', $records->user_id)->get()->first();
          return '<a href="'.URL_STUDENT_EXAM_ANALYSIS_BYSUBJECT.$user->slug.'/'.$records->slug.'/'.$records->resultsslug.'">'.ucfirst($records->title).'</a>';
        })
        ->editColumn('marks_obtained', function($records)
        {
          return $records->marks_obtained.' / '.$records->total_marks;
        })
        ->editColumn('is_paid', function($records)
        {
            return ($records->is_paid) ? '<span class="label label-primary">'.getPhrase('paid') .'</span>' : '<span class="label label-success">'.getPhrase('free').'</span>';
        })
        ->editColumn('exam_status', function($records)
        {
          $result = ucfirst($records->exam_status);
          return ($result=='Pass') ? '<span class="label label-success">'.$result.'</span>' : '<span class="label label-danger">'.$result.'</span>';
        })
      
     
        
        ->removeColumn('total_marks')
        ->removeColumn('total_marks')
        ->removeColumn('slug')
        ->removeColumn('quiz_id')
        ->removeColumn('created_at')
        ->removeColumn('user_id')
        ->removeColumn('resultsslug')
        ->removeColumn('grade_title')
        ->removeColumn('grade_points')
        ->removeColumn('quizzes.total_marks')
         
        ->make();
    }

    /**
     * Generates the List of exams and no. of attempts for each exam
     * @param  [type] $slug [description]
     * @return [type]       [description]
     */
    public function examAnalysis($slug)
    {
      $user = User::getRecordWithSlug($slug);
      
      if($isValid = $this->isValidRecord($user))
        return redirect($isValid);  

      if(!isEligible($slug))
          return back();

        $userid = $user->id;
      $data['active_class']       = 'analysis';
      $data['title']              = getPhrase('exam_analysis_by_attempts');
      $data['user']               = $user;
        // Chart code start
        $records = array();
       
       $records = Quiz::join('quizresults', 'quizzes.id', '=', 'quizresults.quiz_id')
            ->select(['title','is_paid' ,'dueration', 'quizzes.total_marks',  \DB::raw('count(quizresults.user_id) as attempts, quizzes.slug, user_id') ])
            ->where('user_id', '=', $user->id)
            ->groupBy('quizresults.quiz_id')
            ->get();
      
        $chartSettings = new App\ChartSettings();
        $colors = (object) $chartSettings->getRandomColors(count($records));
        $i=0;
        $labels = [];
        $dataset = [];
        $dataset_label = [];
        $bgcolor = [];

        foreach($records as $record) {
            $quiz_record = $record->title;
            $labels[] = $record->title.' ('.$record->attempts.' '.getPhrase('attempts').')';
            $dataset[] = $record->attempts;
            $dataset_label[] = $record->title.' ('.$record->attempts.' '.getPhrase('attempts').')';
            $bgcolor[] = $colors->bgcolor[$i];
            $border_color[] = $colors->border_color[$i++];

        }
        
        
        $chart_data['type'] = 'pie'; 
        //horizontalBar, bar, polarArea, line, doughnut, pie
        $chart_data['title'] = getPhrase('exam_analysis_by_attempts'); 
        $border_color=[];
        $chart_data['data']   = (object) array(
            'labels'            => $labels,
            'dataset'           => $dataset,
            'dataset_label'     => $dataset_label,
            'bgcolor'           => $bgcolor,
            'border_color'      => $border_color
            );
        
        $data['chart_data'][] = (object)$chart_data;
        //Chart Code End
        $data['layout']             = getLayout();
      return view('student.exams.analysis-by-exam', $data);  
    }

     /**
     * This method returns the datatable for the student exam attempts
     * @param  [type] $slug [description]
     * @return [type]       [description]
     */
    public function getExamAnalysisData($slug)
    {
        $user = User::getRecordWithSlug($slug);
         $records = array();

            $records = Quiz::join('quizresults', 'quizzes.id', '=', 'quizresults.quiz_id')
            ->select(['title','is_paid' ,'dueration', 'quizzes.total_marks',  \DB::raw('count(quizresults.user_id) as attempts, quizzes.slug, user_id') ])
            ->where('user_id', '=', $user->id)
            ->groupBy('quizresults.quiz_id')
            ->get();

        return Datatables::of($records)
      
         ->editColumn('title', function($records)
        {
          $user = User::where('id', '=', $records->user_id)->get()->first();
          return '<a href="'.URL_STUDENT_EXAM_ATTEMPTS.$user->slug.'/'.$records->slug.'"">'.$records->title.'</a>';
        })
        ->editColumn('is_paid', function($records)
        {
            return ($records->is_paid) ? '<span class="label label-primary">'.getPhrase('paid') .'</span>' : '<span class="label label-success">'.getPhrase('free').'</span>';
        })
       
        ->editColumn('dueration', function($records)
        {
          return $records->dueration.' '.getPhrase('mins');
        })
        ->removeColumn('quizzes.total_marks')
         ->removeColumn('slug')
         ->removeColumn('user_id')
        ->make();
    }

    /**
     * [subjectAnalysisInExam description]
     * @param  [type] $slug      [description]
     * @param  string $exam_slug [description]
     * @return [type]            [description]
     */
    public function subjectAnalysisInExam($slug, $exam_slug = '', $result_slug = '')
    {
     $user = User::getRecordWithSlug($slug);

      if($isValid = $this->isValidRecord($user))
        return redirect($isValid);  
      $exam_record = FALSE;
      
      if(!isEligible($slug))
          return back();

      if($exam_slug)
      {
        $exam_record = Quiz::getRecordWithSlug($exam_slug);
      }

      if($isValid = $this->isValidRecord($exam_record))
        return redirect($isValid);
     
        $result = array();
       
        $result = App\QuizResult::where('user_id', '=', $user->id)
        ->where('quiz_id', '=', $exam_record->id)
        ->where('slug', '=', $result_slug)
           ->get()->first();

        if($isValid = $this->isValidRecord($result))
        return redirect($isValid);
       
      //Everything is fine, we got the exam record and result record,
      //Process the result record to analyze the weekness and strength in each subject
        
        $data['quizresult'] = $result;
        $result = json_decode($result->subject_analysis);
       $subjects_display = array();
        
        $i=0;
        $color_correct = getColor('background', rand(1,999));
        $color_wrong = getColor('background', rand(1,999));
        $color_not_attempted = getColor('background', rand(1,999));
        $labels_marks = [getPhrase('correct'), getPhrase('wrong'), getPhrase('not_answered')];
        $labels_time = [getPhrase('time_spent_correct_answers'), getPhrase('time_spent_wrong_answers')];
        $dataset_time = [];
       foreach($result as $record) {

        // $colors = (object) $chartSettings->getRandomColors(count($result)+1);
        
      
        $labels = [];
        $dataset = [];
        $dataset_label = [];
        $bgcolor = [];
        $border_color = [];
       
          $subject_record = Subject::where('id', '=', $record->subject_id)->first();

            $subjects_display[$i]['subject_name'] = $subject_record->subject_title;
            $subjects_display[$i]['correct_answers'] = $record->correct_answers;
            $subjects_display[$i]['wrong_answers'] = $record->wrong_answers;
            $subjects_display[$i]['not_answered'] = $record->not_answered;

            $subjects_display[$i]['time_spent_correct_answers'] = $record->time_spent_correct_answers;
            $subjects_display[$i]['time_spent_wrong_answers'] = $record->time_spent_wrong_answers;

           $dataset_time = [$record->time_spent_correct_answers, $record->time_spent_wrong_answers];
           $bgcolor_time  = [$color_correct,$color_wrong];
           $border_color_time = [$color_correct,$color_wrong];

            $dataset = [$record->correct_answers, $record->wrong_answers, $record->not_answered];
            $dataset_label[] = $subject_record->subject_title;
            $bgcolor  = [$color_correct,$color_wrong,$color_not_attempted];
            // $bgcolor  = getColor('border');
            $border_color = [$color_correct,$color_wrong,$color_not_attempted];

        
        $time_data['type'] = 'pie';
        $time_data['title'] = $subject_record->subject_title;  
        $time_data['data']   = (object) array(
            'labels'            => $labels_time,
            'dataset'           => $dataset_time,
            'dataset_label'     => $dataset_label,
            'bgcolor'           => $bgcolor_time,
            'border_color'      => $border_color_time
            );
        
        $data['time_data'][] = (object)$time_data;



        $chart_data['type'] = 'doughnut'; 
        //horizontalBar, bar, polarArea, line, doughnut, pie
        $chart_data['title'] = $subject_record->subject_title;  

        $chart_data['data']   = (object) array(
            'labels'            => $labels_marks,
            'dataset'           => $dataset,
            'dataset_label'     => $dataset_label,
            'bgcolor'           => $bgcolor,
            'border_color'      => $border_color
            );
        
        $data['chart_data'][] = (object)$chart_data;
        $i++;
       } 
      $data['subjects_display']   = $subjects_display;
      $data['active_class']       = 'analysis';
      $data['title']              = getPhrase('subject_wise_analysis');
      $data['user']               = $user;
      $data['exam_record']        = $exam_record;
      $data['layout']             = getLayout();

      return view('student.exams.analysis-by-subject', $data);     

    }

    /**
     * This method returns the datatable for the student exam attempts
     * @param  [type] $slug [description]
     * @return [type]       [description]
     */
    public function overallSubjectAnalysis($slug)
    {
      
      $user = User::getRecordWithSlug($slug);
      if($isValid = $this->isValidRecord($user))
        return redirect($isValid);  
        
      if(!isEligible($slug))
          return back();

        $records = array();
       $records = ( new App\QuizResult())->getOverallSubjectsReport($user);
       if(!$records)
        {
          flash('Ooops..!','No Records available', 'overlay');                
          return back();
        }
        $color_correct = getColor('background',rand(00,9999));
        $color_wrong = getColor('background', rand(00,9999));
        $color_not_attempted = getColor('background', rand(00,9999)); 
        $i=0;
        $labels = [];
        $dataset = [];
        $dataset_label = [];
        $bgcolor = [];
        $border_color = [];
        
        $marks_labels = [getPhrase('correct'), getPhrase('wrong'), getPhrase('not_answered')];
        $time_labels = [getPhrase('time_spent_on_correct_answers'), getPhrase('time_spent_on_wrong_answers')];

       foreach($records as $record) {
       $record = (object)$record;
      
       //Marks
        $subjects_display[$i]['subject_name'] = $record->subject_name;
        $subjects_display[$i]['correct_answers'] = $record->correct_answers;
        $subjects_display[$i]['wrong_answers'] = $record->wrong_answers;
        $subjects_display[$i]['not_answered'] = $record->not_answered;

        // Time
         $subjects_display[$i]['time_spent_on_correct_answers'] = $record->time_spent_on_correct_answers;
         $subjects_display[$i]['time_spent_on_wrong_answers']   = $record->time_spent_on_wrong_answers;
         $subjects_display[$i]['time_to_spend']                 = $record->time_to_spend;
         $subjects_display[$i]['time_spent']                    = $record->time_spent;

      
        $marks_dataset = [$record->correct_answers, $record->wrong_answers, $record->not_answered];
        $time_dataset = [$record->time_spent_on_correct_answers, $record->time_spent_on_wrong_answers];
        $dataset_label = $record->subject_name;
       
        $bgcolor  = [$color_correct,$color_wrong,$color_not_attempted];
        
        $border_color = [$color_correct,$color_wrong,$color_not_attempted];

        
        $marks_data['type'] = 'pie'; 
        //horizontalBar, bar, polarArea, line, doughnut, pie
        $marks_data['title'] = $record->subject_name;  

        $marks_data['data']   = (object) array(
            'labels'            => $marks_labels,
            'dataset'           => $marks_dataset,
            'dataset_label'     => $dataset_label,
            'bgcolor'           => $bgcolor,
            'border_color'      => $border_color
            );
        
        $data['chart_data'][] = (object)$marks_data;


        $time_data['type'] = 'bar'; 
        //horizontalBar, bar, polarArea, line, doughnut, pie
        $time_data['title'] = $record->subject_name;  

        $time_data['data']   = (object) array(
            'labels'            => $time_labels,
            'dataset'           => $time_dataset,
            'dataset_label'     => $dataset_label,
            'bgcolor'           => $bgcolor,
            'border_color'      => $border_color
            );
        
        $data['time_data'][] = (object)$time_data;

        $i++;
       } 
     
      $data['chart_data'][] = (object)$marks_data;

      $overall_correct_answers = 0;
      $overall_wrong_answers = 0;
      $overall_not_answered = 0;

      $overall_time_spent_correct_answers = 0;
      $overall_time_spent_wrong_answers = 0;
      
      foreach($records as $r)
      {
        $r = (object)$r;
        $overall_correct_answers  += $r->correct_answers;
        $overall_wrong_answers    += $r->wrong_answers;
        $overall_not_answered     += $r->not_answered;
        
        $overall_time_spent_correct_answers     += $r->time_spent_on_correct_answers;
        $overall_time_spent_wrong_answers       += $r->time_spent_on_wrong_answers;
      }

        $overall_marks_dataset = [$overall_correct_answers, $overall_wrong_answers, $overall_not_answered];
        $overall_time_dataset = [$overall_time_spent_correct_answers, $overall_time_spent_wrong_answers];

        $overall_marks_data['type'] = 'doughnut'; 
        //horizontalBar, bar, polarArea, line, doughnut, pie
        $overall_marks_data['title'] =  getPhrase('overall_marks_analysis');
        $overall_marks_data['data']   = (object) array(
            'labels'            => $marks_labels,
            'dataset'           => $overall_marks_dataset,
            'dataset_label'     => getPhrase('overall_marks_analysis'),
            'bgcolor'           => $bgcolor,
            'border_color'      => $border_color
            );

      $data['right_bar_path']     = 'student.exams.subject-analysis.right-bar-performance-chart';
      $data['right_bar_data']     = array('right_bar_data' => (object)$overall_marks_data);
        
      $data['overall_data'][] = (object)$overall_marks_data;
       
      $data['subjects_display']   = $records;
      $data['active_class']       = 'analysis';
      $data['title']              = getPhrase('overall_subject_wise_analysis');
      $data['user']               = $user;
      $userid = $user->id;
      $data['layout']             = getLayout();

      return view('student.exams.subject-analysis.subject-analysis', $data);  
    }

   
}
