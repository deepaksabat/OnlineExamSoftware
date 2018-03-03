 
    <div class="row">
    <?php  

    $correct_answers = json_decode($question->correct_answers); ?>
        <div class="col-md-6">
            <h4> Submitted</h4>
            <form>
                <ul class="filling-blank answersheet">
                <?php 
             
                $sno = 1; foreach($user_answers as $answer) { 
                    $correct_answer_class = '';
                    if($correct_answers[$sno-1]->answer == $answer)
                        $correct_answer_class = 'blank_correct-answer';

                    ?>    
                    <li class="{{$correct_answer_class}}" > <span class="numbers-count bg-primary">{{$sno++}}</span>{{$answer}} </li>
                    <?php } ?>
                
                </ul>
            </form>
        </div>
        
        
        <div class="col-md-6">
            <h4> Correct</h4>
            <form>
                
                <ul class="filling-blank answersheet">
                    <?php $sno = 1; foreach($correct_answers as $answer) { ?>
                    <li> <span class="numbers-count bg-primary">{{$sno++}}</span>{{$answer->answer}} </li>
                    <?php } ?>
                
                </ul>
            </form>
        </div>

    </div>
