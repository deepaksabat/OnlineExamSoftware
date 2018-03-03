
<?php 
    $options = json_decode($question->answers); 
    $correct_answers = json_decode($question->correct_answers);
    
     $outer_index=0;

?>
<div class="row">
    <div class="col-md-12">
        <ul class="questions-container fullwidth">
          <?php foreach($options as $option) { 
            $cAnswer = $correct_answers[$outer_index]->answer;
            $uAnswer = $user_answers[$outer_index++];
            // dd($uAnswer);
            // print_r($option->options[0]);
            $sub_options = (array)$option->options;

            foreach($sub_options as $key => $value)
             $sub_options = $value;
            ?>  
            <li>
                <div class="question">
                    <h3>{{ $option->question }}</h3> </div>
               
                <div class="select-answer">
                    <ul class="row">
                    <?php $index=0; 
                     
                     foreach($sub_options as $value) { 
                        $correct_answer_class = '';
                        if($cAnswer==$index+1)
                        {
                              $correct_answer_class = 'correct-answer';
                        }
                        
                        $submitted_value = '';
                        if($user_answers) 
                        {
                           if($uAnswer == $index+1) 
                           {
                                $submitted_value = 'checked';
                                
                            }
                        }
                      
                        ?>
                        <li class="col-md-6 {{$correct_answer_class}} answer_radio" >
                            <input type="radio" name="option{{$question->id.$outer_index}}" id="1radio1"  {{$submitted_value}} disabled="">
                            <label for="1radio1"> <span class="fa-stack radio-button"> <i class="mdi mdi-check active"></i> </span> {{ $value}}  </label>
                        </li>
                        <?php $index++; } ?>
                    </ul>
                </div>
            </li>
            <hr>
            <?php } ?>

        </ul>
    </div>
</div>
