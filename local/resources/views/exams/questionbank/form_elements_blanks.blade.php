<div ng-if="question_type=='blanks'">
     

 
 <fieldset class="form-group" >
        {{ Form::label('total_correct_answers', getphrase('total_blank_answers')) }}
    	 <span class="text-red">*</span>
        {{Form::select('total_correct_answers',$exam_max_options , null, ['class'=>'form-control', "id"=>"total_correct_answers", "ng-model"=>"total_correct_answers", "ng-change" => "correctAnswersChanged(total_correct_answers)",
     	'required'=> 'true', 
        'ng-class'=>'{"has-error": formQuestionBank.total_correct_answers.$touched && formQuestionBank.total_correct_answers.$invalid}',
         ])}}
           <div class="validation-error" ng-messages="formQuestionBank.total_correct_answers.$error" >
        {!! getValidationMessage()!!}
        </div>
    </fieldset>


<fieldset class="form-group" data-ng-repeat="i in range(total_correct_answers) track by $index" ng-if="total_correct_answers > 0">
        
         <label >Answer @{{ $index+1 }}</label> <span class="text-red">*</span>
        <input type="text" name="correct_answers[]" id="option_@{{ $index }}" class="form-control" placeholder="Answer @{{ $index+1 }}" ng-model="correct_answers[$index].answer" required="true">
    </fieldset>
		 
</fieldset>

</div>