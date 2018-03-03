<!DOCTYPE html>

<html lang="en" dir="{{ (App\Language::isDefaultLanuageRtl()) ? 'rtl' : 'ltr' }}">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="{{getSetting('meta_description', 'seo_settings')}}">
	<meta name="keywords" content="{{getSetting('meta_keywords', 'seo_settings')}}">
	 
	<link rel="icon" href="{{IMAGE_PATH_SETTINGS.getSetting('site_favicon', 'site_settings')}}" type="image/x-icon" />
	<title>@yield('title') {{ isset($title) ? $title : getSetting('site_title','site_settings') }}</title>
	<!-- Bootstrap Core CSS -->
	 @yield('header_scripts')
	<link href="{{CSS}}bootstrap.min.css" rel="stylesheet">
	<link rel="stylesheet" href="{{CSS}}bootstrap-datepicker.min.css">
	<link href="{{CSS}}sweetalert.css" rel="stylesheet" type="text/css">
	
	<!-- Morris Charts CSS -->
	<link href="{{CSS}}plugins/morris.css" rel="stylesheet">
	<!-- Custom CSS -->
	<link href="{{CSS}}sb-admin.css" rel="stylesheet">
	<!-- Custom Fonts -->
	<link href="{{CSS}}custom-fonts.css" rel="stylesheet" type="text/css">
	<link href="{{CSS}}materialdesignicons.css" rel="stylesheet" type="text/css">
	<link href="{{FONTAWSOME}}font-awesome.min.css" rel="stylesheet" type="text/css">
	
	
	<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body ng-app="academia">
 @yield('custom_div')
 <?php 
 $class = '';
 if(!isset($right_bar))
 	$class = 'no-right-sidebar';

 ?>
	<div id="wrapper" class="{{$class}}">
		<!-- Navigation -->
		<nav class="navbar navbar-custom navbar-fixed-top" role="navigation">
			<!-- Brand and toggle get grouped for better mobile display -->
			<div class="navbar-header">
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse"> <span class="sr-only">Toggle navigation</span> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </button>
				<a class="navbar-brand" href="{{PREFIX}}"><img src="{{IMAGE_PATH_SETTINGS.getSetting('site_logo', 'site_settings')}}" alt="{{getSetting('site_title','site_settings')}}"></a>
			</div>

			<!-- Top Menu Items -->
			<?php $newUsers = (new App\User())->getLatestUsers(); ?>
			<ul class="nav navbar-right top-nav">
				<li class="dropdown"> <a href="#" class="dropdown-toggle" data-toggle="dropdown">
				<i class="icon-topbar-event"></i> {{ getPhrase('latest_users') }}  </a>
					<div class="dropdown-menu dropdown-menu-right dropdown-menu-notif" aria-labelledby="dd-notification">
					<div class="dropdown-menu-notif-list" id="latestUsers">
					@foreach($newUsers as $user)
							<div class="dropdown-menu-notif-item">
								<div class="photo">
									<img src="{{ getProfilePath($user->image)}}" alt="">
								</div>
								 <a href="{{URL_USER_DETAILS.$user->slug}}">{{ucfirst($user->name)}}</a>  {{ getPhrase('was_joined_as').' '. getRoleData($user->role_id)}}
								<div class="color-blue-grey-lighter">{{$user->updated_at->diffForHumans()}}</div>
							</div>
					@endforeach
						</div>

						<div class="dropdown-menu-notif-more">
							<a href="{{URL_USERS}}">{{ getPhrase('see_more') }}</a>
						</div>
					</div>
				</li>
				
				 
				<li class="dropdown profile-menu">
					<div class="dropdown-toggle top-profile-menu" data-toggle="dropdown">
						@if(Auth::check())
						<div class="username">
							<h2>{{Auth::user()->name}}</h2>
							 
						</div>
						@endif
						
						<div class="profile-img"> <img src="{{ getProfilePath(Auth::user()->image, 'thumb') }}" alt=""> </div>
						<div class="mdi mdi-menu-down"></div>
					</div>
					<ul class="dropdown-menu">
						<li>
							<a href="{{URL_USERS_EDIT}}{{Auth::user()->slug}}">
								<sapn>{{ getPhrase('my_profile') }}</sapn>
							</a>
						</li>
						<li>
							<a href="{{URL_USERS_CHANGE_PASSWORD}}{{Auth::user()->slug}}">
								<sapn>{{ getPhrase('change_password') }}</sapn>
								</a>
						</li>
					 
						<li>
							<a href="{{URL_USERS_LOGOUT}}">
								<sapn>{{ getPhrase('logout') }}</sapn>
							</a>
						</li>
					</ul>
				</li>
			</ul>
			<!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
			<!-- /.navbar-collapse -->
		</nav>
		 @if(env('DEMO_MODE')) 
		<div class="alert alert-info demo-alert">
		&nbsp;&nbsp;&nbsp;<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
  			<strong>{{getPhrase('info')}}!</strong> CRUD {{getPhrase('operations_are_disabled_in_demo_version')}}
		</div>
		@endif
		<aside class="left-sidebar">			<div class="collapse navbar-collapse navbar-ex1-collapse">				<ul class="nav navbar-nav side-nav">					<li {{ isActive($active_class, 'dashboard') }}> 
						<a href="{{PREFIX}}">
							<i class="icon-home"></i> {{ getPhrase('dashboard') }} 
						</a> 
					</li>

					<li {{ isActive($active_class, 'languages') }}> <a href="{{URL_LANGUAGES_LIST}}">
					<i class="fa fa-language" aria-hidden="true"></i> {{ getPhrase('languages') }} </a> </li>
					
					<li {{ isActive($active_class, 'users') }}> <a href="{{URL_USERS}}"><i class=" icon-users"></i> {{ getPhrase('users') }} </a> </li>

 
					

					<li {{ isActive($active_class, 'exams') }} > 

					<a data-toggle="collapse" data-target="#exams"><i class=" icon-exams" ></i> 
					{{ getPhrase('exams') }} </a> 
					
					<ul id="exams" class="collapse sidemenu-dropdown">
							<li><a href="{{URL_QUIZ_CATEGORIES}}"> <i class="fa fa-random"></i>{{ getPhrase('categories') }}</a></li>
							<li><a href="{{URL_QUIZ_QUESTIONBANK}}"> <i class="fa fa-question"></i>{{ getPhrase('question_bank') }}</a></li>

							<li><a href="{{URL_QUIZZES}}"> <i class="icon-total-time"></i> {{ getPhrase('quiz')}}</a></li>
							<li><a href="{{URL_EXAM_SERIES}}"> <i class="fa fa-list-ol"></i> {{ getPhrase('exam_series')}}</a></li>
							<li><a href="{{URL_INSTRUCTIONS}}"> <i class="fa fa-hand-o-right"></i> {{ getPhrase('instructions')}}</a></li>
							<li><a href="{{URL_MASTERSETTINGS_SUBJECTS}}"> <i class="icon-books"></i> {{ getPhrase('subjects_master')}}</a></li>
							
							<li><a href="{{URL_MASTERSETTINGS_TOPICS}}"> <i class="fa fa-database"></i> {{ getPhrase('subject_topics')}}</a></li>

					</ul>

					</li>


					<li {{ isActive($active_class, 'coupons') }} > 

					<a data-toggle="collapse" data-target="#coupons"><i class="fa fa-hashtag"></i> 
					{{ getPhrase('coupons') }} </a> 
					
					<ul id="coupons" class="collapse sidemenu-dropdown">
							<li><a href="{{URL_COUPONS}}"> <i class="fa fa-list"></i>{{ getPhrase('list') }}</a></li>
							<li><a href="{{URL_COUPONS_ADD}}"> <i class="fa fa-plus"></i>{{ getPhrase('add') }}</a></li>
						 
					</ul>

					</li>

					<li {{ isActive($active_class, 'lms') }} > 

					<a data-toggle="collapse" data-target="#lms"><i class="icon-school-hub" ></i> 
					LMS </a> 
					
					<ul id="lms" class="collapse sidemenu-dropdown">
							<li><a href="{{ URL_LMS_CATEGORIES }}"> <i class="fa fa-random"></i>{{ getPhrase('categories') }}</a></li>
							<li><a href="{{ URL_LMS_CONTENT }}"> <i class="icon-books"></i>{{ getPhrase('contents') }}</a></li>
							<li><a href="{{ URL_LMS_SERIES }}"> <i class="fa fa-list-ol"></i>{{ getPhrase('series') }}</a></li>
					</ul>
					</li>



					<li {{ isActive($active_class, 'reports') }} > 

					<a data-toggle="collapse" data-target="#reports"><i class="icon-history" ></i> 
					{{ getPhrase('payment_reports') }} </a> 
					
					<ul id="reports" class="collapse sidemenu-dropdown">
						  	<li><a href="{{URL_ONLINE_PAYMENT_REPORTS}}"> <i class="fa fa-link"></i>{{ getPhrase('online_payments') }}</a></li>
							<li><a href="{{URL_OFFLINE_PAYMENT_REPORTS}}"> <i class="fa fa-chain-broken"></i>{{ getPhrase('offline_payments') }}</a></li>
							<li><a href="{{URL_PAYMENT_REPORT_EXPORT}}"> <i class="fa fa-file-excel-o"></i>{{ getPhrase('export') }}</a></li>
							

					</ul>

					</li>

					<li {{ isActive($active_class, 'notifications') }} > 
						<a href="{{URL_ADMIN_NOTIFICATIONS}}" ><i class="fa fa-bell-o" aria-hidden="true"></i>
					{{ getPhrase('notifications') }} </a> 
					
					</li>
					<li {{ isActive($active_class, 'sms') }} > 
						<a href="{{URL_SEND_SMS}}" ><i class="icon-events" ></i> 
					SMS </a> 
					
					</li>
										
					<li {{ isActive($active_class, 'messages') }} > 

					<a  href="{{URL_MESSAGES}}"><span><i class="fa fa-comments-o fa-2x" aria-hidden="true"><h5 class="badge badge-success">{{$count = Auth::user()->newThreadsCount()}}</h5></i></span>
					{{ getPhrase('messages')}} </a>
					
					</li>
					<li {{ isActive($active_class, 'feedback') }} > 
						<a href="{{URL_FEEDBACKS}}" ><i class="icon-inbox" ></i> 
					{{ getPhrase('feedback') }} </a> 
					
					</li>

					<li {{ isActive($active_class, 'master_settings') }} > 

					<a data-toggle="collapse" data-target="#master_settings"><i class="icon-settings" ></i> 
					{{ getPhrase('master_settings') }} </a> 
					
					<ul id="master_settings" class="collapse sidemenu-dropdown">
							

							<li><a href="{{URL_MASTERSETTINGS_EMAIL_TEMPLATES}}"> <i class="icon-history"></i> {{ getPhrase('email_templates') }}</a></li>
							@if(checkRole(getUserGrade(1)))
							<li><a href="{{URL_MASTERSETTINGS_SETTINGS}}"> <i class="icon-settings"></i> {{ getPhrase('settings') }}</a></li>
							@endif
							
					</ul>
					</li>
				</ul>
			</div>
		</aside>
		@if(isset($right_bar))
			
		<aside class="right-sidebar" id="rightSidebar">
			<button class="sidebat-toggle" id="sidebarToggle" href='javascript:'><i class="mdi mdi-menu"></i></button>
			<div class="panel panel-right-sidebar">
				<?php $data = '';
			if(isset($right_bar_data))
				$data = $right_bar_data;
			?>
				@include($right_bar_path, array('data' => $data))
			</div>
		</aside>
	 
	@endif

		@yield('content')
	</div>
	<!-- /#wrapper -->
	<!-- jQuery -->
	<script src="{{JS}}jquery-1.12.1.min.js"></script>

	<!-- Bootstrap Core JavaScript -->
	<script src="{{JS}}bootstrap.min.js"></script>

 
	<!--JS Control-->
	<script src="{{JS}}main.js"></script>
	<script src="{{JS}}sweetalert-dev.js"></script>



	 @yield('footer_scripts')

	@include('errors.formMessages')
	
	 
 	
 	@yield('custom_div_end')
	{!!getSetting('google_analytics', 'seo_settings')!!}
	<div class="ajax-loader" style="display:none;" id="ajax_loader"><img src="{{AJAXLOADER}}"> {{getPhrase('please_wait')}}...</div>
</body>

</html>