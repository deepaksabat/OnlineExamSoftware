<?php $tool_tip = '';
				if(isset($value->tool_tip))
					$tool_tip = $value->tool_tip;
$checked = '';
if($value->value)
$checked = 'checked';
				?>
<div class="col-md-6">
						   <fieldset class="form-group si setting-checkbox">
						   {{-- {{ Form::label($key, getPhrase($key)) }} --}}
						  <label data-toggle="tooltip" data-placement="top" title="{{$tool_tip}}">{{getPhrase($key)}}
						   <input 
					 		type="checkbox" 
							data-toggle="toggle" 
							data-onstyle="success" 
							data-offstyle="default"

					 		name="{{$key}}[value]" 
					 		required="true" 
					 		value = "1" 
							
							title ="{{$tool_tip}}"
							data-placement="right"
							{{$checked}}

					 		>
</label>
					 		

					 		<input
					 		type="hidden"
					 		name="{{$key}}[type]"
							value = "{{$value->type}}" >
				
							<input
					 		type="hidden"
					 		name="{{$key}}[tool_tip]"
							value = "{{$tool_tip}}" >

							</fieldset>
							</div>