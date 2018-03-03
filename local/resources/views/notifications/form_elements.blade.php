 					

 				

					<div class="row">

 					 <fieldset class="form-group col-md-6">

						

						{{ Form::label('title', getphrase('title')) }}

						<span class="text-red">*</span>

						{{ Form::text('title', $value = null , $attributes = array('class'=>'form-control', 'placeholder' => getPhrase('title'),

							'ng-model'=>'title', 

							'ng-pattern'=>getRegexPattern('name'), 

							'required'=> 'true', 

							'ng-class'=>'{"has-error": formNotifications.title.$touched && formNotifications.title.$invalid}',

							'ng-minlength' => '4',

							'ng-maxlength' => '50',

							)) }}

						<div class="validation-error" ng-messages="formNotifications.title.$error" >

	    					{!! getValidationMessage()!!}

	    					{!! getValidationMessage('pattern')!!}

	    					{!! getValidationMessage('minlength')!!}

	    					{!! getValidationMessage('maxlength')!!}

						</div>

					</fieldset>

					

					<fieldset class="form-group col-md-6">

						

						{{ Form::label('url', getphrase('url')) }}

						 

						{{ Form::text('url', $value = null , $attributes = array('class'=>'form-control', 'placeholder' => 'www.sitename.com',

							)) }}
 

					</fieldset>

				 </div>

				 

					 

 			

 			 <div class="row input-daterange" id="dp">



		 	<?php 



		 	$date_from = date('Y/m/d');



		 	$date_to = date('Y/m/d');



		 	if($record)



		 	{



		 		$date_from = $record->valid_from;



		 		$date_to = $record->valid_to;



		 	}



		 	 ?>



  				 <fieldset class="form-group col-md-6">



                                     



                        {{ Form::label('valid_from', getphrase('valid_from')) }}



                     



                        {{ Form::text('valid_from', $value = $date_from , $attributes = array('class'=>'input-sm form-control', 'placeholder' => '2015/7/17')) }}



                            

                       



                        </fieldset>







  				 <fieldset class="form-group col-md-6">



                                     



                        {{ Form::label('valid_to', getphrase('valid_to')) }}



                       



                        {{ Form::text('valid_to', $value = $date_to , $attributes = array('class'=>'input-sm form-control', 'placeholder' => '2015/7/17')) }}

 

                     



                        </fieldset>



				</div>

 		

  				  	<div class="row">

					<fieldset class="form-group  col-md-6">

						

						{{ Form::label('short_description', getphrase('short_description')) }}

						

						{{ Form::textarea('short_description', $value = null , $attributes = array('class'=>'form-control', 'rows'=>'5', 'placeholder' => getPhrase('short_description'))) }}

					</fieldset>

					<fieldset class="form-group  col-md-6">

						

						{{ Form::label('description', getphrase('description')) }}

						

						{{ Form::textarea('description', $value = null , $attributes = array('class'=>'form-control ckeditor', 'rows'=>'5', 'placeholder' => getPhrase('description'))) }}

					</fieldset>



					</div>





						<div class="buttons text-center">

							<button class="btn btn-lg btn-success button"

							ng-disabled='!formNotifications.$valid'>{{ $button_name }}</button>

						</div>

		 