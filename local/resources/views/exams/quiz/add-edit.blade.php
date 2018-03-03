@extends('layouts.admin.adminlayout')
<link href="{{CSS}}bootstrap-datepicker.css" rel="stylesheet">	
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

				<!-- /.row -->

				

				<div class="panel panel-custom" >

					<div class="panel-heading">

						<div class="pull-right messages-buttons">

							<a href="{{URL_QUIZZES}}" class="btn  btn-primary button" >{{ getPhrase('list')}}</a>

						</div>

						

					<h1>{{ $title }}  </h1>

					</div>

					<div class="panel-body" >

					<?php $button_name = getPhrase('create'); ?>

					@if ($record)

					 <?php $button_name = getPhrase('update'); ?>

						{{ Form::model($record, 

						array('url' => URL_QUIZ_EDIT.'/'.$record->slug, 

						'method'=>'patch', 'files' => true, 'name'=>'formQuiz ', 'novalidate'=>'')) }}

					@else

						{!! Form::open(array('url' => URL_QUIZ_ADD, 'method' => 'POST', 'files' => true, 'name'=>'formQuiz ', 'novalidate'=>'')) !!}

					@endif

					



					 @include('exams.quiz.form_elements', 

					 array('button_name'=> $button_name),

					 array(	'categories' 		=> $categories,

					 		'instructions' 		=> $instructions,

					 		'record'			=> $record

					 		))

					 		

					{!! Form::close() !!}

					</div>



				</div>

			</div>

			<!-- /.container-fluid -->

		</div>

		<!-- /#page-wrapper -->

@stop



@section('footer_scripts')

 @include('common.validations');



  <script src="{{JS}}datepicker.min.js"></script>

 <script>
 	  $('.input-daterange').datepicker({
        autoclose: true,
        startDate: "0d",
         format: '{{getDateFormat()}}',
    });
 </script>

@stop

 

 