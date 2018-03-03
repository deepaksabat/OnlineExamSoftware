<div class="col-md-6">
 <fieldset class="form-group">
	{{ Form::label($key, getPhrase($key)) }}
	<textarea rows="5" name="{{$key}}[value]" class="form-control">{{$value->value}}</textarea>
						  
	<input type="hidden" name="{{$key}}[type]" value = "{{$value->type}}" >
<input type="hidden" name="{{$key}}[tool_tip]" value = "{{$value->tool_tip}}" >
</fieldset>
</div>