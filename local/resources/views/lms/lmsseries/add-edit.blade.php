@extends('layouts.admin.adminlayout')
<link href="{{CSS}}bootstrap-datepicker.css" rel="stylesheet">	
@section('content')
<div id="page-wrapper">
			<div class="container-fluid">
				<!-- Page Heading -->
				<div class="row">
					<div class="col-lg-12">
						<ol class="breadcrumb">
							<li><a href="/"><i class="mdi mdi-home"></i></a> </li>
							<li><a href="{{URL_LMS_SERIES}}">LMS {{ getPhrase('series')}}</a></li>
							<li class="active">{{isset($title) ? $title : ''}}</li>
						</ol>
					</div>
				</div>
					@include('errors.errors')
				<!-- /.row -->
				 
 <div class="panel panel-custom col-lg-8 col-lg-offset-2">
 <div class="panel-heading"> <div class="pull-right messages-buttons"> <a href="{{URL_LMS_SERIES}}" class="btn btn-primary button">{{ getPhrase('list')}}</a> </div><h1>{{ $title }}  </h1></div>
 <div class="panel-body">
					<?php $button_name = getPhrase('create'); ?>
					@if ($record)
					 <?php $button_name = getPhrase('update'); ?>
						{{ Form::model($record, 
						array('url' => URL_LMS_SERIES_EDIT.$record->slug, 
						'method'=>'patch', 'files' => true, 'name'=>'formLms ', 'novalidate'=>'')) }}
					@else
						{!! Form::open(array('url' => URL_LMS_SERIES_ADD, 'method' => 'POST', 'files' => true, 'name'=>'formLms ', 'novalidate'=>'')) !!}
					@endif
					

					 @include('lms.lmsseries.form_elements', 
					 array('button_name'=> $button_name),
					 array('record'=>$record,
					 'categories' => $categories))
					 		
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
 @include('common.editor');
 @include('common.alertify')
  <script src="{{JS}}datepicker.min.js"></script>
    <script>
 	var file = document.getElementById('image_input');

file.onchange = function(e){
    var ext = this.value.match(/\.([^\.]+)$/)[1];
    switch(ext)
    {
        case 'jpg':
        case 'jpeg':
        case 'png':

     
            break;
        default:
               alertify.error("{{getPhrase('file_type_not_allowed')}}");
            this.value='';
    }
};
$('.input-daterange').datepicker({
        autoclose: true,
        startDate: "0d",
         format: '{{getDateFormat()}}',
    });
 </script>
@stop
 
 