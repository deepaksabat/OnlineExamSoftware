@extends($layout)
@section('content')
<div id="page-wrapper">
            <div class="container-fluid">
                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <ol class="breadcrumb">
                            <li><a href="/"><i class="mdi mdi-home"></i></a> </li>
                            <li class="active"> {{ $title }} </li>
                        </ol>
                    </div>
                </div>

    @if (Session::has('error_message'))
        <div class="alert alert-danger" role="alert">
            {!! Session::get('error_message') !!}
        </div>
    @endif
        <div class="panel panel-custom">
                    <div class="panel-heading">
                        <h1>{{$title}}</h1>
                    </div>
                    <div class="panel-body packages">
                         
                        <div class="row library-items">
                        
    @if(count($threads)>0)
        @foreach($threads as $thread)
        <?php $class = $thread->isUnread($currentUserId) ? 'alert-info' : ''; ?>
        <div class="media alert {!!$class!!}">
            <h4 class="media-heading">{!! link_to('messages/' . $thread->id, $thread->subject) !!}</h4>
            <p>{!! $thread->latestMessage->body !!}</p>
            <p><small><strong>Creator:</strong> {!! $thread->creator()->name !!}</small></p>
            {{-- <p><small><strong>Participants:</strong> {!! $thread->participantsString(Auth::id()) !!}</small></p> --}}
        </div>
        @endforeach
    @else
        <p>Sorry, no threads.</p>
    @endif
    </div>
                </div>
            </div>
            
</div>
</div>
@stop
