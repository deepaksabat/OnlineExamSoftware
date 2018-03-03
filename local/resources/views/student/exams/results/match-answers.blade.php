  
                        <div class="row">
                            <div class="col-md-12">
                                <form class="match-questions">
                                <?php 
                                        $options            = json_decode($question->answers); 
                                        $correct_answers    = json_decode($question->correct_answers);
                                        $left               = $options->left;
                                        $right              = $options->right;
                                        $left_options       = (array)$left->options;
                                        $right_options      = (array)$right->options;


                                ?>
                                    <div class="row answersheet">
                                        <div class="col-md-4"><h4>{{$left->title}} </h4></div>
                                        <div class="col-md-4"><h4>{{$right->title}}</h4></div>
                                        <div class="col-md-2"><h4>Your answer</h4></div>
                                        <div class="col-md-2"><h4>Correct</h4></div>
                                    </div>
                                    <?php for($index=0; $index<count($left_options); $index++) { ?>
                                    <div class="row answersheet">
                                        <div class="col-md-4"><span class="numbers-count">{{$index+1}}</span> {{$left_options[$index]}}</div>
                                        <div class="col-md-4"> {{$right_options[$index]}} </div>
                                        <div class="col-md-2"><span class="numbers-count bg-primary">{{$user_answers[$index]}}</span></div>
                                        <div class="col-md-2"><span class="numbers-count bg-success">{{$correct_answers[$index]->answer}}</span></div>
                                    </div>
                                   <?php } ?>
                                 
                                </form>
                            </div>
                        </div>
                    