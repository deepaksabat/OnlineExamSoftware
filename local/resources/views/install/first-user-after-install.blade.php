@extends('install.install-layout')

@section('content')

<div class="login-content installation-page" >

		<div class="logo text-center"><img src="{{IMAGES}}logo.png" alt=""></div>
		@include('errors.errors')
		{!! Form::open(array('url' => URL_FIRST_USER_REGISTER, 'method' => 'POST', 'name'=>'registrationForm ', 'novalidate'=>'', 'class'=>"loginform", 'id'=>"install_form")) !!}
	
<div class="row" >
	<div class="col-md-6 col-md-offset-3">
	 
	<div class="info">
		<h3>Exam System User Details</h3>
			<p>Please enter Admin/Owner  details for this system</p>
	</div>
	
	<div class="input-group">
		<div class="input-group-addon"><i class="fa fa-user" aria-hidden="true"></i></div>

			{{ Form::text('owner_name', $value = null , $attributes = array('class'=>'form-control',
				'placeholder' => 'Owner Name',
				'ng-model'=>'system_name',
				'required'=> 'true', 
				'ng-class'=>'{"has-error": registrationForm.system_name.$touched && registrationForm.system_name.$invalid}',
				'ng-minlength' => '1',
			)) }}
			<div class="validation-error" ng-messages="registrationForm.system_name.$error" >
				<p ng-message="required">This field is required </p>
				<p ng-message="minlength">Text is too short</p>
			</div>
		</div>

		<div class="input-group">
		<div class="input-group-addon"><i class="fa fa-user" aria-hidden="true"></i></div>

			{{ Form::text('owner_user_name', $value = null , $attributes = array('class'=>'form-control',
				'placeholder' => 'Owner Username',
				'ng-model'=>'system_user_name',
				'required'=> 'true', 
				'ng-class'=>'{"has-error": registrationForm.system_user_name.$touched && registrationForm.system_user_name.$invalid}',
				'ng-minlength' => '1',
			)) }}
			<div class="validation-error" ng-messages="registrationForm.system_user_name.$error" >
				<p ng-message="required">This field is required </p>
				<p ng-message="minlength">Text is too short</p>
			</div>
		</div>

		

		<div class="input-group">
		<div class="input-group-addon"><i class="fa fa-envelope-o" aria-hidden="true"></i></div>
			{{ Form::email('owner_email', '' , $attributes = array('class'=>'form-control',
				'placeholder' => 'Owner Email',
				'ng-model'=>'owner_email',
				'required'=> 'true', 
				'ng-class'=>'{"has-error": registrationForm.owner_email.$touched && registrationForm.owner_email.$invalid}',
				'ng-minlength' => '1',
			)) }}
			<div class="validation-error" ng-messages="registrationForm.owner_email.$error" >
				<p ng-message="required">This field is required </p>
				<p ng-message="minlength">Text is too short</p>
			</div>
		</div>

		<div class="input-group">
		<div class="input-group-addon"><i class="fa fa-lock" aria-hidden="true"></i></div>
			{{ Form::password('owner_password', $attributes = array('class'=>'form-control',
				'placeholder' => 'Owner Password',
				'ng-model'=>'owner_password',
			)) }}
			 
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