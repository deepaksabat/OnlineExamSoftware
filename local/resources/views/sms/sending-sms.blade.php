@extends($layout)

@section('content')
<div id="page-wrapper" ng-controller="payments_report" ng-init="initAngData()">
			<div class="container-fluid">
				<!-- Page Heading -->
				<div class="row">
					<div class="col-lg-12">
						<ol class="breadcrumb">
							<li><a href="{{PREFIX}}"><i class="mdi mdi-home"></i></a> </li>
						 
							<li class="active">{{getPhrase('send_sms')}}</li>
						</ol>
					</div>
				</div>
					@include('errors.errors')
				<!-- /.row -->
				
				 <div class="panel panel-custom col-lg-6 col-lg-offset-3">
					<div class="panel-heading">
					 
					<h1>{{ $title }} </h1>
					</div>
					<div class="panel-body" >
					<?php $button_name = getPhrase('send_sms'); 

					?>
			 
					{!! Form::open(array('url' => URL_SEND_SMS_NOW, 'method' => 'POST', 'name'=>'formQuiz ',  )) !!}
					<div class="row">
					 <fieldset class='form-group'>
						{{ Form::label('sms_to', getphrase('sms_to')) }}
						<div class="form-group row">
							
							<div class="col-md-4">
							{{ Form::radio('sms_to', 'student', true, array('id'=>'paid1', 'name'=>'sms_to')) }}
								<label for="paid1"> <span class="fa-stack radio-button"> <i class="mdi mdi-check active"></i> </span> {{getPhrase('students')}} </label>
							</div>
							<div class="col-md-4">
							{{ Form::radio('sms_to', 'parent', false, array('id'=>'parents', 'name'=>'sms_to')) }}
								<label for="parents"> <span class="fa-stack radio-button"> <i class="mdi mdi-check active"></i> </span> {{getPhrase('parents')}} </label>
							</div>
							<div class="col-md-4">
							{{ Form::radio('sms_to', 'admin',false, array('id'=>'free1', 'name'=>'sms_to')) }}
								
								<label for="free1"> <span class="fa-stack radio-button"> <i class="mdi mdi-check active"></i> </span> {{getPhrase('admins')}}</label> 
							</div>
						</div>
					</fieldset>
					</div>

					<div class="row">
					<fieldset class='form-group'>
						{{ Form::label('for_category', getphrase('for_category')) }}
						<div class="form-group row">
						<div class="col-md-4">
							{{ Form::radio('for_category', 1, true, array('id'=>'paid', 'name'=>'for_category', 'ng-model'=>'for_category')) }}
								<label for="paid"> <span class="fa-stack radio-button"> <i class="mdi mdi-check active"></i> </span> {{getPhrase('all')}} </label>
							</div>
							<div class="col-md-4">
							{{ Form::radio('for_category', 0, false, array('id'=>'free', 'name'=>'for_category', 'ng-model'=>'for_category')) }}
<label for="free"> <span class="fa-stack radio-button"> <i class="mdi mdi-check active"></i> </span> {{getPhrase('selected')}}</label> 
							</div>
						</div>
					</fieldset>

					 
 					
					</div>

					

					<div class="row" ng-if="for_category==0">
 @foreach($categories as $key=>$value)
 			 				
				<div class="col-md-6">
							  <input type="checkbox" name="categories[{{$key}}]" id="{{$key}}" >
                            <label for="{{$key}}"> <span class="fa-stack checkbox-button"> <i class="mdi mdi-check active"></i> 
                            </span> {{$value}} </label>
							</div>
					@endforeach
				 
					</div>

						<div class="row">
					<fieldset class='form-group  '>
						{{ Form::label('message_template', getphrase('message_template')) }}
						<div class="form-group row">
						<div class="col-md-6">
							<textarea class="form-control" name="message"></textarea>
							</div>
							 
							
						</div>
					</fieldset>

					 
 					
					</div>
					{{-- <input type="hidden" name="payment_data" value="{{$payment_data}}"> --}}
						<div class="buttons text-center">
							<button class="btn btn-lg btn-success button"
							 >{{ $button_name }}</button>
						</div>
					{!! Form::close() !!}
					</div>

				</div>
			</div>
			<!-- /.container-fluid -->
		</div>
		<!-- /#page-wrapper -->
@stop

@section('footer_scripts')
 @include('sms.scripts.js-scripts');

{{--   <script src="{{JS}}bootstrap-datepicker.min.js"></script>
 <script src="{{JS}}bootstrap-toggle.min.js"></script>  --}}  
  <script src="{{JS}}bootstrap-toggle.min.js"></script>      
@stop
 
 