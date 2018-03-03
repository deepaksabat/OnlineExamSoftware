 
				<div class="panel-heading">
					<h2>{{ getPhrase('recent_activity')}}</h2></div>
				<div class="panel-body">

					<ul class="recent-activity-log">
						@foreach($data['recent_activity'] as $r)
						<?php 
							$class = 'class=""';
							$quiz_id = $r->subject_id;
							$marks_obtained = '';
							$percentage = '';
							$exam_result = '';

							if($r->log_name == 'exam_attempt') {
								$class = 'class=positive';
								$rec = json_decode($r->properties)->attributes;
								$quiz_id = $rec->quiz_id;
								$marks_obtained = $rec->marks_obtained.' / '.$rec->total_marks;
								$percentage = sprintf('%.2f', $rec->percentage).' %';
							}
							elseif($r->log_name == 'exam_aborted'){
								$class = 'class=post-alert';
							}
							$quiz = App\Quiz::find($quiz_id)->title;
						 ?>
						<li {{ $class }}>
						<p>{{ getPhrase($r->log_name) }}</p>
						<p>{{ $quiz }}</p>
						@if($r->log_name == 'exam_attempt')
						<p>{{getPhrase('marks_obtained'). ' : '. $marks_obtained }}</p>
						<p>{{ $percentage }}</p>
						@endif
							<p class="posted-time">{{ $r->updated_at }}</p>
						</li>
						@endforeach
						 
					</ul>

				</div>