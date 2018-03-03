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
					<?php $settings = getExamSettings(); ?>
					@if(count($categories))
						@foreach($categories as $c)
							<div class="col-md-3">
								<div class="library-item mouseover-box-shadow">
								<a href="{{URL_STUDENT_EXAMS.$c->slug}}">
									<div class="item-image">
									<?php $image = $settings->defaultCategoryImage;
									if(isset($c->image) && $c->image!='')
										$image = $c->image;
									?>
										<img src="{{ PREFIX.$settings->categoryImagepath.$image}}" alt="">
									</div>
									<div class="item-details">
										<h3>{{ $c->category }}</h3>
										<ul>
											<li><i class="icon-bookmark"></i> {{ count($c->quizzes()).' '.getPhrase('quizzes')}}</li>
											<li><i class="icon-eye"></i> {{getPhrase('view')}}</li>
										</ul>
									
									</div>
								</a>
								</div>
							</div>
							 @endforeach
							@else
						Ooops...! {{getPhrase('No_Categories_available')}}
						
						<a href="{{URL_USERS_SETTINGS.Auth::user()->slug}}" >{{getPhrase('click_here_to_change_your_preferences')}}</a>
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