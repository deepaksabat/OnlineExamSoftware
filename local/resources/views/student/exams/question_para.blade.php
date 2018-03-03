<?php $answers = json_decode($question->
answers);
    // dd($question);
 ?>
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
