@extends($layout)
@section('content')
<?php $settings = getSettings('subscription'); ?>
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
        <!-- /.row -->
      <div class="panel panel-custom">
          <div class="panel-heading">
            <h1>{{$title}}</h1>
          </div>
          <div class="panel-body packages">
            <div class="row">
              @foreach($plans as $p)
              <div class="col-md-4">
                <div class="packages-box">
                  <h2 class="price"><sub>Rs.</sub>{{$p->amount}}</h2>
                  <p>{{ $p->name}}</p>
                  <hr>
                  <p><strong>{{ $p->title }}</strong></p>
                  <p>{{getPhrase('it_is_a').' '.ucfirst($p->type).' '.getPhrase('type')}}</p>
                  <p>{{ $p->description}}</p>
                  <?php 
                  $url = '/subscription/subscribe/'.$p->slug;
                  if($user)
                    $url = '/subscription/subscribe/'.$p->slug.'/'.$user->slug;
                  ?>
                  {!! Form::open(array('url' => $url, 'method' => 'POST')) !!}
                  <script
                    src="https://checkout.stripe.com/checkout.js" class="stripe-button"
                    
                    data-key= "{{ ($settings->live_mode) ? $settings->live_public_key : $settings->test_public_key }}"
                    
                    data-amount="{{ $p->amount }}"
                    data-name="{{strtolower($p->name)}}"
                    data-description="{{$p->description}}"
                    data-image="/img/documentation/checkout/marketplace.png"
                    data-locale="auto">
                  </script>
               {!! Form::close() !!}

                  </div>
              </div>
            @endforeach
               
             
            </div>
       
                   
        </div>

      </div>
      
</div>
    <!-- /#page-wrapper -->

@stop