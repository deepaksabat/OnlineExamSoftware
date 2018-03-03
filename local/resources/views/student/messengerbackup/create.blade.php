@extends('layouts.student.studentlayout')
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
<!-- <h1>Create a new message</h1> -->
<div class="panel panel-custom">
                    <div class="panel-heading">
                        <h1>{{$title}}</h1>
                    </div>
                    <div class="panel-body packages">
                         
                        <div class="row library-items">

{!! Form::open(['route' => 'messages.store']) !!}
<div class="col-md-6">
    <!-- Subject Form Input -->
    <div class="form-group">
        {!! Form::label('subject', 'Subject', ['class' => 'control-label']) !!}
        {!! Form::text('subject', null, ['class' => 'form-control']) !!}
    </div>

    <!-- Message Form Input -->
    <div class="form-group">
        {!! Form::label('message', 'Message', ['class' => 'control-label']) !!}
        {!! Form::textarea('message', null, ['class' => 'form-control']) !!}
    </div>

   {{--  @if($users->count() > 0)
    <div class="checkbox">

        @foreach($users as $user)
           <!--  <label title="{!!$user->name!!}"> -->
            <input type="checkbox" id="{!!$user->name!!}" class="form-controll" name="recipients[]" value="{!!$user->id!!}">
               <label for="{!!$user->name!!}">
                    <span class="fa-stack checkbox-button">
                        <i class="mdi mdi-check active">
                        </i>
                    </span>
                   {!!$user->name!!}
                </label>
            </input>

          <!--   </label> -->
        @endforeach
    </div>
    @endif --}}
    
    <!-- Submit Form Input -->
    <div class="form-group">
        {!! Form::submit('Submit', ['class' => 'btn btn-primary form-control']) !!}
    </div>
</div>
{!! Form::close() !!}
  </div>
                </div>
            </div>
            
</div>
</div>
@stop
