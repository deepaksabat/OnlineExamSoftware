@extends('layouts.student.studentlayout')
@section('header_scripts')
<link href="//cdn.datatables.net/1.10.10/css/jquery.dataTables.min.css" rel="stylesheet">
@stop
@section('content')


<div id="page-wrapper">
			<div class="container-fluid">
				<!-- Page Heading -->
				<div class="row">
					<div class="col-lg-12">
						<ol class="breadcrumb">
							<li><a href="{{url('/')}}"><i class="mdi mdi-home"></i></a> </li>
							<li><a href="/exams/student/categories"> {{getPhrase('quiz_categories')}} </a> </li>
							<li>{{ $title }}</li>
						</ol>
					</div>
				</div>
								
				<!-- /.row -->
				<div class="panel panel-custom">
					<div class="panel-heading">
						
					 
						<h1>{{ $title.' '.getPhrase('quiz') }}</h1>
					</div>
					<div class="panel-body packages">
						<div class="table-responsive"> 
						<table class="table table-striped table-bordered datatable" cellspacing="0" width="100%">
							<thead>
								<tr>
									<th>{{ getPhrase('title')}}</th>
									<th>{{ getPhrase('dueration')}}</th>
									<th>{{ getPhrase('category')}}</th>
									<th>{{ getPhrase('type')}}</th>
									<th>{{ getPhrase('total_marks')}}</th>
									<th>{{ getPhrase('action')}}</th>
								  
								</tr>
							</thead>
							 
						</table>
						</div>

					</div>
				</div>
			</div>
			<!-- /.container-fluid -->
		</div>
@endsection
 

@section('footer_scripts')
  
 @include('common.datatables', array('route'=>'/exams/student/quiz/getList/'.$category->slug, 'route_as_url' => TRUE))
 @include('common.deletescript', array('route'=>'/exams/quiz/delete/'))

@stop
