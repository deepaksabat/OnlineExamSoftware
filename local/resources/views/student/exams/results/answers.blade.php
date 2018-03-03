@extends($layout)

@section('header_scripts')

 

@stop

 

 <?php

/**

 * Varables Used

 * @submitted_answers               -- The answers submitted by the user

 * @correct_answer_questions        -- It contains overall correct answer questions id's

 * @answer_status                   -- It will have a class if the answer is wrong

 * @user_answers                    -- It will hold all the user answers specific to question

 * @time_spent_correct_answers      -- It will maintain the list of time to spend and time spent on 

 *                                     question associated to question id

 * @time_spent_wrong_answers        -- It will maintain the list of time to spend and time spent on 

 *                                     question associated to question id

 * @time_spent_not_answers          -- It will maintain the list of time to spend and time spent on 

 *                                     question associated to question id

 */

 ?>

@section('content')

  <div id="page-wrapper" class="answer-sheet" ng-controller="angExamScript" >

            <div class="container-fluid">

                <!-- Page Heading -->

                <div class="row">

                    <div class="col-lg-12">

                        <ol class="breadcrumb">

                            <li><a href="{{PREFIX}}"><i class="mdi mdi-home"></i></a> </li>

                            <li><a href="{{URL_STUDENT_ANALYSIS_BY_EXAM.$user_details->slug}}">{{getPhrase('analysis')}}</a></li>

                            <li>{{$exam_record->title.' '.getPhrase('answers')}}</li>

                        </ol>

                    </div>

                </div>

                <!-- /.statistic -->

                

                <div class="panel panel-custom">

                    <div class="panel-heading">

                        <h1>{{$exam_record->title}} 



                            <span class="pull-right">{{getPhrase('result').': '.$result_record->exam_status}}

                             {{-- &nbsp;&nbsp;&nbsp;<a href="{{URL_COMPARE_WITH_TOPER.$result_record->slug}}" class="btn btn-info">Compare with topper</a> --}}

                            </span>

                        </h1> 

                        

                        </div>

                    <?php 

                   

                    $submitted_answers = [];

                            $answers = (array)json_decode($result_record->answers);



                            foreach ($answers as $key => $value) {

                                $submitted_answers[$key] = $value;

                            }



                    $correct_answer_questions = [];

                    $correct_answer_questions = (array) 

                                                json_decode($result_record->correct_answer_questions);

                     



                    $time_spent_correct_answers = 

                            getArrayFromJson($result_record->time_spent_correct_answer_questions);

                                                    

                    $time_spent_wrong_answers = getArrayFromJson($result_record->time_spent_wrong_answer_questions);



                    $time_spent_not_answers = getArrayFromJson($result_record->time_spent_not_answered_questions);

                                                



                    // print_r($time_spent_correct_answers);

                    $question_number =0;

                   ?>

                    @foreach($questions as $question)

                           <?php 

                           $question_number++;

                                $user_answers   = FALSE;

                                $time_spent     = array();



                                //Pull User Answers for this question

                                if(array_key_exists($question->id, $submitted_answers)) {

                                    $user_answers = $submitted_answers[$question->id];

                                }

 

                                 //Pull Timing details for this question for correct answers

                                if(array_key_exists($question->id, $time_spent_correct_answers)) 

                                    $time_spent = $time_spent_correct_answers[$question->id];

                                

                                 //Pull Timing details for this question for wrong answers

                                if(array_key_exists($question->id, $time_spent_wrong_answers)) 

                                    $time_spent = $time_spent_wrong_answers[$question->id];

                                 

                                 //Pull Timing details for this question which are not answered

                                if(array_key_exists($question->id, $time_spent_not_answers)) 

                                    $time_spent = $time_spent_not_answers[$question->id];

                          



                    ?> 

                    <div class="panel-body question-ans-box" id="{{$question->id}}"  style="display:none;">

                    <?php 

                   

                        $question_type = $question->question_type;



                        $subject_record = array();

                        foreach ($subjects as $subject) {

                            if($subject->id == $question->subject_id) {

                                $subject_record = $subject;

                                break;

                            }

                        }



                         $inject_data = array(

                                    'question'      => $question,

                                    'user_answers'  => $user_answers,

                                    'subject'      => $subject_record,

                                    'question_number' => $question_number,

                                    'time_spent'    => $time_spent,   

                                );

                    ?>
                    
                      @include('student.exams.results.question-metainfo',array('meta'=> $inject_data))

                         @include('student.exams.results.'.$question_type.'-answers', $inject_data)

                        

                         @if($question->explanation)

                         

                          <div class="answer-status-container">

                        <div class="row">

                            <div class="col-md-12">

                                <div class="question-status">

                                    <strong>{{getPhrase('explanation')}}: </strong>

                                        {!! $question->explanation!!}

                                </div>

                            </div>

                            

                        </div>

                        </div>

                        @endif

                         

                    </div>

                    @endforeach

     

                            <div class="row">

                                <div class="col-md-12">
<div class="d_but">
                                    <button class="btn btn-lg btn-success button prev" type="button">

                                        <i class="mdi mdi-chevron-left ">

                                        </i>

                                        {{getPhrase('previous')}}

                                    </button>

                                  

                                    <button class="btn btn-lg btn-success button next" type="button">

                                        {{ getPhrase('next')}}

                                        <i class="mdi mdi-chevron-right">

                                        </i>

                                    </button>
 </div>

                                    

                                </div>

                            </div>

                        </hr>

                    

                </div>

                <!-- /.row -->

            </div>

            <!-- /.container-fluid -->

        </div>

          

@stop

 

@section('footer_scripts')
@include('student.exams.results.scripts.js-scripts');
  
@stop