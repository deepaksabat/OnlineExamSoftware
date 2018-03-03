@extends($layout)
<link href="{{CSS}}bootstrap-datepicker.css" rel="stylesheet">
@section('content')
<div id="page-wrapper">
			<div class="container-fluid">
				<!-- Page Heading -->
				<div class="row">
					<div class="col-lg-12">
						<ol class="breadcrumb">
							<li><a href="/"><i class="mdi mdi-home"></i></a> </li>
							<li><a href="{{URL_ADMIN_NOTIFICATIONS}}">{{ getPhrase('notifications')}}</a></li>
							<li class="active">{{isset($title) ? $title : ''}}</li>
						</ol>
					</div>
				</div>
					@include('errors.errors')
				<!-- /.row -->
				
		 <div class="panel panel-custom col-lg-8 col-lg-offset-2">
					<div class="panel-heading">
						<div class="pull-right messages-buttons">
							<a href="{{URL_ADMIN_NOTIFICATIONS}}" class="btn  btn-primary button" >{{ getPhrase('list')}}</a>
						</div>
						
					<h1>{{ $title }}  </h1>
					</div>
					<div class="panel-body" >
					<?php $button_name = getPhrase('create'); ?>
					@if ($record)
					 <?php $button_name = getPhrase('update'); ?>
						{{ Form::model($record, 
						array('url' => URL_ADMIN_NOTIFICATIONS_EDIT.$record->slug, 
						'method'=>'patch', 'name'=>'formNotifications ', 'novalidate'=>'')) }}
					@else
						{!! Form::open(array('url' => URL_ADMIN_NOTIFICATIONS_ADD, 'method' => 'POST', 'name'=>'formNotifications', 'novalidate'=>'')) !!}
					@endif
					

					 @include('notifications.form_elements', 
					 array('button_name'=> $button_name),
					 array('record' 		=> $record))
					 		
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
   {{-- <script src="{{JS}}bootstrap-datepicker.min.js"></script> --}}
@include('common.editor');
<script src="{{JS}}datepicker.min.js"></script>
 <script>
 	  $('.input-daterange').datepicker({
        autoclose: true,
        startDate: "0d",
         format: '{{getDateFormat()}}',
    });
 </script>
    
@stop
 
 