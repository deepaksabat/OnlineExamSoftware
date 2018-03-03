<?php $path  = $content->file_path; 
if (!preg_match('/http/',$content->file_path))
 $path = IMAGE_PATH_UPLOAD_LMS_CONTENTS.$content->file_path; 
?>

<div class="series-video">
	<div class="col-lg-12 text-center">
	    <audio controls class="audio-controls">
	      <source src="{{$path}}" type="audio/ogg">
	      <source src="{{$path}}" type="audio/mpeg">
	    </audio>
	</div>
</div>