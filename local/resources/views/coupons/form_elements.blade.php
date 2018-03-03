 					

 				

					<div class="row">

 					 <fieldset class="form-group col-md-6">

						{{ Form::label('title', getphrase('title')) }}

						<span class="text-red">*</span>

						{{ Form::text('title', $value = null , $attributes = array('class'=>'form-control', 'placeholder' => getPhrase('title'),

							'ng-model'=>'title', 

							'ng-pattern'=>getRegexPattern('name'), 

							'required'=> 'true', 

							'ng-class'=>'{"has-error": formQuiz.title.$touched && formQuiz.title.$invalid}',

							'ng-minlength' => '4',

							'ng-maxlength' => '60',

							)) }}

						<div class="validation-error" ng-messages="formQuiz.title.$error" >

	    					{!! getValidationMessage()!!}

	    					{!! getValidationMessage('pattern')!!}

	    					{!! getValidationMessage('minlength')!!}

	    					{!! getValidationMessage('maxlength')!!}

						</div>

					</fieldset>

					

					<fieldset class="form-group col-md-6">

						

						{{ Form::label('coupon_code', getphrase('coupon_code')) }}

						<span class="text-red">*</span>

						{{ Form::text('coupon_code', $value = null , $attributes = array('class'=>'form-control', 'placeholder' => getPhrase('coupon_code'),

							'ng-model'=>'coupon_code', 

							'required'=> 'true', 

							'ng-class'=>'{"has-error": formQuiz.coupon_code.$touched && formQuiz.coupon_code.$invalid}',

							'ng-minlength' => '2',

							'ng-maxlength' => '20',

							)) }}

						<div class="validation-error" ng-messages="formQuiz.coupon_code.$error" >

	    					{!! getValidationMessage()!!}

	    					{!! getValidationMessage('pattern')!!}

	    					{!! getValidationMessage('minlength')!!}

	    					{!! getValidationMessage('maxlength')!!}

						</div>

					</fieldset>

				 </div>

				 <div class="row">

					<fieldset class="form-group col-md-6">

						<?php $discount_types = array('value' => getPhrase('value'), 'percent' => getPhrase('percent'), );?>

						{{ Form::label('discount_type', getphrase('discount_type')) }}

						<span class="text-red">*</span>

						{{Form::select('discount_type', $discount_types, null, ['class'=>'form-control'])}}

						

					</fieldset> 

					 <fieldset class="form-group col-md-6">

							

							{{ Form::label('discount_value', getphrase('discount_value')) }}

							<span class="text-red">*</span>

							{{ Form::number('discount_value', $value = null , $attributes = array('class'=>'form-control', 'placeholder' => getPhrase('enter_value'),
                            'min'=>1,
							'ng-model'=>'discount_value', 

							'required'=> 'true', 

							'ng-class'=>'{"has-error": formQuiz.discount_value.$touched && formQuiz.discount_value.$invalid}',

							 

							)) }}

						<div class="validation-error" ng-messages="formQuiz.discount_value.$error" >

	    					{!! getValidationMessage()!!}

	    					{!! getValidationMessage('number')!!}

						</div>

					</fieldset>

					</div>

					<div class="row">

					 <fieldset class="form-group col-md-6">

							

							{{ Form::label('minimum_bill', getphrase('minimum_bill')) }}

							<span class="text-red">*</span>

							{{ Form::number('minimum_bill', $value = null , $attributes = array('class'=>'form-control', 'placeholder' => getPhrase('enter_minimum_bill'),
                            'min'=>1,
							'ng-model'=>'minimum_bill', 

							'required'=> 'true', 

							'ng-class'=>'{"has-error": formQuiz.minimum_bill.$touched && formQuiz.minimum_bill.$invalid}',

							 

							)) }}

						<div class="validation-error" ng-messages="formQuiz.minimum_bill.$error" >

	    					{!! getValidationMessage()!!}

	    					{!! getValidationMessage('number')!!}

						</div>

					</fieldset>





					 <fieldset class="form-group col-md-6">

							

							{{ Form::label('discount_maximum_amount', getphrase('discount_maximum_amount')) }}

							<span class="text-red">*</span>

							{{ Form::number('discount_maximum_amount', $value = null , $attributes = array('class'=>'form-control', 'placeholder' => getPhrase('enter_maximum_amount'),
								'min'=>1,
							'ng-model'=>'discount_maximum_amount', 

							'required'=> 'true', 

							'ng-class'=>'{"has-error": formQuiz.discount_maximum_amount.$touched && formQuiz.discount_maximum_amount.$invalid}',

							 

							)) }}

						<div class="validation-error" ng-messages="formQuiz.discount_maximum_amount.$error" >

	    					{!! getValidationMessage()!!}

	    					{!! getValidationMessage('number')!!}

						</div>

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

					 <fieldset class="form-group col-md-6">

							

							{{ Form::label('usage_limit', getphrase('usage_limit')) }}

							<span class="text-red">*</span>

							{{ Form::number('usage_limit', $value = null , $attributes = array('class'=>'form-control', 'placeholder' => getPhrase('enter_usage_limit_per_user'),
								'min'=>1,
							'ng-model'=>'usage_limit', 

							'required'=> 'true', 

							'ng-class'=>'{"has-error": formQuiz.usage_limit.$touched && formQuiz.usage_limit.$invalid}',

							 

							)) }}

						<div class="validation-error" ng-messages="formQuiz.usage_limit.$error" >

	    					{!! getValidationMessage()!!}

	    					{!! getValidationMessage('number')!!}

						</div>

					</fieldset>



				<fieldset class="form-group col-md-6">

						<?php $status = array('Active' =>'Active', 'Inactive' => 'Inactive', );?>

						{{ Form::label('status', getphrase('status')) }}

						<span class="text-red">*</span>

						{{Form::select('status', $status, null, ['class'=>'form-control'])}}

						

					</fieldset> 

				</div>



					<h1>Applicable Categories</h1>

				<?php 

				$user_options = null;

				if($record)

				if($record->coupon_code_applicability)

					$user_options = json_decode($record->coupon_code_applicability)->categories;







				?>

					<div class="row">

						@foreach($categories as $key=>$value)

 					<?php 

 					 //echo '<br>'.$value.':v---'.print_r($user_options);

	 					$checked = '';

	 					if($user_options) {

	 						if(count($user_options))

	 						{

	 							if(in_array($key,$user_options))

	 								$checked='checked';

	 						}

	 					}

 					?>

					<div class="col-lg-3">

						<label class="checkbox-inline">

							<input 	type="checkbox" 

									data-toggle="toggle" 

									data-onstyle="success" 

									data-offstyle="default"

									name="applicability[{{$key}}]" 

									{{$checked}}

									> {{$value}}

						</label>

					</div>

					@endforeach

					</div>

  				  





						<div class="buttons text-center">

							<button class="btn btn-lg btn-success button"

							ng-disabled='!formQuiz.$valid'>{{ $button_name }}</button>

						</div>

		 