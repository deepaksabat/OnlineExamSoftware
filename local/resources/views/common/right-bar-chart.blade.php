<div class="panel-heading">
		<h2>{{$chart_heading}}</h2></div>
	{{-- <div class="panel-body">
	
		<div id="reportChart" style="min-width: 310px; height: 400px; max-width: 600px; margin: 0 auto"></div>
	</div> --}}
	
	<?php $ids=[];?>
	@for($i=0; $i<count($chart_data); $i++)
	<?php 
	$newid = 'myChart'.$i;
	$ids[] = $newid; ?>
	
	<div class="panel-body">
		<div class="row">
			<div class="col-md-12">
				<canvas id="{{$newid}}" width="100" height="110"></canvas>
			</div>
		</div>
	</div>

	@endfor
	 
