<div class="panel-heading">
		<h2>Progress Report</h2></div>
	{{-- <div class="panel-body">
	
		<div id="reportChart" style="min-width: 310px; height: 400px; max-width: 600px; margin: 0 auto"></div>
	</div> --}}
	
	<?php $ids=[];?>
	@for($i=0; $i<count($right_bar_data); $i++)
	<?php 
	$newid = 'myRightChart'.$i;
	$ids[] = $newid; ?>
	
	<div class="panel-body">
		<canvas id="{{$newid}}" width="100" height="110"></canvas>
	</div>

	@endfor
	 
