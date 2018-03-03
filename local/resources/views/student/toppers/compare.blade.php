@extends('layouts.student.studentlayout')
@section('content')

 <div id="page-wrapper">
            <div class="container-fluid">
                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <ol class="breadcrumb">
                            <li><a href="{{PREFIX}}"><i class="mdi mdi-home"></i></a> </li>
                            <li>Ranking</li>
                        </ol>
                    </div>
                </div>
         
                
                <div class="panel panel-custom">
                    <div class="panel-heading">
                        <h1>Ranking</h1> </div>
                    <div class="panel-body">
                        <div class="exam-ranking">
                            <div class="exam-ranking-heading text-center">
                                <h2>{{getPhrase('your_best_rank_is')}}  <strong>{{$rank}}</strong> {{getPhrase('in').' '.$quiz_record->title.' '.getPhrase('exam')}}</h2> </div>
                            <div class="exam-ranking-content">
                                <div class="exam-ranking-comparison">
                                    <div class="table-responsive ">
                                        <div class="panel-heading">
                                            <h4>{{getPhrase('exam_details')}}</h4></div>
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>{{getPhrase('total_users')}}</th>
                                                    <th>{{getPhrase('total_marks')}}</th>
                                                    <th>{{getPhrase('total_time')}}</th>
                                                    <th>{{getPhrase('total_questions')}}</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>{{$total_users}}</td>
                                                    <td>{{$quiz_record->total_marks}}</td>
                                                    <td>{{$quiz_record->dueration.' '.getPhrase('Mins')}}</td>
                                                    <td>{{ $quiz_record->total_questions}}</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="table-responsive ">
                                        <div class="panel-heading">
                                            <h4>Comparison</h4></div>
                                            <?php 
                                            $user = App\User::where('id',$user_record->user_id)->first();
                                            
                                            $topper =  App\User::where('id',$topper_record->user_id)->first();

                                            ?>
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>&nbsp;</th>
                                                    <th>
                                                        <div class="compare-user"> <img src="{{IMAGE_PATH_PROFILE_THUMBNAIL.$user->image}}" alt="">
                                                            <h4>{{getPhrase('your_result')}}</h4> </div>
                                                    </th>
                                                    <th>
                                                        <div class="compare-user"> <img src="{{IMAGE_PATH_PROFILE_THUMBNAIL.$topper->image}}" alt="">
                                                            <h4>{{$topper->name}}</h4> </div>
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                             <tr>
                                                    <th>{{getPhrase('percentage')}}</th>
                                                    <td>{{$user_record->percentage}} %</td>
                                                    <td>{{$topper_record->percentage}} %</td>
                                                </tr>
                                                <tr>
                                                    <th>{{getPhrase('marks_obtained')}}</th>
                                                    <td>{{ $user_record->marks_obtained }}/{{$user_record->total_marks}}</td>
                                                    <td>{{$topper_record->marks_obtained}}/{{$topper_record->total_marks}}</td>
                                                </tr>
                                               
                                                <tr>
                                                    <th>{{getPhrase('result')}}</th>
                                                    <td>{{ ucfirst($user_record->exam_status) }}</td>
                                                    <td>{{ ucfirst($topper_record->exam_status) }}</td>
                                                </tr>
                                                <tr>
                                                    <th>{{getPhrase('correct_answers')}}</th>
                                                    <td>{{count(json_decode($user_record->correct_answer_questions))}}</td>
                                                   <td>{{count(json_decode($topper_record->correct_answer_questions))}}</td>
                                                </tr>
                                                <tr>
                                                    <th>{{getPhrase('wrong_answers')}}</th>
                                                    <td>{{count(json_decode($user_record->wrong_answer_questions))}}</td>
                                                   <td>{{count(json_decode($topper_record->wrong_answer_questions))}}</td>
                                                </tr>
                                                <tr>
                                                    <th>{{getPhrase('not_answered')}}</th>
                                                    <td>{{count(json_decode($user_record->not_answered_questions))}}</td>
                                                   <td>{{count(json_decode($topper_record->not_answered_questions))}}</td>
                                                </tr>
                                                
                                                <tr>
                                                    <th>{{getPhrase('time_spent_on_correct_answers')}}</th>
                                                    <?php 
                                                    	$topperObject = new App\ExamTopper();
                                                    	$user_time_analysis = (object) $topperObject->getTimeAnalysis($user_record->time_spent_correct_answer_questions);
                                                    	$topper_time_analysis = (object) $topperObject->getTimeAnalysis($topper_record->time_spent_correct_answer_questions);
                                                    	
                                                    ?>
                                                    <td>{{ gmdate('H:i:s',$user_time_analysis->time_spent) }} / {{gmdate('H:i:s',$user_time_analysis->time_to_spend)}}</td>
                                                    <td>{{ gmdate('H:i:s',$topper_time_analysis->time_spent) }} / {{gmdate('H:i:s',$topper_time_analysis->time_to_spend)}}</td>
                                                </tr>

                                                 <tr>
                                                    <th>{{getPhrase('time_spent_on_wrong_answers')}}</th>
                                                    <?php 
                                                     
                                                    	$user_time_analysis = (object) $topperObject->getTimeAnalysis($user_record->time_spent_wrong_answer_questions);
                                                    	$topper_time_analysis = (object) $topperObject->getTimeAnalysis($topper_record->time_spent_wrong_answer_questions);
                                                    	
                                                    ?>
                                                    <td>{{ gmdate('H:i:s',$user_time_analysis->time_spent) }}  </td>
                                                    <td>{{ gmdate('H:i:s',$topper_time_analysis->time_spent) }}  </td>
                                                </tr>

                                                 <tr>
                                                    <th>{{getPhrase('time_spent_on_not_answers')}}</th>
                                                    <?php 
                                                     
                                                    	$user_time_analysis = (object) $topperObject->getTimeAnalysis($user_record->time_spent_not_answer_questions);
                                                    	$topper_time_analysis = (object) $topperObject->getTimeAnalysis($topper_record->time_spent_not_answer_questions);
                                                    	
                                                    ?>
                                                    <td>{{ gmdate('H:i:s',$user_time_analysis->time_spent) }}  </td>
                                                    <td>{{ gmdate('H:i:s',$topper_time_analysis->time_spent) }}  </td>
                                                </tr>
                                                 
                                            </tbody>
                                        </table>
                                    </div>
                                     
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
        </div>
        
		<!-- /#page-wrapper -->

@stop

@section('footer_scripts')
  {{-- @include('common.chart', array($chart_data,'ids' =>$ids)); --}}
@stop