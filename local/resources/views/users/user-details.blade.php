 @extends($layout)
 @section('header_scripts')

@stop
@section('content')
<div id="page-wrapper">
			<div class="container-fluid">
				<!-- Page Heading -->
				<div class="row">
					<div class="col-lg-12">
						<ol class="breadcrumb">
							<li><a href="{{PREFIX}}"><i class="mdi mdi-home"></i> </a> </li>
							@if(checkRole(getUserGrade(2)))
							<li><a href="{{URL_USERS}}">{{ getPhrase('users') }}</a> </li>
							@endif
							
							@if(checkRole(getUserGrade(7)))
							<li><a href="{{URL_PARENT_CHILDREN}}">{{ getPhrase('users') }}</a> </li>
							@endif

							<li><a href="javascript:void(0);">{{ $title }}</a> </li>
						</ol>
					</div>
				
				</div>

<div class="panel panel-custom">
				 	<div class="panel-heading">						<h1>{{ getPhrase('details_of').' '.$record->name }}</h1>					</div>
					<div class="panel-body">
						<div class="profile-details text-center">
							<div class="profile-img"><img src="{{ getProfilePath($record->image,'profile')}}" alt=""></div>
							<div class="aouther-school">
								<h2>{{ $record->name}}</h2>
								<p><span>{{$record->email}}</span></p>
								
							</div>

						</div>
						<hr>
						<h3 class="profile-details-title">{{ getPhrase('reports')}}</h3>
						<div class="row">
						<div class="col-lg-3 col-md-6">
						<div class="card card-blue text-xs-center">
						<div class="card-block">
							<h4 class="card-title"><i class="fa fa-history"></i></h4>
							<p class="card-text">{{ getPhrase('exam_history')}}</p>
						</div>
							<a class="card-footer text-muted" href="{{URL_STUDENT_EXAM_ATTEMPTS.$record->slug}}">{{ getPhrase('view_details')}}</a>
						</div>
					</div>

					<div class="col-lg-3 col-md-6">
						<div class="card card-yellow text-xs-center">
							<div class="card-block">
								<h4 class="card-title"><i class="fa fa-flag"></i></h4>
								<p class="card-text">{{ getPhrase('by_exam')}}</p>
							</div>
								<a class="card-footer text-muted" href="{{URL_STUDENT_ANALYSIS_BY_EXAM.$record->slug}}">{{ getPhrase('view_details')}}</a>
						</div>
					</div>

					<div class="col-lg-3 col-md-6">
					<div class="card card-green text-xs-center">
							<div class="card-block">
								<h4 class="card-title"><i class="fa fa-key"></i></h4>
								<p class="card-text">{{ getPhrase('by_subject')}}</p>
							</div>
								<a class="card-footer text-muted" href="{{URL_STUDENT_ANALYSIS_SUBJECT.$record->slug}}">{{ getPhrase('view_details')}}</a>
						</div>
						</div>
				<div class="col-lg-3 col-md-6">
						<div class="card card-red text-xs-center">
							<div class="card-block">
								<h4 class="card-title"><i class="fa fa-credit-card"></i></h4>
								<p class="card-text">{{ getPhrase('subscriptions')}}</p>
							</div>
								<a class="card-footer text-muted" href="{{URL_PAYMENTS_LIST.$record->slug}}">{{ getPhrase('view_details')}}</a>
						</div>
					</div>
							
						</div>
						 
						</div>
						 
 
					</div>
				</div>
				</div>
			<!-- /.container-fluid -->
</div>
@endsection
 

@section('footer_scripts')
 
 @include('common.chart', array($chart_data,'ids' =>$ids));

@stop
