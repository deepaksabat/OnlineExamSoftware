@extends('layouts.student.studentlayout')
@section('header_scripts')
 <link href="http://vjs.zencdn.net/5.10.4/video-js.css" rel="stylesheet">
  <script src="http://vjs.zencdn.net/ie8/1.1.2/videojs-ie8.min.js"></script>
@stop

@section('content')
<?php $settings = getSettings('lms'); ?>
<div id="page-wrapper">
			<div class="container-fluid">
				<!-- Page Heading -->
				<div class="row">
					<div class="col-lg-12">
						<ol class="breadcrumb">
							<li><a href="/"><i class="mdi mdi-home"></i></a> </li>
							<li><a href="/lms/content/categories">LMS</a></li>
							<li><a href="/lms/content/{{$content_type}}?category={{$category->slug}}">{{$content_type}}</a> </li>
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
						<div class="col-md-8">
							<h3>{{$record->title}}</h3> 
						</div>

						 <div class="col-md-4">
						 @if($record->image)
						 <img height="100" width="100" src="/{{$settings->contentImagepath.'/'.$record->image}}" alt=""/>
						 @endif
						</div> 
						</div>
						@if($record->content_type=='vc')
						<div class="row">
							  <video id="my-video" class="video-js vjs-big-play-centered" controls preload="auto" width="640" height="264"
							  poster="MY_VIDEO_POSTER.jpg" data-setup="{}">
							    <source src="/{{$settings->contentImagepath.'/'.$record->resource_link}}" type='video/mp4'>
							    
							    <p class="vjs-no-js">
							      To view this video please enable JavaScript, and consider upgrading to a web browser that
							      <a href="http://videojs.com/html5-video-support/" target="_blank">supports HTML5 video</a>
							    </p>
							</video>
						</div>
						@endif
						 
						<div class="row">
							{{$record->description}}
							 @if($record->resource_link)
							<p></p>
							<p class="pull-right">
								<a target="_blank" href="/{{$settings->contentImagepath.'/'.$record->resource_link}}" download="{{$record->title}}">{{getPhrase('download')}}</a>
							</p>
							@endif
						</div>
							
						@if($record->is_series)
						<div class="row">
							<div class="col-md-12">
							<ul class="list-group">
							<h4>Series List</h4>
								@foreach($series as $s)
								 <a href="/lms/content/show/{{$s->slug}}">
										  <img src="/{{ $settings->contentImagepath.'/'.$s->image}}" alt="" height="30" width="30" /> {{ $s->title}}
								</a>
								@endforeach
							</ul>
							</div>
						</div>
						@endif

					</div>

				</div>
			</div>
			
</div>
		<!-- /#page-wrapper -->

@stop

@section('footer_scripts')
 <script src="http://vjs.zencdn.net/5.10.4/video.js"></script>
 
@stop