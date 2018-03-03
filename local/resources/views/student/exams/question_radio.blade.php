<?php
    $answers = json_decode($question->answers);
    $i=1;
 ?>
<div class="select-answer">
    <ul class="row list-style-none">
        @foreach($answers as $answer)
        
        <li class="col-md-6">
            <input id="{{ $answer->option_value}}{{$question->id}}{{$i}}" value="{{$i}}" name="{{$question->id}}[]" type="radio"/>
            
            <label for="{{$answer->option_value}}{{$question->id}}{{$i++}}">
                <span class="fa-stack radio-button">
                    <i class="mdi mdi-check active">
                    </i>
                </span>
                {{$answer->option_value}}
            </label>
            @if($answer->has_file)
            <img src="{{$image_path.$answer->file_name}}" height="50" width="50">
            @endif

        </li>
        @endforeach
    </ul>
 
</div>
