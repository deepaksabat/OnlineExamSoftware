@extends('layouts.student.studentlayout')
@section('content')
<?php $settings = getSettings('lms'); ?>
<div id="page-wrapper">
			<div class="container-fluid">
				<!-- Page Heading -->
				<div class="row">
					<div class="col-lg-12">
						<ol class="breadcrumb">
							<li><a href="/"><i class="mdi mdi-home"></i></a> </li>
							<li class="active"> {{ $title }} </li>
						</ol>
					</div>
				</div>
				<!-- /.row -->
				<div class="panel panel-custom">
					<div class="panel-heading">
						<h1>{{$title}}</h1>
					</div>
					 <div class="panel-body">
						 

						<div class="row">
							<div class="col-md-4">
								<div class="resource-box first">
									<h2>{{getPhrase('select_category')}}</h2>
									
									<ul class="list-group">
									@foreach($categories as $cat)
									
										<?php 
										$active_class = '';
										if($category) {
											if($category == $cat->slug)
											$active_class = 'active';
										} 
										?>
										
										  <li class="list-group-item {{$active_class}}">
										  <a href="/lms/content/{{$content_type}}?category={{$cat->slug}}">
										  <img src="/{{ $settings->categoryImagepath.'/'.$cat->image}}" alt="" height="30" width="30" /> {{ $cat->category.' ('.count($cat->contents).')'}}
										  </a>
										  </li>

									@endforeach
									</ul>

								</div>
							</div>
							<div class="col-md-8">
								<div class="resource-box">
									<h2>{{$title}}</h2>

									<div class="row galleryimage">
									@foreach($list as $l)
										<div class="col-md-4">
											<a href="/lms/content/show/{{$l->slug}}" data-target="#imagebox"><img src="/{{ $settings->contentImagepath.'/'.$l->image}}" alt="" />
											</a>
											{{$l->title}}
										</div>
										
									@endforeach
										 
									</div>
								</div>
							</div>
						</div>

					</div>

				</div>
			</div>
			
</div>
		<!-- /#page-wrapper -->

@stop

@section('footer_scripts')

 
@stop