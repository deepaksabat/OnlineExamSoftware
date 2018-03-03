 
@extends($layout)
 
@section('content')
<div id="page-wrapper">
			<div class="container-fluid">
				<!-- Page Heading -->
				<div class="row">
					<div class="col-lg-12">
						<ol class="breadcrumb">
							<li><a href="{{PREFIX}}"><i class="mdi mdi-home"></i></a> </li>
							@if(checkRole(getUserGrade(2)))
							<li><a href="{{URL_USERS}}">{{ getPhrase('users')}}</a> </li>
							<li class="active">{{isset($title) ? $title : ''}}</li>
							@else
							<li class="active">{{$title}}</li>
							@endif
						</ol>
					</div>
				</div>
					@include('errors.errors')
				<!-- /.row -->

				<?php 
				$user_options = null;
				if($record->settings)
					$user_options = json_decode($record->settings)->user_preferences;
				?>
	<div class="panel panel-custom col-lg-12" >
					<div class="panel-heading">
					@if(checkRole(getUserGrade(2))) 
						<div class="pull-right messages-buttons">
							 
							<a href="{{URL_USERS}}" class="btn  btn-primary button" >{{ getPhrase('list')}}</a>
							 
						</div>
						@endif
					<h1>{{ $title }}  </h1>
					</div>


					<div class="panel-body">
					 
					 <?php $button_name = getPhrase('update'); ?>
						{{ Form::model($record, 
						array('url' => URL_USERS_SETTINGS.$record->slug, 
						'method'=>'patch','novalidate'=>'','name'=>'formUsers ', 'files'=>'true' )) }}
					
					<h1>{{getPhrase('quiz_and_exam_series')}}</h1>

					<div class="row">
					@foreach($quiz_categories as $category)
 				<?php 

	 					$checked = '';
	 					if($user_options) {
	 						if(count($user_options->quiz_categories))
	 						{
	 							if(in_array($category->id,$user_options->quiz_categories))
	 								$checked='checked';
	 						}
	 					}
 					?>
					<div class="col-md-3">
						<label class="checkbox-inline" >
							<input type="checkbox" data-toggle="toggle" name="quiz_categories[{{$category->id}}]" data-onstyle="success" data-offstyle="default" {{$checked}}> {{$category->category}}
						</label>
					</div>
					@endforeach
				 
				 </div>

				 	<h1>LMS {{getPhrase('categories')}}</h1>

					<div class="row">
					@foreach($lms_category as $category)
 					<?php 

	 					$checked = '';
	 					if($user_options) {
	 						if(count($user_options->lms_categories))
	 						{
	 							if(in_array($category->id,$user_options->lms_categories))
	 								$checked='checked';
	 						}
	 					}
 					?>
					<div class="col-md-3">
						<label class="checkbox-inline">
							<input 	type="checkbox" 
									data-toggle="toggle" 
									data-onstyle="success" 
									data-offstyle="default"
									name="lms_categories[{{$category->id}}]" 
									{{$checked}}
									> {{$category->category}}
						</label>
					</div>
					@endforeach
				 
				 </div>

				 <div class="buttons text-center">
							<button class="btn btn-lg btn-success button"
							>{{ getPhrase('update') }}</button>
						</div>
				 
					{!! Form::close() !!}
					</div>
				</div>
			</div>
			<!-- /.container-fluid -->
		</div>
		<!-- /#page-wrapper -->
@endsection

@section('footer_scripts')
 @include('common.validations');
 <script src="{{JS}}bootstrap-toggle.min.js"></script>
@stop