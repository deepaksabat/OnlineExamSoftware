@extends('layouts.site')

@section('content')

<div class="login-content">

		<div class="logo text-center"><img src="{{IMAGE_PATH_SETTINGS.getSetting('site_logo', 'site_settings')}}" alt="" height="59" width="211"></div>

		

		  @include('layouts.site-navigation')  



		@include('errors.errors')

		

		{!! Form::open(array('url' => URL_USERS_REGISTER, 'method' => 'POST', 'name'=>'formLanguage ', 'novalidate'=>'', 'class'=>"loginform", 'name'=>"registrationForm")) !!}

			<div class="input-group">

				<span class="input-group-addon" id="basic-addon1"><i class="icon icon-user"></i></span>

				 

		{{ Form::text('name', $value = null , $attributes = array('class'=>'form-control',

			'placeholder' => getPhrase("name"),

			'ng-model'=>'name',

			'ng-pattern' => getRegexPattern('name'),

			'required'=> 'true', 

			'ng-class'=>'{"has-error": registrationForm.name.$touched && registrationForm.name.$invalid}',

			'ng-minlength' => '4',

		)) }}

	<div class="validation-error" ng-messages="registrationForm.name.$error" >

		{!! getValidationMessage()!!}

		{!! getValidationMessage('minlength')!!}

		{!! getValidationMessage('pattern')!!}

	</div>

	



			</div>



			<div class="input-group">

				<span class="input-group-addon" id="basic-addon1"><i class="icon icon-user"></i></span>

				 

		{{ Form::text('username', $value = null , $attributes = array('class'=>'form-control',

			'placeholder' => getPhrase("username"),

			'ng-model'=>'username',

			 

			'required'=> 'true', 

			'ng-class'=>'{"has-error": registrationForm.username.$touched && registrationForm.username.$invalid}',

			'ng-minlength' => '4',

		)) }}

	<div class="validation-error" ng-messages="registrationForm.username.$error" >

		{!! getValidationMessage()!!}

		{!! getValidationMessage('minlength')!!}

		{!! getValidationMessage('pattern')!!}

	</div>

	



			</div>



			<div class="input-group">

				<span class="input-group-addon" id="basic-addon1"><i class="icon icon-email-resend"></i></span>

			{{ Form::email('email', $value = null , $attributes = array('class'=>'form-control',

			'placeholder' => getPhrase("email"),

			'ng-model'=>'email',

			'required'=> 'true', 

			'ng-class'=>'{"has-error": registrationForm.email.$touched && registrationForm.email.$invalid}',

		)) }}

	<div class="validation-error" ng-messages="registrationForm.email.$error" >

		{!! getValidationMessage()!!}

		{!! getValidationMessage('email')!!}

	</div>

				 

	</div>



			<div class="input-group">

				<span class="input-group-addon" id="basic-addon1"><i class="icon icon-lock"></i></span>

				 

		{{ Form::password('password', $attributes = array('class'=>'form-control instruction-call',

			'placeholder' => getPhrase("password"),

			'ng-model'=>'registration.password',

			'required'=> 'true', 

			'ng-class'=>'{"has-error": registrationForm.password.$touched && registrationForm.password.$invalid}',

			'ng-minlength' => 5

		)) }}

	<div class="validation-error" ng-messages="registrationForm.password.$error" >

		{!! getValidationMessage()!!}

		{!! getValidationMessage('password')!!}

	</div>



			</div>



			<div class="input-group">

				<span class="input-group-addon" id="basic-addon1"><i class="icon icon-lock"></i></span>

					{{ Form::password('password_confirmation', $attributes = array('class'=>'form-control instruction-call',

			'placeholder' => getPhrase("password_confirmation"),

			'ng-model'=>'registration.password_confirmation',

			'required'=> 'true', 

			'ng-class'=>'{"has-error": registrationForm.password_confirmation.$touched && registrationForm.password_confirmation.$invalid}',

			'ng-minlength' => 5,

			'compare-to' =>"registration.password"

		)) }}

	<div class="validation-error" ng-messages="registrationForm.password_confirmation.$error" >

		{!! getValidationMessage()!!}

		{!! getValidationMessage('minlength')!!}

		{!! getValidationMessage('confirmPassword')!!}

	</div>

			</div>

			

			<br>

	<?php $parent_module = getSetting('parent', 'module'); ?>

			@if(!$parent_module)

		<input type="hidden" name="is_student" value="0">

			@else

		<div class="row">

			

			

							<div class="col-md-6">

							{{ Form::radio('is_student', 0, true, array('id'=>'free')) }}

								

								<label for="free"> <span class="fa-stack radio-button"> <i class="mdi mdi-check active"></i> </span> {{getPhrase('i_am_a_student')}}</label> 

							</div>

							<div class="col-md-6">

							{{ Form::radio('is_student', 1, false, array('id'=>'paid' )) }}

								<label for="paid"> 

								<span class="fa-stack radio-button"> <i class="mdi mdi-check active"></i> </span> {{getPhrase('i_am_a_parent')}} </label>

							</div>

							

			</div>

		@endif

			<div class="text-center buttons">

				<button type="submit"  class="btn button btn-success btn-lg" 

				ng-disabled='!registrationForm.$valid'>{{getPhrase('register_now')}}</button>

			</div>

		{!! Form::close() !!}

		

		<a href="{{URL_USERS_LOGIN}}"><p class="text-center">{{getPhrase('i_am_having_account')}} </a></p>

		 

	</div>

@stop



@section('footer_scripts')

	@include('common.validations');

@stop