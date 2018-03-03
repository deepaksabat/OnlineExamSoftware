<?php $toppersList =$right_bar_data; 
$list = $toppersList['right_bar_data'];
$user_result_slug = $toppersList['user_result_slug'];
?>

<div class="panel-heading countdount-heading">
					<h2>{{getPhrase('toppers_in_this_exam')}}</h2>
				</div>
				<div class="panel-body">
					<ul class="list-replay list-sidebar">
					@foreach($list as $topper)
					<?php $user = App\User::where('id',$topper->user_id)->first();?>
						<li>
							<a href="{{URL_COMPARE_WITH_TOPER.$user_result_slug.'/'.$topper->slug}}">
								<img src="{{IMAGE_PATH_PROFILE_THUMBNAIL.$user->image}}" alt="">
								<h4>{{$user->name}}</h4>
								<p>{{getPhrase('percentage')}}: {{$topper->percentage}}</p>
								
							</a>
						</li>
					@endforeach
					</ul>
				</div>