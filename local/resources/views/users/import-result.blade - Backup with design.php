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
							<li><a href="{{PREFIX}}"><i class="mdi mdi-home"></i></a> </li>
							<li><a href="{{URL_USERS}}">{{getPhrase('users')}}</a> </li>
							<li><a href="{{URL_USERS_IMPORT}}">{{getPhrase('import_users')}}</a> </li>
							
							<li>{{ $title }}</li>
						</ol>
					</div>
				</div>
								
				<!-- /.row -->
				<div class="panel panel-custom">
					<div class="panel-heading">
						
						<div class="pull-right messages-buttons">
							 
							<a href="{{URL_USERS_IMPORT}}" class="btn  btn-primary button" >{{ getPhrase('import_excel')}}</a>
							<a href="{{URL_USERS_ADD}}" class="btn  btn-primary button" >{{ getPhrase('add_user')}}</a>
							<a href="{{URL_USERS}}" class="btn  btn-primary button" >{{ getPhrase('list')}}</a>
							 
						</div>
						<h1>{{ $title }}</h1>
					</div>
					<div class="panel-body packages">





<ul class="nav nav-tabs add-studentlist-tabs">
  <li class="active"><a data-toggle="tab" href="#home">Home <span class="badge badge-success">10</span></a>
  </li>
  <li><a data-toggle="tab" href="#menu1">Menu 1 <span class="badge badge-error">100</span></a></li>
</ul>

<div class="tab-content">
  <div id="home" class="tab-pane fade in active">
    
    <div class="item item-avtar-left">
    	<img src="{{IMAGE_PATH_UPLOAD_SERIES}}1-image.jpeg">
    	<div class="item-content">
    		<h3>Prameshwar Saha</h3>
    		<p><strong>Subject:</strong> Examination Name</p>
    		<p><strong>Marks:</strong> 100%</p>

    	</div>
    </div>
<div class="row">
	<div class="col-md-3"><div class="subject-topper-profile">
    	<img src="{{IMAGE_PATH_UPLOAD_SERIES}}1-image.jpeg">
    	<h3>Prameshwar Saha</h3>
    		
    		<p><strong>Indian Army</strong></p>
    		<p><strong>Marks:</strong> 100%</p>
    </div></div>
	<div class="col-md-3"><div class="subject-topper-profile">
    	<img src="{{IMAGE_PATH_UPLOAD_SERIES}}1-image.jpeg">
    	<h3>Prameshwar Saha</h3>
    		
    		<p><strong>Marks:</strong> 100%</p>
    </div></div>
	<div class="col-md-3"><div class="subject-topper-profile">
    	<img src="{{IMAGE_PATH_UPLOAD_SERIES}}1-image.jpeg">
    	<h3>Prameshwar Saha</h3>
    		
    		<p><strong>Marks:</strong> 100%</p>
    </div></div>
	<div class="col-md-3"><div class="subject-topper-profile">
    	<img src="{{IMAGE_PATH_UPLOAD_SERIES}}1-image.jpeg">
    	<h3>Prameshwar Saha</h3>
    		
    		<p><strong>Marks:</strong> 100%</p>
    </div></div>
</div>
    




  </div>
  <div id="menu1" class="tab-pane fade">
    <h3>Menu 1</h3>
    <p>Some content in menu 1.</p>
  </div>
  
</div>
						<div class="table-responsive"> 
						 
						</div>
						 

					</div>

				</div>
			</div>
			<!-- /.container-fluid -->
		</div>
@endsection
 
@section('footer_scripts')
  
 {{-- @include('common.datatables', array('route'=>'users.dataTable')) --}}
 {{-- @include('common.deletescript', array('route'=>'/mastersettings/')) --}}

@stop
