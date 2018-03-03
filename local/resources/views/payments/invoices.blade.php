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
             
              <div class="col-md-12"> 
              <?php $sno = 1;?>
               <table class="table table-bordered tabel-dues-details fee-details">
               <tr>
                  <th>{{getPhrase('sno')}} </th>
                  <th>{{ getPhrase('date')}}</th>
                  <th>{{getPhrase('total')}}</th>
                  <th>{{getPhrase('action')}}</th>
                  
                </tr>
                  @foreach ($invoices as $invoice)
                      <tr>
                      <td>{{ $sno++ }}</td>
                          <td>{{ $invoice->date()->toFormattedDateString() }}</td>
                          <td>{{ $invoice->total() }}</td>
                          <td><a href="/user/invoice/{{ $invoice->id }}">{{ getPhrase('download')}}</a></td>
                      </tr>
                  @endforeach
              </table>
              </div>
            </div>
       
                   
        </div>

      </div>
      
</div>
    <!-- /#page-wrapper -->

@stop