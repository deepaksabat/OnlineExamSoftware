<div class="col-md-6">
							<div class="col-md-6">

						   <fieldset class="form-group">
						   {{ Form::label($key, getPhrase($key)) }}
						  
						   <input 
					 		type="{{$value->type}}" 
					 		class="form-control" 
					 		name="{{$key}}[value]" 
					 		required="true" 
					 		value = "{{$value->value}}" >
					 		<input
					 		type="hidden"
					 		name="{{$key}}[type]"
							value = "{{$value->type}}" 
							title="{{$value->tool_tip}}"
							data-toggle="tooltip"
							
							data-placement="right"
							>
							<input type="hidden" name="{{$key}}[tool_tip]" value = "{{$value->tool_tip}}" >

							</fieldset>
							
							
							
							</div>
							<div class="col-md-6">
							 {{ Form::label('', '') }}
							<img src="{{IMAGE_PATH_SETTINGS.$value->value}}"  height="80" width="80">
							</div>
							</div>