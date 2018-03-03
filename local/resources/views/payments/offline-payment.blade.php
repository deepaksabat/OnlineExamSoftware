@extends($layout)

@section('content')
<div id="page-wrapper">
			<div class="container-fluid">
				<!-- Page Heading -->
				<div class="row">
					<div class="col-lg-12">
						<ol class="breadcrumb">
							<li><a href={{PREFIX}}><i class="mdi mdi-home"></i></a> </li>
						 
							<li class="active">{{getPhrase('offline_payment_form')}}</li>
						</ol>
					</div>
				</div>
					@include('errors.errors')
				<div class="alert alert-danger">
  							<strong>{{getPhrase('warning')}}!</strong>  &nbsp;{{getPhrase('do_not_refresh_this_page')}}
					</div>
				
				<div class="panel panel-custom" >
					<div class="panel-heading">
					 
					<h1>{{ $title }} </h1>
					</div>
					<div class="panel-body" >
					<?php $button_name = getPhrase('submit'); 

					?>
					 <div class="jumbotron">
					  <h3>{{getPhrase('offline_payment_instructions')}}</h3>
					  <?php $instructions = $paypal = getSetting('offline_payment_information', 'payment_gateways'); ?>
					  {!!$instructions!!}
					</div>
					{!! Form::open(array('url' => URL_UPDATE_OFFLINE_PAYMENT, 'method' => 'POST', 'name'=>'formQuiz ',  )) !!}
					 
					<input type="hidden" name="payment_data" value="{{$payment_data}}">
					<div class="row">
					 <fieldset class="form-group col-md-12">
					 {{ Form::label('payment_details', getphrase('payment_details')) }}
						<span class="text-red">*</span>
							 <textarea name="payment_details" ng-model="payment_details"
							 required="true" class='form-control ckeditor'  rows="5"></textarea>
						<div class="validation-error"    >
	    					{!! getValidationMessage()!!}
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
<script >
	history.pushState(null, null, location.href);
window.onpopstate = function(event) {
    history.go(1);
};
</script>

 @include('common.validations');
  {{-- @include('common.editor'); --}}
    
@stop
 
 