
                   
                        <div class="row">
                            <div class="col-md-12">
                                <form>
                                    <ul class="optional-questions ">
                                        <?php 
                                        $options = json_decode($question->answers); 
                                        $correct_answers = $question->correct_answers;
                                        $index = 1;
                                      
                                        foreach ($options as $option) {
                                            $correct_answer_class = '';
                                           
                                            if($correct_answers == $index) {
                                                $correct_answer_class = 'correct-answer';
                                            }

                                            $submitted_value = '';
                                            
                                                if(count($user_answers)) {
                                                    if($user_answers[0] == $index)
                                                        $submitted_value = 'checked';
                                                }
                                            
                                           
                                        ?>
                                        <li class="col-md-6 {{$correct_answer_class}} answer_radio">
                                            <input type="radio" name="option" id="radio1" disabled {{$submitted_value}}>
                                            <label for="radio1"> <span class="fa-stack radio-button"> <i class="mdi mdi-check active"></i> </span> {{$option->option_value}} </label>
                                        </li>
                                         <?php  $index++;
                                                } ?>
                                    </ul>
                                </form>
                            </div>
                        </div>
                    