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

								 

									<th>{{ getPhrase('marks')}}</th>

								 	 

									<th>{{ getPhrase('result')}}</th>

									 

									<th>{{ getPhrase('action')}}</th>

								  

								</tr>

							</thead>

							 

						</table>

						</div>

						<div class="row">

							<div class="col-md-6 col-md-offset-3">

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

 @if(!$exam_record)

 @include('common.datatables', array('route'=>URL_STUDENT_EXAM_GETATTEMPTS.$user->slug, 'route_as_url' => 'TRUE'))

 @else

 @include('common.datatables', array('route'=>URL_STUDENT_EXAM_GETATTEMPTS.$user->slug.'/'.$exam_record->slug, 'route_as_url' => 'TRUE'))

 @endif

 @include('common.chart', array($chart_data,'ids' => array('myChart1')));

@stop

