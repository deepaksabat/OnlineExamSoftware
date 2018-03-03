<div ng-if="question_type=='radio'">
    <fieldset class="form-group "> 
        {{ Form::label('total_answers', getphrase('total_options')) }}
	    <span class="text-red">*</span>
		{{Form::select('total_answers',$exam_max_options , null, ['class'=>'form-control', "id"=>"total_answers", "ng-model"=>"total_answers", "ng-change" => "answersChanged(total_answers)",
        'required'=> 'true', 
        'ng-class'=>'{"has-error": formQuestionBank.total_answers.$touched && formQuestionBank.total_answers.$invalid}',
         ])}}
           <div class="validation-error" ng-messages="formQuestionBank.total_answers.$error" >
        {!! getValidationMessage()!!}
        </div>
    </fieldset>

     <div class="row" data-ng-repeat="i in range(total_answers) track by $index" ng-if="total_answers > 0">
     
    <fieldset class="form-group col-md-4" >
        <label >Option @{{ $index+1 }}</label> <span class="text-red">*</span>
        <input type="text" name="options[]" id="option_@{{ $index }}" class="form-control" placeholder="Option @{{ $index+1 }}" ng-model="answers[$index].option_value"  min=1
        required="true" >
        
    </fieldset>

    <fieldset class="form-group col-md-4" >
    <label > {{getPhrase('image')}}</label>
         <input type="file" class="form-control" name="upload_@{{$index}}" >
        
    </fieldset>

    <fieldset ng-if="answers[$index].has_file==1" class="form-group col-md-4" >
        <label > &nbsp;&nbsp;&nbsp;</label>
        <div>
        <img src="{{$image_path}}@{{answers[$index].file_name}}" height="50" width="50" >
        </div>
    </fieldset>
    
    </div>

 
<input type="hidden" name="total_correct_answers" value="1">
<fieldset class="form-group" ng-if="total_answers > 0 ">
        
         {{Form::label('correct_answers', getphrase('answer_number')) }}
         <span class="text-red">*</span>
			
			{{ Form::number('correct_answers',  $value = null , $attributes = array('class'=>'form-control', 'name'=>'correct_answers', 'id'=>'correct_answers', 'placeholder' => '1',
                'min'=>'1',
             'ng-model'=>'correct_answers', 
            'required'=> 'true', 
            'ng-class'=>'{"has-error": formQuestionBank.correct_answers.$touched && formQuestionBank.correct_answers.$invalid}',
        )) }}
    <div class="validation-error" ng-messages="formQuestionBank.correct_answers.$error" >
        {!! getValidationMessage()!!}
        {!! getValidationMessage('number')!!}
    </div>
		 
</fieldset>
</div>