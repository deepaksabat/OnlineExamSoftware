@extends($layout)

@section('content')



<div id="page-wrapper">

			<div class="container-fluid">

				<!-- Page Heading -->

				<div class="row">

					<div class="col-lg-12">

						<ol class="breadcrumb">

							<li><a href="{{PREFIX}}"><i class="mdi mdi-home"></i></a> </li>

							<li class="active"> {{ $title }} </li>

						</ol>

					</div>

				</div>

				<!-- /.row -->

				<div class="panel panel-custom">

					<div class="panel-heading">

						<h1>{{$title}}</h1>

					</div>

					<div class="panel-body packages">

						 

						<div class="row library-items">

					<?php $settings = getSettings('lms'); ?>

					@if(count($series))

					<?php $entry_count = 0;?>

						@foreach($series as $c)

						

						@if($c->total_items)

							

							<div class="col-md-3">

								<div class="library-item mouseover-box-shadow">

								<div class="">

									<div class="item-image">

									@if($c->is_paid)

									<div class="label-primary label-band">{{getPhrase('premium')}}</div>

									@else

									<div class="label-danger  label-band">{{getPhrase('free')}}</div>

									@endif	



									<?php $image = $settings->defaultCategoryImage;

									if(isset($c->image) && $c->image!='')

										$image = $c->image;

									?>

										<img src="{{ IMAGE_PATH_UPLOAD_LMS_SERIES.$image}}" alt="{{$c->title}}">

										

										<div class="hover-content"> 

										<div class="buttons">

											<a href="{{URL_STUDENT_LMS_SERIES_VIEW.$c->slug}}" class="btn btn-primary">{{getPhrase('view_more')}}</a> 

										 

											</div>

										</div>

										

									</div>

									<div class="item-details">

										<h3>{{ $c->title }}</h3>

										<div class="quiz-short-discription">

										{!!$c->short_description!!}

										</div>

										<ul>

											<li><i class="icon-bookmark"></i> {{ $c->total_items.' '.getPhrase('items')}}</li>

										</ul>

									

									</div>

								</div>

								</div>

							</div>

							 

							 

							

							@endif



							 @endforeach

							@else 

							Ooops...! {{getPhrase('No_series_available')}}



						<a href="{{URL_USERS_SETTINGS.$user->slug}}" >{{getPhrase('click_here_to_change_your_preferences')}}</a>

							@endif



						</div>

						@if(count($series))

						{!! $series->links() !!}

						@endif

					</div>

				</div>

			</div>

			

</div>

		<!-- /#page-wrapper -->



@stop