 					
 					 <fieldset class="form-group">
						
						{{ Form::label('category', getphrase('category_name')) }}
						<span class="text-red">*</span>
						{{ Form::text('category', $value = null , $attributes = array('class'=>'form-control', 
						'placeholder' => getPhrase('enter_category_name'),
						'ng-model'=>'category',
							'required'=> 'true', 
							'ng-pattern' => getRegexPattern("name"),
							'ng-minlength' => '2',
							'ng-maxlength' => '60',
							'ng-class'=>'{"has-error": formLms.category.$touched && formLms.category.$invalid}',

						)) }}
						<div class="validation-error" ng-messages="formLms.category.$error" >
	    					{!! getValidationMessage()!!}
	    					{!! getValidationMessage('minlength')!!}
	    					{!! getValidationMessage('maxlength')!!}
	    					{!! getValidationMessage('pattern')!!}
						</div>
					</fieldset>
 					  
 					  <fieldset class="form-group" >
				   {{ Form::label('category', getphrase('image')) }}
				         <input type="file" class="form-control" name="catimage"
				          accept=".png,.jpg,.jpeg" id="image_input">
				    </fieldset>

				     <fieldset class="form-group" >
					@if($record)	
				   		@if($record->image)
				         
				         <img src="{{ IMAGE_PATH_UPLOAD_LMS_CATEGORIES.$record->image }}" height="100" width="100">
				         @endif
				     @endif
				    </fieldset>

				 
					<fieldset class="form-group">
						
						{{ Form::label('description', getphrase('description')) }}
						
						{{ Form::textarea('description', $value = null , $attributes = array('class'=>'form-control', 'rows'=>'5', 'placeholder' => 'Description')) }}
					</fieldset>
						
					</fieldset>
						<div class="buttons text-center">
							<button class="btn btn-lg btn-success button"
							ng-disabled='!formLms.$valid'>{{ $button_name }}</button>
						</div>
		 