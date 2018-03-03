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
                            <li><a href="{{URL_NOTIFICATIONS}}">{{getPhrase('notifications')}}</a></li>
                            <li>{{$notification->title}}</li>
                        </ol>
                    </div>
                </div>
                
		<div class="panel panel-custom col-lg-6 col-lg-offset-3" >
                    {{-- <div class="panel-heading text-center">
                        <h1>{{$notification->title}}</h1> </div> --}}
                    <div class="panel-body">
                        <div class="notification-details">
                            <div class="notification-title text-center">
                                <h2>{{$notification->title}}</h2></div>
                            <div class="notification-content text-center">
                                {!!$notification->description!!}
                            </div>
                            @if($notification->url)
                            <div class="notification-footer text-center">
                                <a type="button" href="{{$notification->url}}" target="_blank" class="btn btn-lg btn-dark button">{{getPhrase('read_more')}}</a>
                            </div>
                            @endif

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