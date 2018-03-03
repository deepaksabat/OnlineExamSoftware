 					

 				

					<div class="row">

 					 <fieldset class="form-group col-md-6">

						

						{{ Form::label('title', getphrase('title')) }}

						<span class="text-red">*</span>

						{{ Form::text('title', $value = null , $attributes = array('class'=>'form-control', 'placeholder' => getPhrase('quiz_title'),

							'ng-model'=>'title', 

							'ng-pattern'=>getRegexPattern('name'), 

							'required'=> 'true', 

							'ng-class'=>'{"has-error": formInstructions.title.$touched && formInstructions.title.$invalid}',

							'ng-minlength' => '4',

							'ng-maxlength' => '40',

							)) }}

						<div class="validation-error" ng-messages="formInstructions.title.$error" >

	    					{!! getValidationMessage()!!}

	    					{!! getValidationMessage('pattern')!!}

	    					{!! getValidationMessage('minlength')!!}

	    					{!! getValidationMessage('maxlength')!!}

						</div>

					</fieldset>

				    </div>



					<fieldset class="form-group">

						{{ Form::label('content', getphrase('content')) }}

						

						{{ Form::textarea('content', $value = null , $attributes = array('class'=>'form-control editor1', 'id'=>'editor1', 'rows'=>'5', 'placeholder' => getPhrase('content'))) }}

					</fieldset>





						<div class="buttons text-center">

							<button class="btn btn-lg btn-success button"

							ng-disabled='!formInstructions.$valid'>{{ $button_name }}</button>

						</div>

		 