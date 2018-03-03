<?php
$src = "";
	if($record->question_type!='video' && $record->question_type!='audio') { ?>
        <img src="{{EXAM_UPLOADS.$record->question_file}}" height="90" width="90"/> 
    <?php } elseif($record->question_type == 'video') { 
        	$src= EXAM_UPLOADS.$record->question_file;
        	
        	if($record->question_file_is_url)
        		$src= $record->question_file; ?>
	        
            <video id="my-video" class="video-js vjs-big-play-centered" controls preload="auto" width="150" height="150"
	          poster="" data-setup='{"aspectRatio":"640:267", "playbackRates": [1, 1.5, 2] }'>
	            <source src="{{$src}}" type='video/mp4'>
	            
	            <p class="vjs-no-js">
	              To view this video please enable JavaScript, and consider upgrading to a web browser that
	              <a href="http://videojs.com/html5-video-support/" target="_blank">supports HTML5 video</a>
	            </p>
	        </video>
        	

        	<?php } elseif($record->question_type == 'audio') {  
        		
            $src = EXAM_UPLOADS.$record->question_file;
        	
        	if($record->question_file_is_url)
        		$src= $record->question_file; 
            ?>
        	
			<audio controls class="audio-controls">
        	  	<source src="{{$src}}" type="audio/ogg">
          		<source src="{{$src}}" type="audio/mpeg">
        	</audio>

        <?php } ?>
        