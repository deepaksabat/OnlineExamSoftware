@extends('install.install-layout')

@section('content')

<div class="login-content installation-page" >

		<div class="logo text-center"><img src="{{IMAGES}}logo.png" alt=""></div>
		@include('errors.errors')
		{!! Form::open(array('url' => URL_INSTALL_SYSTEM, 'method' => 'POST', 'name'=>'registrationForm ', 'novalidate'=>'', 'class'=>"loginform", 'id'=>"install_form")) !!}
	
<div class="row" >
	<div class="col-md-6 col-md-offset-3">
	<div class="info">
		<h3>Server Hosting Details</h3>
<p>Please enter server login details to install this system </p>
</div>
		<div class="input-group">
		<div class="input-group-addon"><i class="fa fa-server" aria-hidden="true"></i></div>
			{{ Form::text('host_name', $value = null , $attributes = array('class'=>'form-control',
				'placeholder' => 'Host Name',
				'ng-model'=>'host_name',
				'required'=> 'true', 
				'ng-class'=>'{"has-error": registrationForm.host_name.$touched && registrationForm.host_name.$invalid}',
				'ng-minlength' => '4',
			)) }}
			<div class="validation-error" ng-messages="registrationForm.host_name.$error" >
				<p ng-message="required">This field is required </p>
				<p ng-message="minlength">Text is too short</p>
			</div>
		</div>
		<div class="input-group">
		<div class="input-group-addon"><i class="fa fa-database" aria-hidden="true"></i></div>
			{{ Form::text('database_name', $value = null , $attributes = array('class'=>'form-control',
				'placeholder' => 'Database Name',
				'ng-model'=>'database_name',
				'required'=> 'true', 
				'ng-class'=>'{"has-error": registrationForm.database_name.$touched && registrationForm.database_name.$invalid}',
				'ng-minlength' => '1',
			)) }}
			<div class="validation-error" ng-messages="registrationForm.database_name.$error" >
				<p ng-message="required">This field is required </p>
				<p ng-message="minlength">Text is too short</p>
			</div>
		</div>

		<div class="input-group">
		<div class="input-group-addon"><i class="fa fa-user" aria-hidden="true"></i></div>

			{{ Form::text('user_name', $value = null , $attributes = array('class'=>'form-control',
				'placeholder' => 'Database Username',
				'ng-model'=>'user_name',
				'required'=> 'true', 
				'ng-class'=>'{"has-error": registrationForm.user_name.$touched && registrationForm.user_name.$invalid}',
				'ng-minlength' => '1',
			)) }}
			<div class="validation-error" ng-messages="registrationForm.user_name.$error" >
				<p ng-message="required">This field is required </p>
				<p ng-message="minlength">Text is too short</p>
			</div>
		</div>


		<div class="input-group">
		<div class="input-group-addon"><i class="fa fa-lock" aria-hidden="true"></i></div>
			{{ Form::password('password', $attributes = array('class'=>'form-control',
				'placeholder' => 'Database Password',
				'ng-model'=>'password',
			)) }}
			 
		</div>

		
		<div class="input-group">
		<div class="input-group-addon"><i class="fa fa-dot-circle-o" aria-hidden="true"></i></div>
			{{ Form::text('port_number', '3306' , $attributes = array('class'=>'form-control',
				'placeholder' => 'Port Number',
				'ng-model'=>'port_number',
				'required'=> 'true', 
				'ng-class'=>'{"has-error": registrationForm.port_number.$touched && registrationForm.port_number.$invalid}',
				'ng-minlength' => '1',
			)) }}
			<div class="validation-error" ng-messages="registrationForm.port_number.$error" >
				<p ng-message="required">This field is required </p>
				<p ng-message="minlength">Text is too short</p>
			</div>
		</div>

		<div class="input-group">
		 {{ Form::label('sample_data', 'Install sample data') }} &nbsp;&nbsp;
  			<input 
		 		type="checkbox" 
				data-toggle="toggle" 
				data-onstyle="success" 
				data-offstyle="default"
		 		name="sample_data" 
		 		value = "1" 
				>
		</div>

	</div>
	
</div>
		
		


		

		

		
			<div class="text-center buttons">

				<button type="button"  class="btn button btn-success btn-lg" 

				ng-disabled='!registrationForm.$valid' onclick="submitForm();" >Next</button>

			</div>

		{!! Form::close() !!}
		

		 <div class="loadingpage text-center" style="display: none;" id="after_display">
		 	
		 	<p>Please Wait...</p>

		 	<img width="50" src="<?php echo IMAGES;?>loading.gif">
		 </div>

	</div>

@stop



@section('footer_scripts')

	@include('common.validations');
<script src="{{JS}}bootstrap-toggle.min.js"></script>
 <script>
 	function submitForm() {
 		$('#install_form').hide();
 		$('#after_display').show();
 		$('#install_form').submit();
 	}
 </script>
@stop