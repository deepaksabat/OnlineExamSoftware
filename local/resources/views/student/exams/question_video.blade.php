
<?php $answers = json_decode($question->answers); 
 
$video_path= EXAM_UPLOADS.$question->question_file;
 if($question->question_file_is_url)
$video_path= $question->question_file;
    

?>
 @if($question->question_type=='video')
    <div class="row">
          <video id="my-video" class="video-js vjs-big-play-centered" controls preload="auto" width="300" height="264"
          poster="" data-setup='{"aspectRatio":"640:267", "playbackRates": [1, 1.5, 2] }'>
            <source src="{{$video_path}}" type='video/mp4'>
            
            <p class="vjs-no-js">
              To view this video please enable JavaScript, and consider upgrading to a web browser that
              <a href="http://videojs.com/html5-video-support/" target="_blank">supports HTML5 video</a>
            </p>
        </video>
    </div>
@endif

<div class="row">
    <div class="col-md-12">
        <ul class="questions-container">
            <?php $i=0; ?>
            @foreach($answers as $answer)
            <?php $options = (array) $answer->
            options; ?>
            <li>
                <div class="question">
                    <h3>
                        {{ $answer->question }}
                    </h3>
                </div>
                <div class="select-answer">
                    <ul class="row">
                        @foreach($options as $suboptions)
                        <?php $index = 1; ?>
                        @foreach($suboptions as $option)
                        
                        <li class="col-md-6">
                            <input id="{{$question->id.'_'.$i.'_'.$index}}" value="{{$index}}" name="{{$question->id}}[{{$i}}]" type="radio"/>
                            <label for="{{$question->id.'_'.$i.'_'.$index}}">
                                <span class="fa-stack radio-button">
                                    <i class="mdi mdi-check active">
                                    </i>
                                </span>
                                {{$option}}
                            </label>
                        </li>
                         <?php $index++; ?> 
                        @endforeach 
                        
                    @endforeach
                    <?php $i++; ?>
                    </ul>
                </div>
            </li>
            <hr>

                @endforeach
            </hr>
        </ul>
    </div>
</div>
