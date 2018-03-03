
<div ng-if="question_type=='match'">
    <fieldset class="form-group ">
        {{ Form::label('total_answers', getphrase('total_options')) }}
	
		{{Form::select('total_answers',$exam_max_options , null, ['class'=>'form-control', "id"=>"total_answers", "ng-model"=>"total_answers", "ng-change" => "answersChanged(total_answers)" ])}}
    </fieldset>
    <div ng-if="total_answers > 0" class="row">

     <fieldset class="form-group col-md-5" >
        <label >{{getPhrase('left_title')}}</label> <span class="text-red">*</span>
        <input type="text" name="title_left" class="form-control" placeholder="Left Title" ng-model="answers.left.title"  
        required="true" ng-class="{'has-error': formQuestionBank.title_left.$touched && formQuestionBank.title_left.$invalid}"  >
         <div class="validation-error" ng-messages="formQuestionBank.title_left.$error" >
        {!! getValidationMessage()!!}
        </div>
    </fieldset>
     <fieldset class="form-group col-md-5" >
        <label >{{getPhrase('right_title')}}</label> <span class="text-red">*</span>
        <input type="text" name="title_right" class="form-control" placeholder="Right Title" ng-model="answers.right.title" 
         required="true" ng-class="{'has-error': formQuestionBank.title_left.$touched && formQuestionBank.title_right.$invalid}"   
        >
        <div class="validation-error" ng-messages="formQuestionBank.title_right.$error" >
        {!! getValidationMessage()!!}
        </div>
    </fieldset>
    </div>


     <div class="row" data-ng-repeat="i in range(total_answers) track by $index" ng-if="total_answers > 0">
     
    <fieldset class="form-group col-md-5" >
        <label >{{getPhrase('left_option')}} @{{ $index+1 }}</label> <span class="text-red">*</span>
        <input type="text" name="options_left[]" id="option_@{{ $index }}" class="form-control" placeholder="Option @{{ $index+1 }}" ng-model="answers.left.options[$index]"  required="true">
    </fieldset>



    <fieldset class="form-group col-md-5" >
        <label >Right Option @{{ $index+1 }}</label> <span class="text-red">*</span>
        <input type="text" name="options_right[]" id="option_@{{ $index }}" class="form-control" placeholder="Option @{{ $index+1 }}" ng-model="answers.right.options[$index]"  required="true">
    </fieldset>
 
    <fieldset class="form-group col-md-2" >
        <label >Answer @{{ $index+1 }}</label> <span class="text-red">*</span>
        <input type="text" name="correct_answers[]" id="option_@{{ $index }}" class="form-control" placeholder="@{{ $index+1 }}" ng-model="correct_answers[$index].answer"  required="true" min="1">
    </fieldset>
 
    </div>
 
</div>
