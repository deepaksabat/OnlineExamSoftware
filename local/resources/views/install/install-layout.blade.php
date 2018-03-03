<!DOCTYPE html>
<html lang="en" >

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="">
	<meta name="keywords" content="">
	 
	<link rel="icon" href="#" type="image/x-icon" />
	
	<title>{{ isset($title) ? $title : 'Exam system' }}</title>

	@yield('header_scripts')
	<!-- Bootstrap Core CSS -->
	<link href="{{CSS}}bootstrap.min.css" rel="stylesheet">

	<!-- Custom CSS -->
	<link href="{{CSS}}sb-admin.css" rel="stylesheet">
	<!-- Morris Charts CSS -->
	<link href="{{CSS}}plugins/morris.css" rel="stylesheet">
	<!-- Proxima Nova Fonts CSS -->
	<link href="{{CSS}}proximanova.css" rel="stylesheet">
	<!-- Custom Fonts -->
	<link href="{{CSS}}custom-fonts.css" rel="stylesheet" type="text/css">
	<link href="{{CSS}}materialdesignicons.css" rel="stylesheet" type="text/css">
	<link href="{{FONTAWSOME}}font-awesome.min.css" rel="stylesheet" type="text/css">
	<link href="{{CSS}}sweetalert.css" rel="stylesheet" type="text/css">
	<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body class="login-screen" ng-app="academia" >


	@yield('content')
	

		<!-- /#wrapper -->
		<!-- jQuery -->
		<script src="{{JS}}jquery-1.12.1.min.js"></script>

		<!-- Bootstrap Core JavaScript -->
		<script src="{{JS}}bootstrap.min.js"></script>

		<!-- Morris Charts JavaScript -->
		{{-- <script src="{{JS}}plugins/morris/raphael.min.js"></script> --}}
		{{-- <script src="{{JS}}plugins/morris/morris.min.js"></script>
		<script src="{{JS}}plugins/morris/morris-data.js"></script> --}}
		<!--JS Control-->
		<script src="{{JS}}main.js"></script>
		<script src="{{JS}}sweetalert-dev.js"></script>
		@include('errors.formMessages')
		@yield('footer_scripts')
</body>

</html>