<?php $answers = json_decode($question->
answers); 
$leftdata = $answers->left;
$rightdata = $answers->right;
// echo "<pre>";
// print_r($answers);

?>
<div class="match-questions row">
    <div class="col-md-6">
        <h4>{{ $leftdata->title  }}</h4>
    </div>
    <div class="col-md-6">
        <h4>{{ $rightdata->title  }}</h4>
    </div>

    <div class="col-md-6">
        <ul class="option option-left">
        <?php $i=1;?>
        @foreach($leftdata->options as $r)
            <li>
                <span class="numbers-count">
                   {{ $i++ }}
                </span>
                 {{ $r }} 
            </li>
         @endforeach
        </ul>
    </div>
    <div class="col-md-6">
        <ul class="option option-right">
        <?php $i=1;?>
        @foreach($rightdata->options as $r)
            <li>
                <fieldset class="form-group">
                    <input class="form-control pull-right" id="ans" max="2" maxlength="2" min="1" placeholder="2" name="{{$question->id}}[]" type="text">
                        <p>
                            {{ $r }}
                        </p>
                    </input>
                </fieldset>

            </li>
         @endforeach    
        </ul>
    </div>
</div>