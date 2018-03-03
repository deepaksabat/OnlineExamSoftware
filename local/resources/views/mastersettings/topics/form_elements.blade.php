 					
 					<fieldset class="form-group">
						{{ Form::label('subject_id', getphrase('subject')) }}
						<span class="text-red">*</span>
						{{Form::select('subject_id', $subjects, null, ['class'=>'form-control','onChange'=>'getSubjectParents()', 'id'=>'subject',
							'ng-model'=>'subject_id',
							'required'=> 'true', 
							'ng-class'=>'{"has-error": formTopics.subject_id.$touched && formTopics.subject_id.$invalid}'
						])}}
						 <div class="validation-error" ng-messages="formTopics.subject_id.$error" >
	    					{!! getValidationMessage()!!}
						</div>
					</fieldset>

					<fieldset class="form-group">
						{{ Form::label('parent_id', getphrase('select_parent')) }}
						<span class="text-red">*</span>
						{{Form::select('parent_id', $parent_topics, null, ['class'=>'form-control', 'id'=>'parent' ])}}
					</fieldset>


					 <fieldset class="form-group">
						
						{{ Form::label('topic_name', getphrase('topic_name')) }}
						<span class="text-red">*</span>
						{{ Form::text('topic_name', $value = null , $attributes = array('class'=>'form-control', 'placeholder' => 'Introduction',
							'ng-model'=>'topic_name',
							'ng-pattern' => getRegexPattern("name"),
							'required'=> 'true', 
							'ng-class'=>'{"has-error": formTopics.topic_name.$touched && formTopics.topic_name.$invalid}',
						 ))}}
						  <div class="validation-error" ng-messages="formTopics.topic_name.$error" >
	    					{!! getValidationMessage()!!}
	    					{!! getValidationMessage('pattern')!!}
	    					</div>
					</fieldset>

					<fieldset class="form-group">
						
						{{ Form::label('description', getphrase('description')) }}
						
						{{ Form::textarea('description', $value = null , $attributes = array('class'=>'form-control', 'rows'=>'5', 'placeholder' => 'Description of the topic')) }}
					</fieldset>
					
					 
 					
 				 
					 

			 

				
						<div class="buttons text-center">
							<button class="btn btn-lg btn-success button" 
							ng-disabled='!formTopics.$valid'
							>{{ $button_name }}</button>
						</div>
		 