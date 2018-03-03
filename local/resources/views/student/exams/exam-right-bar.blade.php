<?php 
	$questions 	= $data['questions'];
	$quiz 		= $data['quiz'];
 ?>
<div class="panel-heading">
					<h2>Time Status</h2>
				</div>
				<div class="panel-body">
				 
					<div id="timerdiv" class="countdown-styled ">
						<span id="hours">{{$data['time_hours']}}</span> : 
						<span id="mins">{{ $data['time_minutes']}}</span> : 
						<span id="seconds">00</span>

					</div>
					 
				</div>
				<div class="panel-heading countdount-heading">
					<h2>{{getPhrase('total_time')}} <span class="pull-right">{{$data['time_hours']}}:{{ $data['time_minutes']}}:00</span></h2>
				</div>


				 	<div class="panel-body">
					<div class="sub-heading">
						<h3>{{$quiz->title}}</h3>
						<p>{{ ucfirst($quiz->category->category) .' '. getPhrase('category')}}</p>
					</div>
					<ul class="question-palette" id="pallete_list">
						@for($i=0; $i<count($questions); $i++)
						<li  class="palette pallete-elements not-visited" onclick="showSpecificQuestion({{$i}});">
						<span>{{$i+1}}</span>
						</li>
						@endfor
					</ul>
				</div>
				<hr>
				<div class="panel-heading">
					<h2>{{ getPhrase('summary')}}</h2>
				</div>
				<div class="panel-body">
					<ul class="legends">
						<li  class="palette answered"><span id="palette_total_answered">1</span> {{getPhrase('answered')}}</li>
						<li  class="palette marked"><span id="palette_total_marked">2</span> {{getPhrase('marked')}}</li>
						<li  class="palette not-answered"><span id="palette_total_not_answered">3</span> {{getPhrase('not_answered')}}</li>
						<li  class="palette not-visited"><span id="palette_total_not_visited">4</span> {{getPhrase('not_visited')}}</li>
					</ul>
				</div>
