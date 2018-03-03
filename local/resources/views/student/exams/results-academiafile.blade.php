@extends('layouts.student.studentlayout')
@section('header_scripts')
@stop
@section('content')
<div id="page-wrapper">
			<div class="container-fluid">
				<!-- Page Heading -->
				<div class="row">
					<div class="col-lg-12">
						<ol class="breadcrumb">
							<li><a href="/"><i class="mdi mdi-home"></i></a> </li>
							<li> <a href="/exams/student/categories"> {{ getPhrase('exams') }} </a></li>
							<li class="active"> {{$title}} </li>
						</ol>
					</div>
				</div>
				<!-- /.row -->
				<div class="panel panel-custom">
					<div class="panel-heading">
						<h1>{{getPhrase('result_for'). ' '.$title}}</h1></div>
					<div class="panel-body">
							<div class="profile-details text-center">
							<div class="profile-img"><img src="{{ getProfilePath($user->image,'profile')}}" alt=""></div>
							<div class="aouther-school">
								<h2>{{ $student->first_name.' '.$student->middle_name.' '.$student->last_name}}</h2>
								<p><span>{{$student->roll_no}}</span></p>

							</div>

						</div>
						<hr>

						<div class="panel-body">
						<ul class="library-statistic">
							<li class="total-books">
								{{getPhrase('score') }} <span>{{$record->marks_obtained}} / {{$record->total_marks}}</span>
							</li>
							<li class="total-journals">
								{{getPhrase('percentage')}} <span><?php echo sprintf('%0.2f', $record->percentage); ?></span>
							</li>
							<li class="digital-items">
							<?php $grade_system = getSettings('general')->gradeSystem; ?>
								{{ getPhrase('grade')}} <span>{{ ($record->$grade_system != '') ? $record->$grade_system : ucfirst($record->exam_status) }}</span>
							</li>
						</ul>
						 <wins-graph :player="{{ $total }}" :opponent="{{ $obtained }}">
						 </wins-graph>
						@if(count($toppers)>0)
						 <div class="room-mates">
						<h3>{{getPhrase('toppers_in_this_exam')}}</h3>
						<hr>
						<div class="row">
							@foreach( $toppers as $r)
							<?php $user = $r->getUser;?>
							<div class="col-md-2">
								<div class="box-roommates">
									<img src="{{getProfilePath($user->image,'profile')}}" alt="">
									<div>
										<h5>{{ $user->name }}</h5>
										<p>{{$r->percentage}}%</p>
									</div>
								</div>
							</div>
							 @endforeach
							 
						</div>
					</div>
					@endif

					</div>


					</div>

				</div>
			</div>
			<!-- /.container-fluid -->
		</div>
		<!-- /#page-wrapper -->
	</div>
	<!-- /#wrapper -->
	 
@stop

@section('footer_scripts')
	
   <script src="/js/chart-vue.js"></script>

@stop