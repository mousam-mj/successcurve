
@extends('Exam.testLayout')
@section('title')
Test Instruction
@endsection
@section('content')

<div class="main-box">
    <div class="udbox fixed-top">
        <div class="row">
            <div class="col-md-6">
<!--                       <h1 class="successcurve mt-20"> SUCCESSCURVE<sup class="in2"> .IN</sup></h1>-->
                <h3 class="text-white">SUCCESSCURVE<sup>.IN</sup></h3>
                <h6 class="text-white">Test: {{ $tsts->tName }}</h6>
            </div>
            <div class="col-md-6 smt20">
                <div class="row">
                    <div class="col-9 col-md-8 text-right">
                        <h5 class="uname">{{ Session::get('user') }}</h5>
                        <p class="uemail">{{ Session::get('userEmail') }}</p>
                    </div>
                    <div class="col-3 col-md-4 text-center">
                        <img src="{{ URL::asset(Session::get('userImage')) }}" class="uimage" alt="User Image">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="instbox">
        
        <h6 class="mt-30"><b><u>Please Read The Instruction Carefully :</u></b></h6>
        <ol class="tins-ol">
            <li>Total Duration of <b>{{ $tsts->tName }}</b> is<b> {{ $tsts->duration }}</b> mins.  
                <br/>
                <span class="li-span">सभी प्रश्नों को हल करने की कुल अवधि <b>{{ $tsts->tName }}</b> के लिए <b> {{ $tsts->duration }}</b> मिनट है।</span> </li>
            
            <li>The clock will be set at the server. The countdown timer in the top right corner of screen will display the remaining time available for you to complete the examination. When the timer reaches zero, the examination will end by itself. You will not be required to end or submit your examination. <br/>
            <span class="li-span">सर्वर पर घड़ी लगाई गई है तथा आपकी स्क्रीन के दाहिने कोने में शीर्ष पर काउंटडाउन टाइमर में आपके लिए परीक्षा समाप्त करने के लिए शेष समय प्रदर्शित होगा। परीक्षा समय समाप्त होने पर, आपको अपनी परीक्षा बंद या जमा करने की जरूरत नहीं है । यह स्वतः बंद या जमा हो जाएगी।</span>
            </li>
           
        </ol>
         <div class="mainins mt-30">
            {!! $tsts->inDescription !!}
        </div>
        <h6 class="mt-30"><b><u>General Instruction :</u></b></h6>
        <ol class="tins-ol">
            
            <li>The Questions Palette displayed on the right side of screen will show the status of each question using one of the following symbols:
                <br/>
                <span class="li-span">स्क्रीन के दाहिने कोने पर प्रश्न पैलेट, प्रत्येक प्रश्न के लिए निम्न में से कोई एक स्थिति प्रकट करता है:</span>
                <ul class="ques-li">
                    <li><div class="qbox not-visited"></div> You have not visited the question yet.
                   
                    <span class="ques-li-span">(आप अभी तक प्रश्न पर नहीं गए हैं।)</span>
                    </li>
                    <li><div class="qbox not-answered"></div> You have not answered the question
                    
                        <span class="ques-li-span">(आपने प्रश्न का उत्तर नहीं दिया है।)</span>
                    </li>
                    <li><div class="qbox answered"></div> You have answered the question
                        <span class="ques-li-span">(आप प्रश्न का उत्तर दे चुके हैं।)</span></li>
                    <li><div class="qbox review"></div> You have NOT answered the question, but have marked the question for review
                        <span class="ques-li-span">(आपने प्रश्न का उत्तर नहीं दिया है पर प्रश्न को पुनर्विचार के लिए चिन्हित किया है।)
                        </span></li>
                    <li><div class="qbox answered-review"></div> The question(s) "Answered and Marked for Review will be considered for evalution
                        <span class="ques-li-span">( प्रश्न जिसका उत्तर दिया गया है और समीक्षा के लिए भी चिन्हित है , उसका मूल्यांकन किया जायेगा ।)</span></li>
                </ul>
            </li>
            
        </ol>
        
        
       
        
       
        
    </div>
    <div class="terms-con-box">
        <div class="form-group">
            <label for="accept" class="acclabel"><input type="checkbox" id="accept" name="termsCondition" value="accepeted" class="d-inline">
        I have read and understood the instructions All computer hardware allotted to me are in proper working condition I declare that I am not in possession of / not wearng not carrying any prohibited gadget like mobile phone, bluetooth devices etc funny prohibited material with me into the Examination HallI agree that in case of not adhering to the instructions, I shall be liable to be debarred from this Test andor to disciplinary action, which may Include ban from future Tests / Examinations</label>
        </div>
        <div class="form-group text-center">
            <a class="btn btn-primary" href="{{ url('exam/startTest/'.$tsts->tId) }}"  id="gobtn">Start Test</a>
        </div>
            
    </div>
</div>

@endsection

@section('javascript')
<script>
    $(document).ready(function() {
        $('#gobtn').hide();
        $('#accept').click(function(){
            if($(this).prop("checked") == true){
                $('#gobtn').show();
            }
            else if($(this).prop("checked") == false){
                $('#gobtn').hide();
            }
        });
       
    });
    
</script>

@endsection
