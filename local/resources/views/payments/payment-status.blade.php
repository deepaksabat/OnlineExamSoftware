@extends($layout)
@section('content')
<?php $settings = getSettings('subscription'); ?>
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
        <!-- /.row -->
      <div class="panel panel-custom">
          <div class="panel-heading">
            <h1>{{$title}}</h1>
          </div>
          <div class="panel-body packages">
            <div class="row">
             
              <div class="col-md-12 text-center"> 
                <i class="fa fa-thumbs-up fa-5x" aria-hidden="true"></i><h1>{{ getPhrase('congrats_you_account_is_successfully_subscribed_with') .' '.$plan.' '.getPhrase('plan_with_transaction_no').' '.$id}} </h1>
              </div>
           
            </div>
       
                   
        </div>

      </div>
      
</div>
    <!-- /#page-wrapper -->

@stop