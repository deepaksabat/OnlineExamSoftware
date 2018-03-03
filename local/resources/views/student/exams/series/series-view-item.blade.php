@extends($layout)

@section('content')



<div id="page-wrapper">

            <div class="container-fluid">

                <!-- Page Heading -->

               <div class="row">

					<div class="col-lg-12">

                        <ol class="breadcrumb">

                            <li><a href="{{PREFIX}}"><i class="mdi mdi-home"></i></a> </li>

                            <li> <a href="{{URL_STUDENT_EXAM_SERIES_LIST}}">{{getPhrase('exam_series')}} </a> </li>

                            <li class="active"> {{ $title }} </li>

                        </ol>

                    </div>

				</div>

                <div class="panel panel-custom">
 

                    <div class="panel-body">

                        @if(!$content_record)

                        <div class="row">
                        
                        <?php $image_path = IMAGE_PATH_UPLOAD_EXAMSERIES_DEFAULT;
                    $image_path_thumb = IMAGE_PATH_UPLOAD_EXAMSERIES_DEFAULT;
                    if($item->image)
                    {
                        $image_path = IMAGE_PATH_UPLOAD_SERIES.$item->image;
                        $image_path_thumb = IMAGE_PATH_UPLOAD_SERIES_THUMB.$item->image;
                    }
                    ?>

                            <div class="col-md-3"> <img src="{{$image_path}}" class="img-responsive center-block" alt=""> </div>

                            <div class="col-md-8 col-md-offset-1">

                                <div class="series-details">

                                    <h2>{{$item->title}} </h2>



                                    	{!! $item->description!!}
                                    
                                    @if($item->is_paid && !isItemPurchased($item->id, 'combo'))

                                    <div class="buttons text-left">

                                        <a href="{{URL_PAYMENTS_CHECKOUT.'combo/'.$item->slug}}" class="btn btn-dark text-uppercase">{{ getPhrase('buy_now')}}</a>

                                    </div>

                                    @endif

                                </div>

                            </div>

                        </div>

                        

                        @endif

                        <hr>

                      

                       @include('student.exams.series.series-items', array('series'=>$item, 'content'=>$content_record))



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
<script>
function showInstructions(url) {
    window.open(url,'_blank',"width=800,height=600,toolbar=0,location=0,scrollbars=yes");
    runner();
}

function runner()
{
    url = localStorage.getItem('redirect_url');
    if(url) {
      localStorage.clear();
       window.location = url;
    }
    setTimeout(function() {
          runner();
    }, 500);

}
</script>
 
@stop