 				<?php 
 				$readonly = '';
 				$disabled = '';
					if($record) {
						$readonly = 'readonly="TRUE"';
						$disabled = 'disabled = "TRUE"';
					}
				?>

 					 <fieldset class="form-group">
						
						{{ Form::label('key', getphrase('key')) }}
						<span class="text-red">*</span>
						{{ Form::text('title', $value = null , $attributes = array('class'=>'form-control', 'placeholder' => getPhrase('key'),
							'ng-model'=>'title',
							'ng-pattern' => getRegexPattern("name"),
							'required'=> 'true', 
							$readonly,
							'ng-class'=>'{"has-error": formEmails.title.$touched && formEmails.title.$invalid}'
						)) }}
						<div class="validation-error" ng-messages="formEmails.title.$error" >
	    					{!! getValidationMessage()!!}
	    					{!! getValidationMessage('pattern')!!}
	    					</div>
					</fieldset>

					 <fieldset class="form-group">
						<?php $settings = getSettings('email'); 
							// dd($settings->record_type);
						 	$email_types = (array) $settings->record_type; ?>
						 	
						{{ Form::label('type', getphrase('type')) }}
						<span class="text-red">*</span>
						{{Form::select('type',$email_types , null, [
						'class'=>'form-control',
						$disabled,
						 ])}}
					</fieldset>
 					  
 					 <fieldset class="form-group">
						{{ Form::label('subject', getphrase('subject')) }}
						<span class="text-red">*</span>
						{{ Form::text('subject', $value = null , $attributes = array('class'=>'form-control', 'placeholder' => getPhrase('welcome'),
							'ng-model'=>'subject',
							'ng-pattern' => getRegexPattern("name"),
							'required'=> 'true', 
							'ng-class'=>'{"has-error": formEmails.subject.$touched && formEmails.subject.$invalid}'
						)) }}
						<div class="validation-error" ng-messages="formEmails.subject.$error" >
	    					{!! getValidationMessage()!!}
	    					{!! getValidationMessage('pattern')!!}
	    					</div>
					</fieldset>


					<fieldset class="form-group">
						{{ Form::label('from_email', getphrase('from_email')) }}
						<span class="text-red">*</span>
						{{ Form::email('from_email', $value = null , $attributes = array('class'=>'form-control', 'placeholder' => 'name@domain.com',
							'ng-model'=>'from_email',
							'required'=> 'true', 
							'ng-class'=>'{"has-error": formEmails.from_email.$touched && formEmails.from_email.$invalid}'
						)) }}
						<div class="validation-error" ng-messages="formEmails.from_email.$error" >
	    					{!! getValidationMessage()!!}
	    					{!! getValidationMessage('email')!!}
	    					</div>
					</fieldset>

					<fieldset class="form-group">
						{{ Form::label('from_name', getphrase('from_name')) }}
						<span class="text-red">*</span>
						{{ Form::text('from_name', $value = null , $attributes = array('class'=>'form-control', 'placeholder' => 'Jack',
							'ng-model'=>'from_name',
							'ng-pattern' => getRegexPattern("name"),
							'required'=> 'true', 
							'ng-class'=>'{"has-error": formEmails.from_name.$touched && formEmails.from_name.$invalid}'
						)) }}
						<div class="validation-error" ng-messages="formEmails.from_name.$error" >
	    					{!! getValidationMessage()!!}
	    					{!! getValidationMessage('pattern')!!}
	    					</div>
					</fieldset>


					<fieldset class="form-group">
						
						{{ Form::label('content', getphrase('content')) }}
						<span class="text-red">*</span>
						{{ Form::textarea('content', $value = null , $attributes = array('class'=>'form-control ckeditor', 'rows'=>'5', 'placeholder' => getPhrase('Email Content'),
							'ng-model'=>'content',
							'required'=> 'true', 
							'ng-class'=>'{"has-error": formEmails.content.$touched && formEmails.content.$invalid}'
						)) }}
						<div class="validation-error" ng-messages="formEmails.content.$error" >
	    					{!! getValidationMessage()!!}
	    					</div>
					</fieldset>
					
						<div class="buttons text-center">
							<button class="btn btn-lg btn-success button" ng-disabled='!formEmails.$valid'>{{ $button_name }}</button>
						</div>
		 