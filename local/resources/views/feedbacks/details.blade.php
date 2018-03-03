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
                            <li><a href="{{URL_FEEDBACKS}}">{{getPhrase('feedbacks')}}</a></li>
                            <li>{{$record->title}}</li>
                        </ol>
                    </div>
                </div>
                
         		 <div class="panel panel-custom col-lg-6 col-lg-offset-3">
                    {{-- <div class="panel-heading">
                        <h1>{{$notification->title}}</h1> </div> --}}
                    <div class="panel-body">
                        <div class="notification-details">
                            <div class="notification-title text-center">
                                <h2>{{$record->title}}</h2></div>

                                <div class="notification-title text-center">
                                <h4>{{$record->subject}}</h4></div>
                            <div class="notification-content text-center">
                                {!!$record->description!!}
                            </div>
                            <div class="notification-footer text-center">
                                <a type="button" href="{{URL_FEEDBACKS}}" class="btn btn-lg btn-dark button">{{getPhrase('back')}}</a>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
        </div>
        
@endsection
 
@section('footer_scripts')
 
@stop