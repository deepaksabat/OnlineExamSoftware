 					
 				
					<div class="row">
 					 <fieldset class="form-group col-md-6">
						
						{{ Form::label('title', getphrase('title')) }}
						<span class="text-red">*</span>
						{{ Form::text('title', $value = null , $attributes = array('class'=>'form-control', 'placeholder' => getPhrase('series_title'),
							'ng-model'=>'title', 
							'ng-pattern'=>getRegexPattern('name'), 
							'required'=> 'true', 
							'ng-class'=>'{"has-error": formQuiz.title.$touched && formQuiz.title.$invalid}',
							'ng-minlength' => '2',
							'ng-maxlength' => '40',
							)) }}
						<div class="validation-error" ng-messages="formQuiz.title.$error" >
	    					{!! getValidationMessage()!!}
	    					{!! getValidationMessage('pattern')!!}
	    					{!! getValidationMessage('minlength')!!}
	    					{!! getValidationMessage('maxlength')!!}
						</div>
					</fieldset>
						<fieldset class="form-group col-md-3">
						
						{{ Form::label('category_id', getphrase('category')) }}
						<span class="text-red">*</span>
						{{Form::select('category_id', $categories, null, ['class'=>'form-control'])}}
						
					</fieldset>

				 
					<?php 
					$options = array('0'=> getPhrase('free'), '1'=> getPhrase('paid')); 
						?>
					

				    <fieldset class="form-group col-md-3">
						
						{{ Form::label('is_paid', getphrase('is_paid')) }}
						<span class="text-red">*</span>
						{{Form::select('is_paid', $options, null, ['class'=>'form-control','ng-model'=>'is_paid'])}}
						
					</fieldset>
  
				    </div>
					

				 
				<div ng-if="is_paid==1" class="row">
	  				 <fieldset class="form-group col-md-6">
							
							{{ Form::label('validity', getphrase('validity')) }}
							<span class="text-red">*</span>
							{{ Form::number('validity', $value = null , $attributes = array('class'=>'form-control', 'placeholder' => getPhrase('validity_in_days'),
							'ng-model'=>'validity',
							'string-to-number'=>'true',
							'min'=>'1',
							 
							'required'=> 'true', 
							'ng-class'=>'{"has-error": formQuiz.validity.$touched && formQuiz.validity.$invalid}',
							 
							)) }}
						<div class="validation-error" ng-messages="formQuiz.validity.$error" >
	    					{!! getValidationMessage()!!}
	    					{!! getValidationMessage('number')!!}
						</div>
					</fieldset>	
	  				 <fieldset class="form-group col-md-6">
						
						{{ Form::label('cost', getphrase('cost')) }}
						<span class="text-red">*</span>
						{{ Form::number('cost', $value = null , $attributes = array('class'=>'form-control', 'placeholder' => '40',
							'string-to-number'=>'true',
							'min'=>'1',
							 
						'ng-model'=>'cost', 
						'required'=> 'true', 
						'ng-class'=>'{"has-error": formQuiz.cost.$touched && formQuiz.cost.$invalid}',
							 
							)) }}
						<div class="validation-error" ng-messages="formQuiz.cost.$error" >
	    					{!! getValidationMessage()!!}
	    					{!! getValidationMessage('number')!!}
						</div>
				</fieldset>

				</div>
				<div class="row">
 					  <fieldset class="form-group col-md-6" >
				   {{ Form::label('image', getphrase('image')) }}
				         <input type="file" class="form-control" name="image" 
				         accept=".png,.jpg,.jpeg" id="image_input">
				          
				         <div class="validation-error" ng-messages="formCategories.image.$error" >
	    					{!! getValidationMessage('image')!!}
    				 
						</div>
				    </fieldset>

				     <fieldset class="form-group col-md-4" >
					@if($record)
				   		@if($record->image)
				         <?php $examSettings = getExamSettings(); ?>
				         <img src="{{ IMAGE_PATH_UPLOAD_SERIES.$record->image }}" height="100" width="100" >

				         @endif
				     @endif
					

				    </fieldset>

				    </div>

				<div class="row">
  				 

				<fieldset class="form-group col-md-6">
							
							{{ Form::label('total_exams', getphrase('total_exams')) }}
							<span class="text-red">*</span>
							{{ Form::text('total_exams', $value = null , $attributes = array('class'=>'form-control','readonly'=>'true' ,'placeholder' => getPhrase('It will be updated by adding the exams'))) }}
					</fieldset>
				<fieldset class="form-group col-md-6">
							
							{{ Form::label('total_questions', getphrase('total_questions')) }}
							<span class="text-red">*</span>
							{{ Form::text('total_questions', $value = null , $attributes = array('class'=>'form-control','readonly'=>'true' ,'placeholder' => getPhrase('It will be updated by adding the exams'))) }}
					</fieldset>
				
  				 
				</div>

				 <div class="row input-daterange" id="dp">
				<?php 
				$date_from = date('Y/m/d');
				$date_to = date('Y/m/d');
				if($record)
				{
					// dd($record);
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

				 
 					<div class="row">
					<fieldset class="form-group  col-md-6">
						
						{{ Form::label('short_description', getphrase('short_description')) }}
						
						{{ Form::textarea('short_description', $value = null , $attributes = array('class'=>'form-control ckeditor', 'rows'=>'5', 'placeholder' => getPhrase('short_description'))) }}
					</fieldset>
					<fieldset class="form-group  col-md-6">
						
						{{ Form::label('description', getphrase('description')) }}
						
						{{ Form::textarea('description', $value = null , $attributes = array('class'=>'form-control ckeditor', 'rows'=>'5', 'placeholder' => getPhrase('description'))) }}
					</fieldset>

					</div>
						<div class="buttons text-center">
							<button class="btn btn-lg btn-success button"
							ng-disabled='!formQuiz.$valid'>{{ $button_name }}</button>
						</div>
		 
