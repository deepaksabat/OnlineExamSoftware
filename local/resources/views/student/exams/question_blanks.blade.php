<div class="row">
    <div class="col-md-12">
        <ul class="filling-blank">

            @for($i=1; $i <= $question->total_correct_answers; $i++)
            <li>
                <span class="numbers-count">
                    {{ $i }}
                </span>
                <fieldset class="form-group">
                    <input class="form-control pull-right" placeholder="Blank {{$i}}" type="text" name="{{$question->id}}[]">
                    </input>
                </fieldset>
            </li>
            @endfor
             
        </ul>
        
    </div>
 
</div>