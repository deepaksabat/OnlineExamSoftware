@extends('layouts.student.studentlayout')
@section('content')
<div id="page-wrapper">
            <div class="container-fluid">
                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <ol class="breadcrumb">
                            <li><a href="{{PREFIX}}"><i class="mdi mdi-home"></i></a> </li>
                            <li class="active"> {{ $title }} </li>
                        </ol>
                    </div>
                </div>
<!-- <h1>Create a new message</h1> -->
<div class="panel panel-custom">
                    <div class="panel-heading">
                        <h1>{{$title}}</h1>
                    </div>
                    <div class="panel-body packages">
                         
                        <div class="row library-items">

    <div class="col-md-6">
        <h1>{!! $thread->subject !!}</h1>

        @foreach($thread->messages as $message)
            <div class="media">
                <a class="pull-left" href="#">
                    <img src="{{getProfilePath($message->user->image)}}" alt="{!! $message->user->name !!}" class="img-circle">
                </a>
                <div class="media-body">
                    <h5 class="media-heading">{!! $message->user->name !!}</h5>
                    <p>{!! $message->body !!}</p>
                    <div class="text-muted"><small>Posted {!! $message->created_at->diffForHumans() !!}</small></div>
                </div>
            </div>
        @endforeach

        <h2>Add a new message</h2>
        {!! Form::open(['route' => ['messages.update', $thread->id], 'method' => 'PUT']) !!}
        <!-- Message Form Input -->
        <div class="form-group">
            {!! Form::textarea('message', null, ['class' => 'form-control']) !!}
        </div>

        @if($users->count() > 0)
        <div class="checkbox">
            @foreach($users as $user)
               
                <input type="checkbox" id="{{$user->name}}" name="recipients[]" value="{!! $user->id !!}">{!! $user->name !!}
                <label for="{{$user->name}}">
                    <span class="fa-stack checkbox-button">
                        <i class="mdi mdi-check active">
                        </i>
                    </span>
                   {{$user->name}}
                </label>
            </input>


               
            @endforeach
        </div>
        @endif

        <!-- Submit Form Input -->
        <div class="form-group">
            {!! Form::submit('Submit', ['class' => 'btn btn-primary form-control']) !!}
        </div>
        {!! Form::close() !!}
    </div>
    </div>
                </div>
            </div>
            
</div>
</div>
@stop
