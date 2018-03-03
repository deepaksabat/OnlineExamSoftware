	<input type="hidden" name="subject_id" value="{{ $subject->id }}">
	<fieldset class="form-group ">
	{{ Form::label('topic_id', getphrase('topic')) }} <span class="text-red">*</span>
	
	{{Form::select('topic_id', $topics, null, ['class'=>'form-control', "id"=>"topic_id"])}}
	</fieldset>

	<fieldset class="form-group">
		{{ Form::label('question', getphrase('question')) }} 
		<span class="text-red">*</span>
		
		{{ Form::textarea('question', $value = null , $attributes = array('class'=>'form-control ckeditor', 'placeholder' => 'Your question', 'rows' => '5',
		'ng-model'=>'question', 
		
		'ng-class'=>'{"has-error": formQuestionBank.question.$touched && formQuestionBank.question.$invalid}',
		'ng-minlength' => '4',
		 
		)) }}
	<div class="validation-error" ng-messages="formQuestionBank.question.$error" >
		{!! getValidationMessage()!!}
		{!! getValidationMessage('minlength')!!}
	</div>
	</fieldset>
	<?php 
		$settingsObj 			= new App\GeneralSettings();
		$question_types 		= $settingsObj->getQuestionTypes();	
		$exam_max_options 		= $settingsObj->getExamMaxOptions();	
		$exam_difficulty_levels = $settingsObj->getDifficultyLevels();	


		?>
	<fieldset class="form-group ">
	{{ Form::label('question_type', getphrase('question_type')) }}
	<span class="text-red">*</span>
	<?php 
	$readonly = "";
	if($record)
	$readonly = "disabled";
	?>
	{{Form::select('question_type',$question_types , null, ['class'=>'form-control', "id"=>"question_type", "ng-model"=>"question_type" ,
	 	'required'=> 'true', 
		'ng-class'=>'{"has-error": formQuestionBank.question_type.$touched && formQuestionBank.question_type.$invalid}',
		$readonly
	])}}
	<?php if($readonly) { ?>
	<input type="hidden" name="question_type" value="{{$record->question_type}}" >
	<?php } ?>
	<div class="validation-error" ng-messages="formQuestionBank.question_type.$error" >
		{!! getValidationMessage()!!}
	 
	</div>
	</fieldset>

{{-- 
		<fieldset ng-if="question_type=='video'|| question_type=='audio'" class='form-group col-md-6'>
						{{ Form::label('is_having_url', getphrase('is_having_url')) }}
						<span class="text-red">*</span>
						<div class="form-group row">
							<div class="col-md-6">
							{{ Form::radio('is_having_url', null , array('id'=>'optionNo', 'ng-model' => 'have_url' )) }}
								
								<label for="optionNo"> <span class="fa-stack radio-button"> <i class="mdi mdi-check active"></i> </span> {{getPhrase('No')}}</label> 
							</div>
							<div class="col-md-6">
							{{ Form::radio('is_having_url', null , array('id'=>'optionYes', 
							'ng-model' => 'have_url')) }}
								<label for="optionYes"> <span class="fa-stack radio-button"> <i class="mdi mdi-check active"></i> </span> {{getPhrase('Yes')}} </label>
							</div>
						</div>
					</fieldset> --}}

	<div  class="row">
	 <div class="col-md-6">
	 <fieldset class="form-group" >
         {{ Form::label('question_file', getPhrase('upload') ) }} 
         @{{question_type}} 
         <span ng-if="question_type=='video'">{{getPhrase('supported_formats are')}} .mp4
         </span>
		 <span ng-if="question_type=='audio'">{{getPhrase('supported_formats are')}} .mp3
         </span>

         <span ng-if="question_type!='audio' && question_type!='video'">({{getPhrase('supported_formats are')}}.jpeg, .jpg, .png)
         </span>
	

        {{Form::file('question_file', $attributes = array('class'=>'form-control'))}}
        {{-- <p ng-if="question_type=='video'">{{getPhrase('supported_formats are')}} .mp4</p>
        <p ng-if="question_type=='audio'">{{getPhrase('supported_formats are')}} .mp3</p> --}}
    </fieldset>
	</div> 

<div class="col-md-6">
	@if($record)
        @if($record->question_file)  
    		@include('exams.questionbank.question_partial_image_preview', array('record'=>$record))
    	@endif
    @endif
</div>
</div>
		
	<fieldset class="form-group ">
	{{ Form::label('difficulty_level', getphrase('difficulty_level')) }}
	<span class="text-red">*</span>

	{{Form::select('difficulty_level',$exam_difficulty_levels , null, ['class'=>'form-control', "id"=>"difficulty_level" ])}}
	</fieldset>
	<fieldset class="form-group">
		{{ Form::label('hint', getphrase('hint')) }} 
		{{ Form::text('hint', $value = null , $attributes = array('class'=>'form-control', 'placeholder' => 'Hint for the question')) }}
	</fieldset>

	<fieldset class="form-group">
		{{ Form::label('explanation', getphrase('explanation')) }} 
		{{ Form::textarea('explanation', $value = null , $attributes = array('class'=>'form-control ckeditor', 'placeholder' => 'Your explanation', 'rows' => '5')) }}
	</fieldset>
{{-- 	<div class="row">
		<div class="col-md-6">
		<fieldset class="form-group" >
	         {{ Form::label('explanation_file', getPhrase('explanation_file')) }}
	        {{Form::file('explanation_file', $attributes = array('class'=>'form-control'))}}
	    </fieldset>

	    </div> 

		<div class="col-md-6">
			@if($record)
		        @if($record->explanation_file)  
		    		 <img src="{{EXAM_UPLOADS.$record->explanation_file}}" height="90" width="90"/> 
		    	@endif
		    @endif
		</div>
	</div>--}}

	<fieldset class="form-group">
		{{ Form::label('marks', getphrase('marks')) }} 
		<span class="text-red">*</span>
		{{ Form::number('marks', $value = null , $attributes = array('class'=>'form-control', 'placeholder' => '1',
			'min'=>'1',
		'ng-model'=>'marks', 
		'required'=> 'true', 
		'ng-class'=>'{"has-error": formQuestionBank.marks.$touched && formQuestionBank.marks.$invalid}',
		)) }}
	<div class="validation-error" ng-messages="formQuestionBank.marks.$error" >
		{!! getValidationMessage()!!}
		{{-- {!! getValidationMessage('number')!!} --}}
	</div>
	</fieldset>
 

	<fieldset class="form-group">
		{{ Form::label('time_to_spend', getphrase('time_to_spend')) }} 
		<span class="text-red">*</span>
		{{ Form::number('time_to_spend', $value = null , $attributes = array('class'=>'form-control', 'placeholder' => getPhrase('in_seconds'),
			'min'=>'1',
		'ng-model'=>'time_to_spend', 
		'required'=> 'true', 
		'ng-class'=>'{"has-error": formQuestionBank.time_to_spend.$touched && formQuestionBank.time_to_spend.$invalid}',
		)) }}
	<div class="validation-error" ng-messages="formQuestionBank.time_to_spend.$error" >
		{!! getValidationMessage()!!}
		{{-- {!! getValidationMessage('number')!!} --}}
	</div>
	</fieldset>

	 
	
	<!-- Load the files start as independent -->
	<?php	

	 $image_path = ($record) ? PREFIX.(new ImageSettings())->getExamImagePath(): ''; ?>
	@include('exams.questionbank.form_elements_radio', array('image_path'=>$image_path))
	@include('exams.questionbank.form_elements_checkbox')
	@include('exams.questionbank.form_elements_blanks')
	@include('exams.questionbank.form_elements_match')
	<?php 
$show = TRUE;
	if($record) {
		if($record->question_type=='match')
			$show = FALSE;
		} 
		?>
		@if($show)
	@include('exams.questionbank.form_elements_para', array('record'=>$record))
		@endif
	

	<!-- Load the files end as independent -->

		<div class="buttons text-center">
			<button class="btn btn-lg btn-success button"
			ng-disabled='!formQuestionBank.$valid'>{{ $button_name }}</button>
		</div>
 