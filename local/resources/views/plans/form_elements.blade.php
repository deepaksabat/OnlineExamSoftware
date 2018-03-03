 					
 					 <fieldset class="form-group">
						
						{{ Form::label('title', getphrase('title')) }}
						<span class="text-red">*</span>
						{{ Form::text('title', $value = null , $attributes = array('class'=>'form-control', 'placeholder' => 'Plan Title')) }}
					</fieldset>
					<fieldset class="form-group">
						{{ Form::label('name', getphrase('name')) }}
						<span class="text-red">*</span>
						{{ Form::text('name', $value = null , $attributes = array('class'=>'form-control', 'placeholder' => 'Plan Name')) }}
					</fieldset>
					 <fieldset class="form-group">
						<?php //$settings = getSettings('email'); 
						$type = array(	'main'	=> 'Main',
												'addon'	=> 'Addon');
						?>
						{{ Form::label('type', getphrase('type')) }}
						<span class="text-red">*</span>
						{{Form::select('type',$type , null, ['class'=>'form-control' ])}}
					</fieldset>
 					  
 					 <fieldset class="form-group">
						{{ Form::label('amount', getphrase('amount')) }}
						<span class="text-red">*</span>
						{{ Form::text('amount', $value = null , $attributes = array('class'=>'form-control', 'placeholder' => '300')) }}
					</fieldset>

 


					<fieldset class="form-group">
						
						{{ Form::label('description', getphrase('description')) }}
						<span class="text-red">*</span>
						{{ Form::textarea('description', $value = null , $attributes = array('class'=>'form-control', 'rows'=>'5', 'placeholder' => 'Plan details')) }}
					</fieldset>
					
						<div class="buttons text-center">
							<button class="btn btn-lg btn-success button">{{ $button_name }}</button>
						</div>
		 