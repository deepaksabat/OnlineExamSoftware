@extends($layout)

@section('header_scripts')

<link href="{{CSS}}ajax-datatables.css" rel="stylesheet">

@stop

@section('content')





<div id="page-wrapper">

			<div class="container-fluid">

				<!-- Page Heading -->

				<div class="row">

					<div class="col-lg-12">

						<ol class="breadcrumb">

							<li><a href="{{PREFIX}}"><i class="mdi mdi-home"></i></a> </li>

							 

							<li>{{ $title}}</li>

						</ol>

					</div>

				</div>

								

				<!-- /.row -->

				<div class="panel panel-custom">

					<div class="panel-heading">

						 

						<h1>{{ $title.' '.getPhrase('of').' '.$user->name }}</h1>

					</div>

					<div class="panel-body packages">

						<div class="table-responsive"> 

						<table class="table table-striped table-bordered datatable" cellspacing="0" width="100%">

							<thead>

								<tr>

								 

									<th>{{ getPhrase('title')}}</th>

									<th>{{ getPhrase('type')}}</th>

									<th>{{ getPhrase('duration')}}</th>

									<th>{{ getPhrase('marks')}}</th>

									<th>{{ getPhrase('attempts')}}</th>

									 

									

								  

								</tr>

							</thead>

							 

						</table>

						</div>

						<div class="row">

							<div class="col-md-4 col-md-offset-4">

								<canvas id="myChart1" width="100" height="110"></canvas>

							</div>

						</div>

 

					</div>

				</div>

			</div>

			<!-- /.container-fluid -->

		</div>

@endsection

 



@section('footer_scripts')

  

 @include('common.datatables', array('route'=>URL_STUDENT_EXAM_ANALYSIS_BYEXAM.$user->slug, 'route_as_url' => 'TRUE'))

 

@include('common.chart', array($chart_data,'ids' => array('myChart1' )));





@stop

