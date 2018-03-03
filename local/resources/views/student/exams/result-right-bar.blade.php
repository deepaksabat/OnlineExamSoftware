 
				<div class="panel-heading">
					<h2>Recent Activity</h2></div>
				<div class="panel-body">

					<ul class="recent-activity-log">
					<?php $grade_system = getSettings('general')->gradeSystem; ?>
						@foreach($data['history'] as $r)
						<?php 
							$class = 'class=""';
							if($r->exam_status == 'pass')
								$class = 'class=positive';
							elseif($r->exam_status == 'fail')
								$class = 'class=post-alert';
							$quiz = $r->quizName;
						 ?>
						<li {{ $class }}>
						<p>{{$quiz->title}}</p>
						<p>{{getPhrase('question'). ' : '.$quiz->total_questions}}</p>
						<p>{{getPhrase('marks_obtained'). ' : '.$r->marks_obtained}} / {{$r->total_marks}} ({{$r->percentage}} %) </p>
							<p>{{ $r->$grade_system }}</p>
							<p class="posted-time">{{ $r->updated_at }}</p>
						</li>
						@endforeach
						 
					</ul>

				</div>