<?php
 
    $answers = json_decode($question->answers);

    $i=1;
   
 ?>

<div class="select-answer">
    <ul class="row list-style-none">
    
     @foreach($answers as $answer)
     @if(isset($answer->option_value))
       <li class="col-md-6">
       <?php $rand_no = mt_rand(1,1000000); ?>
            <input  id="{{$answer->option_value}}_{{$rand_no}}" value="{{$i++}}" name="{{$question->id}}[]" type="checkbox">
           
                <label for="{{$answer->option_value}}_{{$rand_no}}">
                    <span class="fa-stack checkbox-button">
                        <i class="mdi mdi-check active">
                        </i>
                    </span>
                   {{$answer->option_value}}
                </label>
            </input>
             @if($answer->has_file)
            <img src="{{$image_path.$answer->file_name}}" >
            @endif
        </li>  
        @endif
     @endforeach    

      

    </ul>
      
</div>
