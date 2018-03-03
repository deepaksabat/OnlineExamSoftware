<div class="row">
					<div class="col-md-3">
							<div class="book-box">
								<div class="col-md-6">
								<?php $librarySettings = getLibrarySettings(); ?>
									<img src="/{{ $librarySettings->libraryImageThumbnailpath.$master_record->image }}" alt="">
									</div>
									<div class="col-md-6">
									<h3>{{ $master_record->title }}</h3>
									<p><a href="" data-toggle="modal" data-target="#author_profile">
									{{ $master_record->author->author }} </a></p>
									<div class="availability">
										<span>{{getPhrase('total')}}: {{ $master_record->total_assets_count }}</span>
									</div>
									
									</div>

								</div>
					</div>

					<div class="col-md-3">
						<div class="card card-green text-xs-center">
							<div class="card-block">
								<h4 class="card-title">{{ $master_record->total_assets_available }}</h4>
								<p class="card-text">{{ getPhrase('available') }}</p>
							</div>
							<a class="card-footer text-muted">
								{{ getPhrase('view_all') }}
							</a>
						</div>
					</div>

					<div class="col-md-3">
						<div class="card card-yellow text-xs-center">
								<div class="card-block">
								<h4 class="card-title">{{ $master_record->total_assets_damaged }}</h4>
								<p class="card-text">{{ getPhrase('damaged') }}</p>
							</div>
							<a class="card-footer text-muted">
								{{ getPhrase('view_all') }}
							</a>
						</div>
					</div>

					<div class="col-md-3">
						<div class="card card-red text-xs-center">
								<div class="card-block">
								<h4 class="card-title">{{ $master_record->total_assets_lost }}</h4>
								<p class="card-text">{{ getPhrase('lost') }}</p>
							</div>
							<a class="card-footer text-muted">
								{{ getPhrase('view_all') }}
							</a>
						</div>
					</div>


				</div>