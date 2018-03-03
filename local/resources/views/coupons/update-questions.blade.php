@extends('layouts.admin.adminlayout')
 @section('custom_div')
 <div ng-controller="prepareQuestions">
 @stop
@section('content')
<div id="page-wrapper">
			<div class="container-fluid">
				<!-- Page Heading -->
				<div class="row">
					<div class="col-lg-12">
						<ol class="breadcrumb">
							<li><a href="{{PREFIX}}"><i class="mdi mdi-home"></i></a> </li>
							<li><a href="{{URL_QUIZZES}}">{{ getPhrase('quizzes')}}</a></li>
							<li class="active">{{isset($title) ? $title : ''}}</li>
						</ol>
					</div>
				</div>
					@include('errors.errors')
				<?php $settings = ($record) ? $settings : ''; ?>
				<div class="panel panel-custom" ng-init="initAngData({{$settings}});" >
					<div class="panel-heading">
						<div class="pull-right messages-buttons">
							<a href="{{URL_QUIZZES}}" class="btn  btn-primary button" >{{ getPhrase('list')}}</a>
						</div>
					<h1>{{ $title }}  </h1>
					</div>
					<div class="panel-body" >
					<?php $button_name = getPhrase('create'); ?>
					 		<div class="row">
							<fieldset class="form-group col-md-6">
								{{ Form::label('subject', getphrase('subjects')) }}
								<span class="text-red">*</span>
								{{Form::select('subject', $subjects, null, ['class'=>'form-control', 'ng-model' => 'subject_id', 
								'placeholder' => 'Select', 'ng-change'=>'subjectChanged(subject_id)' ])}}
							</fieldset>

								{{-- <fieldset class="form-group col-md-6">
								{{ Form::label('topic', getphrase('topics')) }}
								<span class="text-red">*</span>
								
								<select ng-model="topic" class="form-control" ng-options="item.topic_name for item in topics" >
								<option value="">Select</option>	
								</select>
								</fieldset> --}}
							{{-- 	<fieldset class="form-group col-md-6">
								{{ Form::label('difficulty', getphrase('difficulty')) }}
								
								
								<select ng-model="difficulty" class="form-control" >
								<option value="">Select</option>	
								<option value="easy">Easy</option>	
								<option value="medium">Medium</option>	
								<option value="hard">Hard</option>	
								</select>
								</fieldset> --}}

								{{-- <fieldset class="form-group col-md-6">
								{{ Form::label('question_type', getphrase('question_type')) }}
								<select ng-model="question_type" class="form-control" >
									<option selected="selected" value="">Select</option>
									<option value="radio">Single Answer</option>
									<option value="checkbox">Multi Answer</option>
									<option value="descriptive">Discriptive</option>
									<option value="blanks">Fill in blanks</option>
									<option value="match">Match the following</option>
									<option value="para">Paragraph</option>
									<option value="video">Video</option>
								</select>
								</fieldset> --}}
								{{-- <a ng-click="subjectChanged()"><i class="fa fa-refresh pull-right text-info"></i></a> --}}
								<div class="col-md-12">
							<div ng-if="subjectQuestions!=''" class="vertical-scroll" >
						
								<h4 class="text-success">Questions @{{ subjectQuestions.length}} </h4>

								<table  
								  class="table table-hover">
  									 
									<th >Subject</th>
									<th>Question</th>
									<th>Type</th>
									<th>Marks</th>	
									<th>Action</th>	
									{{-- <tr ng-repeat="i in subjectQuestions  |  searchTopic:topic| filter: difficulty track by $index"> --}}
									<tr ng-repeat="question in subjectQuestions  track by $index">
										 
										<td>@{{subject.subject_title}}</td>
										<td 
										title="@{{subjectQuestions[$index].question}}" >
										@{{subjectQuestions[$index].question}}
										</td>
										
										<td>@{{subjectQuestions[$index].marks}}</td>
										<td>@{{subjectQuestions[$index].question_type | uppercase}}</td>
										<td><a 
										 
										ng-click="addQuestion(question, subject);" class="btn btn-primary" >Add</a>
									  		
										  </td>
										
									</tr>
								</table>
								</div>	
							

					 			</div>
					 			 

					 		</div>
					 
					</div>

				</div>
			</div>
			<!-- /.container-fluid -->
		</div>
		<!-- /#page-wrapper -->
@stop
@section('footer_scripts')
@include('exams.quiz.scripts.js-scripts')
@stop
 
@section('custom_div_end')
 </div>
@stop