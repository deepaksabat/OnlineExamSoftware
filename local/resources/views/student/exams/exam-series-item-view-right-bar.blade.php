 				
		 	<div class="panel-heading countdount-heading">
					<h2>{{getPhrase('it_includes').' '.$item->total_exams.' '.getPhrase('exams')}}</h2>
				</div>
				<?php 
					$items_list = $item->itemsList();
				?>				
				<div class="panel-body">
					<ul class="offer-list">
					@foreach($items_list as $quizitem)
						<li>
						<i class="mdi mdi-star-circle"></i><h4>{{$quizitem->title}}</h4>
						<p>{{$quizitem->total_questions.' '.getPhrase('questions')}}  </p>
						
						</li>
					@endforeach
					</ul>
				</div>