
				<div class="panel-heading countdount-heading">
					<h2>{{getPhrase('billing_details')}}</h2>
				</div>
			<?php $user = Auth::user();?>
				<div class="panel-body">
						<div class="row">
							<div class="col-xs-4">{{getPhrase('name')}}</div>
							<div class="col-xs-8"><strong>{{$user->name}}</strong></div>
						</div>
						<hr>

						<div class="row">
							<div class="col-xs-4">{{getPhrase('email')}}</div>
							<div class="col-xs-8"><a href="mailto:{{$user->email}}"><strong>{{$user->email}}</strong></a></div>
						</div>
						<hr>
						<div class="row">
							<div class="col-xs-4">{{getPhrase('phone')}}</div>
							<div class="col-xs-8"><strong>{{$user->phone}}</strong></div>
						</div>


				</div>
			@if($user->address)
				<div class="panel-heading countdount-heading">
					<h2>{{getPhrase('billing_address')}}</h2>
				</div>
				

				<div class="panel-body">
					 

					<div class="row">
							 
							<div class="col-xs-12"><strong>{{$user->address}}</strong></div>
						</div>
				</div>
				@endif