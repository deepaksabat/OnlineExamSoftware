@extends($layout)
@section('content')

<div id="page-wrapper">
			<div class="container-fluid">
				<!-- Page Heading -->
				<div class="row">
					<div class="col-lg-12">
						<ol class="breadcrumb">
							<li><a href="{{PREFIX}}"><i class="mdi mdi-home"></i></a> </li>
							<li> <a href="{{URL_STUDENT_EXAM_SERIES_LIST}}">{{getPhrase('exam_series')}} </a> </li>
							<li class="active"> {{ $title }} </li>
						</ol>
					</div>
				</div>
				<!-- /.row -->
				<div class="panel panel-custom">
					<div class="panel-heading">

					<?php $image_path = IMAGE_PATH_UPLOAD_EXAMSERIES_DEFAULT;
					$image_path_thumb = IMAGE_PATH_UPLOAD_EXAMSERIES_DEFAULT;
					if($item->image)
					{
						$image_path = IMAGE_PATH_UPLOAD_SERIES.$item->image;
						$image_path_thumb = IMAGE_PATH_UPLOAD_SERIES_THUMB.$item->image;
					}
					?>
						<h1><img src="{{$image_path_thumb}}" alt="{{$item->title}}" > {{$title}} </h1>
					</div>
					<div class="panel-body packages">
						<div class="row">
							<div class="col-md-4">
								<img src="{{$image_path}}" alt="{{$item->title}}" class="img-responsive" >
							</div>
							<div class="col-md-8">
							<h4>{{getPhrase('overview')}}:</h4>
								{!!$item->short_description!!}
								<br>
								<b>{{getPhrase('type')}} : </b> {!! ($item->is_paid) ? '<span class="label label-primary">'.getPhrase('paid').'</span>' : '<span class="label label-warning">'.getPhrase('free').'</span>' !!}
								<br>
	
								@if($item->is_paid)
								<b>{{getPhrase('validity')}} :</b> {{$item->validity.' '.getPhrase('days')}} 
								@endif
							</div>
						</div>
					 	<div class="row">
							{!!$item->description!!}
						</div>
						<hr>
						<div class="row">
							<div class="col-md-12 text-center">
								<div class="payment-type"> 
								@if($item->is_paid && !isItemPurchased($item->id, 'combo'))
								<a href="{{URL_PAYMENTS_CHECKOUT.'combo/'.$item->slug}}" class="btn-lg btn button btn-paypal"><i class="icon-credit-card"></i> {{getPhrase('buy_now')}}</a> 
								 
								@else
								<a href="#" class="btn-lg btn button btn-card"><i class="fa fa-plane"></i> {{getPhrase('start_series')}}</a>  </div>
								@endif
							</div>
						</div>	 
					</div>
				</div>
			</div>
			
</div>
		<!-- /#page-wrapper -->

@stop