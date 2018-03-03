@extends($layout)
@section('content')

<div id="page-wrapper">
			<div class="container-fluid">
				<!-- Page Heading -->
				<div class="row">
					<div class="col-lg-12">
						<ol class="breadcrumb">
							<li><a href="{{PREFIX}}"><i class="mdi mdi-home"></i></a> </li>
							<li class="active"> {{$title}} </li>
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
					@if(count($categories))
						@foreach($categories as $c)
							<div class="col-md-3">
							 <a href="{{URL_STUDENT_LMS_CATEGORIES_VIEW.$c->slug}}" class="library-item">
							 <?php 
							 $image = IMAGE_PATH_UPLOAD_LMS_DEFAULT;
							 if($c->image)
							 $image = IMAGE_PATH_UPLOAD_LMS_CATEGORIES.$c->image;?>
                                    <div class="item-image"> <img src="{{ $image}}" alt=""> </div>
                                    <div class="item-details">
                                        <h3>{{$c->category}}</h3> </div>
                               </a>

							</div>
							 @endforeach
						@else
						Ooops...! {{getPhrase('No_Categories_available')}}

						<a href="{{URL_USERS_SETTINGS.$user->slug}}" >{{getPhrase('click_here_to_change_your_preferences')}}</a>
						@endif
							 
						</div>
						@if(count($categories))
						{!! $categories->links() !!}
						@endif

					</div>
				</div>
			</div>
			
</div>
		<!-- /#page-wrapper -->

@stop