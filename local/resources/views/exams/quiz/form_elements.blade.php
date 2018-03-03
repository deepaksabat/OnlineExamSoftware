 					
 				
					<div class="row">
 					 <fieldset class="form-group col-md-6">
						
						{{ Form::label('title', getphrase('title')) }}
						<span class="text-red">*</span>
						{{ Form::text('title', $value = null , $attributes = array('class'=>'form-control', 'placeholder' => getPhrase('quiz_title'),
							'ng-model'=>'title', 
							'ng-pattern'=>getRegexPattern('name'), 
							'required'=> 'true', 
							'ng-class'=>'{"has-error": formQuiz.title.$touched && formQuiz.title.$invalid}',
							'ng-minlength' => '4',
							'ng-maxlength' => '40',
							)) }}
						<div class="validation-error" ng-messages="formQuiz.title.$error" >
	    					{!! getValidationMessage()!!}
	    					{!! getValidationMessage('pattern')!!}
	    					{!! getValidationMessage('minlength')!!}
	    					{!! getValidationMessage('maxlength')!!}
						</div>
					</fieldset>

					<fieldset class="form-group col-md-6">
						
						{{ Form::label('category_id', getphrase('category')) }}
						<span class="text-red">*</span>
						{{Form::select('category_id', $categories, null, ['class'=>'form-control'])}}
						
					</fieldset>

  
				    </div>

				<div class="row">
	  				 <fieldset class="form-group col-md-6">
							
							{{ Form::label('dueration', getphrase('duration')) }}
							<span class="text-red">*</span>
							{{ Form::number('dueration', $value = null , $attributes = array('class'=>'form-control', 'placeholder' => getPhrase('enter_value_in_minutes'),
								'min'=>1,
							'ng-model'=>'dueration', 
							'required'=> 'true',
							'string-to-number'=> 'true', 	
							'ng-class'=>'{"has-error": formQuiz.dueration.$touched && formQuiz.dueration.$invalid}',
							 
							)) }}
						<div class="validation-error" ng-messages="formQuiz.dueration.$error" >
	    					{!! getValidationMessage()!!}
	    					{!! getValidationMessage('number')!!}
						</div>
					</fieldset>	
	  				 <fieldset class="form-group col-md-3">
							
							{{ Form::label('total_marks', getphrase('total_marks')) }}
							<span class="text-red">*</span>
							{{ Form::text('total_marks', $value = null , $attributes = array('class'=>'form-control','readonly'=>'true' ,'placeholder' => getPhrase('It will be updated by adding the questions'))) }}
					</fieldset>	
					 <fieldset class="form-group col-md-3">
						
						{{ Form::label('pass_percentage', getphrase('pass_percentage')) }}
						<span class="text-red">*</span>
						{{ Form::number('pass_percentage', $value = null , $attributes = array('class'=>'form-control', 'placeholder' => '40',
							'min'=>'1',
							'max' =>'100',
						'ng-model'=>'pass_percentage', 
						'required'=> 'true', 
						'string-to-number'=> 'true', 

						'ng-class'=>'{"has-error": formQuiz.pass_percentage.$touched && formQuiz.pass_percentage.$invalid}',
							 
							)) }}
						<div class="validation-error" ng-messages="formQuiz.pass_percentage.$error" >
	    					{!! getValidationMessage()!!}
	    					{!! getValidationMessage('number')!!}
						</div>
				</fieldset>
				</div>
				 
				<div class="row">
				 
  				 <fieldset   class="form-group col-md-6">
						
						{{ Form::label('negative_mark', getphrase('negative_mark')) }}
						<span class="text-red">*</span>
						{{ Form::number('negative_mark', $value = null , $attributes = array('class'=>'form-control', 'placeholder' => '40',
							'min'=>'0',
							'max' =>'100',
						'ng-model'=>'negative_mark', 
						'required'=> 'true', 
						'string-to-number'=> 'true', 
						'ng-class'=>'{"has-error": formQuiz.negative_mark.$touched && formQuiz.negative_mark.$invalid}',
							 
							)) }}
						<div class="validation-error" ng-messages="formQuiz.negative_mark.$error" >
	    					{!! getValidationMessage()!!}
	    					{!! getValidationMessage('number')!!}
						</div>
				</fieldset>
					<fieldset class="form-group col-md-6">
						
						{{ Form::label('instructions_page_id', getphrase('instructions_page')) }}
						<span class="text-red">*</span>
						{{Form::select('instructions_page_id', $instructions, null, ['class'=>'form-control'])}}
						
					</fieldset>
  				 
				</div>

				<div class="row input-daterange" >
		 	<?php 
		 	$date_from = date('Y/m/d');
		 	$date_to = date('Y/m/d');
		 	if($record)
		 	{
		 		$date_from = $record->start_date;
		 		$date_to = $record->end_date;
		 	}
		 	 ?>
		 	 <fieldset class="form-group col-md-6">
				{{ Form::label('start_date', getphrase('start_date')) }}
				{{ Form::text('start_date', $value = $date_from , $attributes = array('class'=>'input-sm form-control', 'placeholder' => '2015/7/17')) }}
			</fieldset>

			<fieldset class="form-group col-md-6">
				{{ Form::label('end_date', getphrase('end_date')) }}
				{{ Form::text('end_date', $value = $date_to , $attributes = array('class'=>'input-sm form-control', 'placeholder' => '2015/7/17')) }}
 			</fieldset>

			</div>

				<div  class="row">

				<?php $payment_options = array('1'=>'Paid', '0'=>'Free');?>
					 <fieldset class="form-group col-md-6" >
						{{ Form::label('is_paid', getphrase('is_paid')) }}
						<span class="text-red">*</span>
						{{Form::select('is_paid', $payment_options, null, ['placeholder' => getPhrase('select'),'class'=>'form-control', 
						'ng-model'=>'is_paid',
							'required'=> 'true', 
							'ng-pattern' => getRegexPattern("name"),
							'ng-minlength' => '2',
							'ng-maxlength' => '20',
							'ng-class'=>'{"has-error": formQuiz.is_paid.$touched && formQuiz.is_paid.$invalid}',

						]) }}
						<div class="validation-error" ng-messages="formQuiz.is_paid.$error" >
	    					{!! getValidationMessage()!!}
						</div>


					</fieldset>

				 
					<div ng-if="is_paid==1">
	  				 <fieldset class="form-group col-md-3">
							
							{{ Form::label('validity', getphrase('validity')) }}
							<span class="text-red">*</span>
							{{ Form::number('validity', $value = null , $attributes = array('class'=>'form-control', 'placeholder' => getPhrase('validity_in_days'),
							'ng-model'=>'validity',
							'string-to-number'=> 'true', 
							'min'=>'1',
							 
							'required'=> 'true', 
							'ng-class'=>'{"has-error": formQuiz.validity.$touched && formQuiz.validity.$invalid}',
							 
							)) }}
						<div class="validation-error" ng-messages="formQuiz.validity.$error" >
	    					{!! getValidationMessage()!!}
	    					{!! getValidationMessage('number')!!}
						</div>
					</fieldset>	
	  				 <fieldset class="form-group col-md-3">
						
						{{ Form::label('cost', getphrase('cost')) }}
						<span class="text-red">*</span>
						{{ Form::number('cost', $value = null , $attributes = array('class'=>'form-control', 'placeholder' => '40',
							'min'=>'0',
							 
						'ng-model'=>'cost', 
						'required'=> 'true', 
						'string-to-number'=> 'true', 
						'ng-class'=>'{"has-error": formQuiz.cost.$touched && formQuiz.cost.$invalid}',
							 
							)) }}
						<div class="validation-error" ng-messages="formQuiz.cost.$error" >
	    					{!! getValidationMessage()!!}
	    					{!! getValidationMessage('number')!!}
						</div>
				</fieldset>
				</div>
				</div>

				 
 					
					<fieldset class="form-group">
						
						{{ Form::label('description', getphrase('description')) }}
						
						{{ Form::textarea('description', $value = null , $attributes = array('class'=>'form-control', 'rows'=>'5', 'placeholder' => getPhrase('description'))) }}
					</fieldset>


						<div class="buttons text-center">
							<button class="btn btn-lg btn-success button"
							ng-disabled='!formQuiz.$valid'>{{ $button_name }}</button>
						</div>
		 
