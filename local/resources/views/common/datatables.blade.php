	<script src="{{JS}}bootstrap-toggle.min.js"></script>
 	<script src="{{JS}}jquery.dataTables.min.js"></script>
	<script src="{{JS}}dataTables.bootstrap.min.js"></script>
	
	<?php 	$routeValue= $route; ?> 

	@if(!isset($route_as_url))
	{
		<?php $routeValue =  route($route); ?>
	}
	@endif
	
	<?php  
	$setData = array();
		if(isset($table_columns))
		{
			foreach($table_columns as $col) {
				$temp['data'] = $col;
				$temp['name'] = $col;
				array_push($setData, $temp);
			}
			$setData = json_encode($setData);
		}
	?>
 

  <script>

  var tableObj;
  
    $(document).ready(function(){
    	$.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        	}
		});
    	
   		 tableObj = $('.datatable').DataTable({
	            processing: true,
	            serverSide: true,
	            cache: true,
	            type: 'GET',
	            ajax: '{{ $routeValue }}',
	            @if(isset($table_columns))
	            columns: {!!$setData!!}
	            @endif
	    });
    });
  </script>