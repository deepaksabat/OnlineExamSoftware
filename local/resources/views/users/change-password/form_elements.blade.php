 

					 <fieldset class="form-group">

						

						{{ Form::label('old_password', getphrase('old_password')) }}

						<span class="text-red">*</span>

						{{ Form::password('old_password', $attributes = array('class'=>'form-control', 'placeholder' => getphrase('old_password'),

							'ng-model'=>'old_password',

							'required'=> 'true', 

							'ng-class'=>'{"has-error": changePassword.old_password.$touched && changePassword.old_password.$invalid}',

							'ng-minlength' => 5

						)) }}

	<div class="validation-error" ng-messages="changePassword.old_password.$error" >

		{!! getValidationMessage()!!}

		{!! getValidationMessage('password')!!}

	</div>

					</fieldset>

					 

					 <fieldset class="form-group">

						

						{{ Form::label('password', getphrase('new_password')) }}

						<span class="text-red">*</span>

						{{ Form::password('password', $attributes = array('class'=>'form-control', 'placeholder' => getphrase('new_password'),

						'ng-model'=>'password',

							'required'=> 'true', 

							'ng-class'=>'{"has-error": changePassword.password.$touched && changePassword.password.$invalid}',

							'ng-minlength' => 5

						)) }}

	<div class="validation-error" ng-messages="changePassword.password.$error" >

		{!! getValidationMessage()!!}

		{!! getValidationMessage('password')!!}

	</div>

					</fieldset>

					 <fieldset class="form-group">

						

						{{ Form::label('password_confirmation', getphrase('retype_password')) }}

						<span class="text-red">*</span>

						{{ Form::password('password_confirmation', $attributes = array('class'=>'form-control', 'placeholder' => getphrase('retype_password'),

						'ng-model'=>'password_confirmation',

							'required'=> 'true', 

							'ng-class'=>'{"has-error": changePassword.password_confirmation.$touched && changePassword.password_confirmation.$invalid}',

							'compare-to' =>"password",

							'ng-minlength' => 5

						)) }}

	<div class="validation-error" ng-messages="changePassword.password_confirmation.$error" >

		{!! getValidationMessage()!!}

		{!! getValidationMessage('password')!!}

		{!! getValidationMessage('confirmPassword')!!}

	</div>

					</fieldset>											

					 

					

						<div class="buttons text-center">

							<button class="btn btn-lg btn-success button"

							ng-disabled='!changePassword.$valid' >{{ $button_name }}</button>

						</div>