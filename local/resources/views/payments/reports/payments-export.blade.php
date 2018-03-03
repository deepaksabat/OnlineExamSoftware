@extends($layout)

@section('content')
<div id="page-wrapper" ng-controller="payments_report" ng-init="initAngData()">
			<div class="container-fluid">
				<!-- Page Heading -->
				<div class="row">
					<div class="col-lg-12">
						<ol class="breadcrumb">
							<li><a href="{{PREFIX}}"><i class="mdi mdi-home"></i></a> </li>
						 
							<li class="active">{{getPhrase('export_payment_records')}}</li>
						</ol>
					</div>
				</div>
					@include('errors.errors')
				<!-- /.row -->
				
 <div class="panel panel-custom col-lg-8 col-lg-offset-2">
 <div class="panel-heading">
 <h1>{{ $title }} </h1>
					</div>
					<div class="panel-body" >
					<?php $button_name = getPhrase('download_excel'); 

					?>
			 
					{!! Form::open(array('url' => URL_PAYMENT_REPORT_EXPORT, 'method' => 'POST', 'name'=>'formQuiz ',  )) !!}
					
					<div class="row">
					<fieldset class='form-group'>
						{{ Form::label('all_records', getphrase('all_records')) }}
						<div class="form-group row">
						<div class="col-md-3">
							{{ Form::radio('all_records', 1, true, array('id'=>'paid', 'name'=>'all_records', 'ng-model'=>'all_records')) }}
								<label for="paid"> <span class="fa-stack radio-button"> <i class="mdi mdi-check active"></i> </span> {{getPhrase('Yes')}} </label>
							</div>
							<div class="col-md-3">
							{{ Form::radio('all_records', 0, false, array('id'=>'free', 'name'=>'all_records', 'ng-model'=>'all_records')) }}
								
								<label for="free"> <span class="fa-stack radio-button"> <i class="mdi mdi-check active"></i> </span> {{getPhrase('No')}}</label> 
							</div>
							
						</div>
					</fieldset>

					<div  ng-if="all_records==0">
		 	<?php 
		 	$date_from = date('Y/m/d');
		 	$date_to = date('Y/m/d');
		 	 
		 	 ?>
  				 <fieldset class="form-group col-md-3">
                                     
                        {{ Form::label('from_date', getphrase('from_date')) }}
                        <div class="input-group date" data-date="{{date('Y/m/d')}}" data-provide="datepicker" data-date-format="{{getDateFormat()}}">
                        {{ Form::text('from_date', $value = $date_from , $attributes = array('class'=>'form-control', 'placeholder' => '2015/7/17', 'id'=>'dp')) }}
                            <div class="input-group-addon">
                                <span class="mdi mdi-calendar"></span>
                            </div>
                        </div>
                        </fieldset>

  				 <fieldset class="form-group col-md-3">
                                     
                        {{ Form::label('to_date', getphrase('to_date')) }}
                        <div class="input-group date" data-date="{{date('Y/m/d')}}" data-provide="datepicker" data-date-format="{{getDateFormat()}}">
                        {{ Form::text('to_date', $value = $date_to , $attributes = array('class'=>'form-control', 'placeholder' => '2015/7/17', 'id'=>'dp1')) }}
                            <div class="input-group-addon">
                                <span class="mdi mdi-calendar"></span>
                            </div>
                        </div>
                        </fieldset>
				</div>
 					
					</div>

					

					<div class="row">
					 <fieldset class='form-group'>
						{{ Form::label('payment_type', getphrase('payment_type')) }}
						<div class="form-group row">
							<div class="col-md-4">
							{{ Form::radio('payment_type', 'all', true, array('id'=>'free1', 'name'=>'payment_type')) }}
								
								<label for="free1"> <span class="fa-stack radio-button"> <i class="mdi mdi-check active"></i> </span> {{getPhrase('all')}}</label> 
							</div>
							<div class="col-md-4">
							{{ Form::radio('payment_type', 'online', false, array('id'=>'paid1', 'name'=>'payment_type')) }}
								<label for="paid1"> <span class="fa-stack radio-button"> <i class="mdi mdi-check active"></i> </span> {{getPhrase('online')}} </label>
							</div>
							<div class="col-md-4">
							{{ Form::radio('payment_type', 'offline', false, array('id'=>'offline', 'name'=>'payment_type')) }}
								<label for="offline"> <span class="fa-stack radio-button"> <i class="mdi mdi-check active"></i> </span> {{getPhrase('offline')}} </label>
							</div>
						</div>
					</fieldset>
					</div>

					<div class="row">
					 <fieldset class='form-group'>
						{{ Form::label('payment_status', getphrase('payment_status')) }}
						<div class="form-group row">
							<div class="col-md-3">
							{{ Form::radio('payment_status', 'all', true, array('id'=>'payment_status_all', 'name'=>'payment_status')) }}
								
								<label for="payment_status_all"> <span class="fa-stack radio-button"> <i class="mdi mdi-check active"></i> </span> {{getPhrase('all')}}</label> 
							</div>
							<div class="col-md-3">
							{{ Form::radio('payment_status', 'success', false, array('id'=>'payment_status_success', 'name'=>'payment_status')) }}
								<label for="payment_status_success"> <span class="fa-stack radio-button"> <i class="mdi mdi-check active"></i> </span> {{getPhrase('success')}} </label>
							</div>
							<div class="col-md-3">
							{{ Form::radio('payment_status', 'pending', false, array('id'=>'payment_status_pending', 'name'=>'payment_status')) }}
								<label for="payment_status_pending"> <span class="fa-stack radio-button"> <i class="mdi mdi-check active"></i> </span> {{getPhrase('pending')}} </label>
							</div>
							<div class="col-md-3">
							{{ Form::radio('payment_status', 'cancelled', false, array('id'=>'payment_status_cancelled', 'name'=>'payment_status')) }}
								<label for="payment_status_cancelled"> <span class="fa-stack radio-button"> <i class="mdi mdi-check active"></i> </span> {{getPhrase('cancelled')}} </label>
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
 @include('payments.scripts.js-scripts');

  <script src="{{JS}}bootstrap-datepicker.min.js"></script>
 <script src="{{JS}}bootstrap-toggle.min.js"></script>   
    
@stop
 
 