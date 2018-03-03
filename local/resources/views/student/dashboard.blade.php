@extends('layouts.student.studentlayout')
@section('content')

<div id="page-wrapper">
<div class="container-fluid">
<div class="row">
<div class="col-lg-12">
<ol class="breadcrumb">

<li>{{ $title}}</li>
</ol>
</div>
</div>
<div class="row">
<div class="col-md-4">
<div class="card card-blue text-xs-center">
<div class="card-block">
<h4 class="card-title">{{ App\QuizCategory::get()->count()}}</h4>
<p class="card-text">{{ getPhrase('quiz_categories')}}</p>
</div>
<a class="card-footer text-muted" href="{{URL_STUDENT_EXAM_CATEGORIES}}">
{{ getPhrase('view_all')}}
</a>
</div>
</div>

<div class="col-md-4">
<div class="card card-yellow text-xs-center">
<div class="card-block">
<h4 class="card-title">{{ App\Quiz::get()->count()}}</h4>
<p class="card-text">{{ getPhrase('quizzes')}}</p>
</div>
<a class="card-footer text-muted" href="{{URL_STUDENT_EXAM_ALL}}">
{{ getPhrase('view_all')}}
</a>
</div>
</div>

<div class="col-md-4">
<div class="card card-green text-xs-center">
<div class="card-block">
<h4 class="card-title">{{ App\Subject::get()->count()}}</h4>
<p class="card-text">{{ getPhrase('subjects')}}</p>
</div>
<a class="card-footer text-muted" href="{{URL_STUDENT_ANALYSIS_SUBJECT.Auth::user()->slug}}">
{{ getPhrase('view_analysis')}}
</a>
</div>
</div>


</div>

<div class="row"><?php $ids=[];?>
@for($i=0; $i<count($chart_data); $i++)
<?php 
$newid = 'myChart'.$i;
$ids[] = $newid; ?>
<div class="col-md-6">  				  <div class="panel panel-primary dsPanel">				   				    <div class="panel-body" >



<canvas id="{{$newid}}" width="100" height="60"></canvas>					   </div>				  </div>				</div>

@endfor	
 			
</div>
</div>
<!-- /.container-fluid -->
</div>
<!-- /#page-wrapper -->

@stop

@section('footer_scripts')
@include('common.chart', array($chart_data,'ids' =>$ids));
@stop