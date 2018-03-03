@extends('layouts.admin.adminlayout')
@section('content')

<div id="page-wrapper">
			<div class="container-fluid">
				<!-- Page Heading -->
				<div class="row">
					<div class="col-lg-12">
						<ol class="breadcrumb">
							<li><a href="index.html"><i class="mdi mdi-home"></i></a> </li>
						</ol>
					</div>
				</div>
				<!-- /.row -->

				@foreach($users as $user)
				<li>{{$user->name}}</li>
				@endforeach
			</div>
			<!-- /.container-fluid -->
</div>
		<!-- /#page-wrapper -->

@stop