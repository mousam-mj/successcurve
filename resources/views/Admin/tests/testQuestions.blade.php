

<style>
    .main-box{
        width: 100%;
        min-height: 100vh;
    }
    .qb{
        width: 100%;
        padding: 20px 40px;
    }
    label.radio {
    cursor: pointer;
    position: relative;
    width: 100%;
}
.radio .ono{
    padding: 3px 5px;
    background: #101010;
    color: #fff;
    border-radius: 10px;
    margin-right: 20px;
    display: inline-block;
}
.radio p{
    display: inline-block;
}
label.radio input {
  position: absolute;
  top: 0;
  left: 0;
  visibility: hidden;
  pointer-events: none;
}
label.radio .option {
    padding: 0 30px;
/*    border-bottom: 2px solid #EEE;*/
    border-radius: 5px;
    display: inline-block;
    color: #000;
    width: 100%;
}
.qpaara{
    font-size: 15px;
}

</style>


<div class="main-box">
    <?php $count = 1?>
    @foreach ($questionModels as $qnsModel)
        
    
    @foreach($qnsModel['questions'] as $que)
        
        <div class="qbx">
            <div class="qb">
                <div class="qpaara" style="display: flex;">
                    <span><b>Q {{ $count }}.&nbsp; </b></span> {!! $que->qwTitle !!}
                </div>
            </div>
            @if ($que->qwType == "radio" || $que->qwType == "checkbox")
                <?php
                    $i = 1;
                    $options = json_decode(json_encode(json_decode($que->qwOptions)), true);
                
                    $ops = $que->totalOptions;
                    for($i = 1; $i <= $ops; $i++){
                        
                        ?>
                        <label class="radio" onclick="checkrad()">
                            <input type="radio" name="answer[<?php echo $count;?>][]" value="<?php echo $i;?>" id="answer_value<?php echo $count.'-'.$i;?>">
                            <span class="option" style="font-size: 15px !important;"><span class="ono"><?php echo $i;?></span> {!! $options['option'.$i] !!}</span>
                        </label>
                <?php
                    }
                ?>
            @elseif ($que->qwType == 'nat')
                <div class="form-group" style="padding-left: 40px; padding-right: 40px">
                    {{-- <label for="answer<?php echo $count;?>" class="log-label">Answer</label> --}}

                    <input type="number" name="answer<?php echo $count;?>" id="answer<?php echo $count;?>" class="form-control" placeholder="Enter Answer" onblur="checkrad()" >
                </div>
            @endif
        </div>
        <?php $count++;?>
    @endforeach

    
    @if ($qnsModel['paragraphs'] != null)
    <?php 
        $prev = '';
        $curr = '';
        $counter = 0;
    ?>
    
    @foreach($qnsModel['paragraphs'] as $que)
    <div class="qbx">
            <?php 
                $prev = $curr;
                $curr = $que->paragraphId;
            ?>

            @if ($prev != $curr)
                <div class="qb">
                    @if ($que->paragraphId != 0)
                    
                        <div class="qpaara" style="font-size: 15px; display: flex;">
                            <span class="text-danger"><b>Paragraph:&nbsp;</b></span> {!! $que->prgContent !!}
                        </div>
                    @endif
                </div>
            @endif
            
            <div class="qb">
                <div class="qpaara mt-20" style="font-size: 15px !important; display: flex;">
                    <span><b>Q {{ $count }}.&nbsp; </b></span>  {!! $que->qwTitle !!}
                </div>
            </div>

        @if ($que->qwType == "radio" || $que->qwType == "checkbox")
            <?php
                $i = 1;
                $options = json_decode(json_encode(json_decode($que->qwOptions)), true);
            
                $ops = $que->totalOptions;
                for($i = 1; $i <= $ops; $i++){
                    
                    ?>
                    <label class="radio">
                        <input type="radio" name="answer[<?php echo $count;?>][]" value="<?php echo $i;?>" id="answer_value<?php echo $count.'-'.$i;?>">
                        <span class="option" style="font-size: 15px !important;"><span class="ono"><?php echo $i;?></span> {!! $options['option'.$i] !!}</span>
                    </label>
            <?php
                }
            ?>
        @elseif ($que->qwType == 'nat')
            <div class="form-group" style="padding-left: 40px; padding-right: 40px">
                <input type="number" name="answer<?php echo $count;?>" id="answer<?php echo $count;?>" class="form-control" placeholder="Enter Answer" value="{{ $que->qwCorrectAns }}">
            </div>
        @endif
        
    </div>

    <?php $counter++;?>
    <?php $count++;?>
    @endforeach
    @endif
    @endforeach

</div>

