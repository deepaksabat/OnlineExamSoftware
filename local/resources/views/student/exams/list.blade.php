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
							
							<li><a href="{{URL_STUDENT_EXAM_CATEGORIES}}"> {{getPhrase('exam_categories')}} </a> </li>

							<li>{{ $title }}</li>
						</ol>
					</div>
				</div>
								
				<!-- /.row -->
				<div class="panel panel-custom">
					<div class="panel-heading">
						
					 
						<h1>{{ $title }}</h1>
					</div>
					<div class="panel-body packages">
						<div> 
						  <?php   
						  		$user = Auth::user(); 
						  		 $interested_categories      = null;
						        if($user->settings)
						        {
						          $interested_categories =  json_decode($user->settings)->user_preferences;
						        }

						  ?>
						  @if($interested_categories->quiz_categories)
						<table class="table table-striped table-bordered datatable" cellspacing="0" width="100%">
							<thead>
								<tr>
									<th>{{ getPhrase('title')}}</th>
									<th>{{ getPhrase('duration')}}</th>
									<th>{{ getPhrase('category')}}</th>
									<th>{{ getPhrase('type')}}</th>
									<th>{{ getPhrase('total_questions')}}</th>
									<th>{{ getPhrase('action')}}</th>
								  
								</tr>
							</thead>
							 
						</table>
						@else
							Ooops...! {{getPhrase('no_exams_available')}}
						
						<a href="{{URL_USERS_SETTINGS.Auth::user()->slug}}" >{{getPhrase('click_here_to_change_your_preferences')}}</a>
						@endif
						</div>

					</div>
				</div>
			</div>
			<!-- /.container-fluid -->
		</div>
@endsection
 

@section('footer_scripts')
@if($interested_categories)
  @if($category)
	 @include('common.datatables', array('route'=>URL_STUDENT_QUIZ_GETLIST.$category->slug, 'route_as_url' => TRUE))
	 @else
	 @include('common.datatables', array('route'=>URL_STUDENT_QUIZ_GETLIST_ALL, 'route_as_url' => TRUE))
	 @endif
	 @include('common.deletescript', array('route'=>URL_QUIZ_DELETE))
 @endif
<script>
function showInstructions(url) {
	window.open(url,'_blank',"width=1200,height=800, toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=yes");
	runner();
}

function runner()
{
	url = localStorage.getItem('redirect_url');
    if(url) {
      localStorage.clear();
       window.location = url;
    }
    setTimeout(function() {
          runner();
    }, 500);

}
</script>
@stop
