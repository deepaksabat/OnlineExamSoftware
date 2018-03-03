@extends($layout)
@section('content')

<div id="page-wrapper">
            <div class="container-fluid">
                <!-- Page Heading -->
               <div class="row">
					<div class="col-lg-12">
						<ol class="breadcrumb">
							<li><a href="{{PREFIX}}"><i class="mdi mdi-home"></i></a> </li>
							<li> <a href="{{URL_STUDENT_LMS_SERIES}}">{{getPhrase('learning_management_series')}} </a> </li>
							<li class="active"> {{ $title }} </li>
						</ol>
					</div>
				</div>
                <div class="panel panel-custom">
                
                    <div class="panel-body">
 
                        @if(!$content_record)

                        <div class="row">
                        <?php 
                             $image = IMAGE_PATH_UPLOAD_LMS_DEFAULT;
                             if($item->image)
                             $image = IMAGE_PATH_UPLOAD_LMS_SERIES.$item->image;
                         ?>

                            <div class="col-md-3"> <img src="{{$image}}" class="img-responsive center-block" alt=""> </div>
                            <div class="col-md-8 col-md-offset-1">
                                <div class="series-details">
                                    <h2>{{$item->title}} </h2>

                                    	{!! $item->description!!}
                                    @if($item->is_paid && !isItemPurchased($item->id, 'lms'))
                                    <div class="buttons text-left">
                                        <a href="{{URL_PAYMENTS_CHECKOUT.'lms/'.$item->slug}}" class="btn btn-dark text-uppercase">{{ getPhrase('buy_now')}}</a>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        @elseif($content_record->content_type == 'video' || $content_record->content_type == 'iframe' || $content_record->content_type == 'video_url')

                            @include('student.lms.series-video-player', array('series'=>$item, 'content' => $content_record))

                        @elseif($content_record->content_type == 'audio' || $content_record->content_type == 'audio_url')
 
                            @include('student.lms.series-audio-player', array('series'=>$item, 'content' => $content_record))
                        @endif
                        <hr>

                       @include('student.lms.series-items', array('series'=>$item, 'content'=>$content_record))

                    </div>
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
        </div>
        
		<!-- /#page-wrapper -->

@stop
@section('footer_scripts')

@if($content_record)
    @if($content_record->content_type == 'video' || $content_record->content_type == 'video_url')
        @include('common.video-scripts')
    @endif

@endif
@include('common.custom-message-alert')
@stop