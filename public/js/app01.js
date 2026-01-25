//Global variables

var noq = 0;
var qn = 0;
var lqn = 0;
var answered = 0;
var notanswered = 0;
var review = 0;
var ansrev = 0;
 
var baseurl = $('#baseurl').val();

noq = $('#tqn').val();
function hide_all_question(){
    for(var i=0; i < noq; i++){
		
		var did="#q"+i;
	$(did).css('display','none');
	}
}
function show_question(vqn){
    
	hide_all_question();
	var did="#q"+vqn;
    var cqty = '#qtype'+vqn;
    var cmarks = '#qmarks'+vqn;
    var cnegmarks = '#qnegmarks'+vqn;
    
    change_color(vqn, cqty);
    
    var qno = vqn+1;
    $('#qno').html(qno);
    if(cqty == 'radio')
    {
        $('#qtpe').html('Multiple Choice Question');
    }
    $('#pmarks').html($(cmarks).val());
    $('#pnegmarks').html($(cnegmarks).val());
    
    if ($(did).hasClass("qbx2")){
        $(did).css('display','flex');
    }else{
        $(did).css('display','block');
    }
    
	// hide show next back btn
	if(vqn >= 1){
	$('#prevBtn').css('visibility','visible');
	}
	
	if(vqn < noq){
	$('#nextBtn').css('visibility','visible');
	}
	if((parseInt(vqn)+1) == noq){
	  
	$('#nextBtn').css('visibility','hidden');
	}
	if(vqn <= 0){
	$('#prevBtn').css('visibility','hidden');
	}
	
    
    if(vqn > 0){
         save_answer(lqn);
    }
	// last qn
	qn=vqn;
    lqn=vqn;
//setIndividual_time(lqn);
    
    // Wrap LaTeX expressions in delimiters if needed
    setTimeout(function() {
        $(did + ' .math-content').each(function() {
            var $this = $(this);
            var content = $this.html();
            
            // Check if content contains LaTeX-like patterns but no delimiters
            if (content && content.match(/\\[a-zA-Z]+|\\frac|\\sqrt|\\pm|\\times|\\div|\\leq|\\geq|\\neq|\\approx/) && 
                !content.match(/\$|\\\(|\\\[/)) {
                // Wrap content in inline math delimiters
                $this.html('\\(' + content + '\\)');
            }
        });
        
        // Re-render MathJAX when question is shown
        if (typeof MathJax !== 'undefined' && MathJax.typesetPromise) {
            var questionElement = document.querySelector(did);
            if (questionElement) {
                // Reset MathJax for this element
                if (MathJax.typesetClear) {
                    MathJax.typesetClear([questionElement]);
                }
                MathJax.typesetPromise([questionElement]).then(function() {
                    console.log('MathJax rendered for question ' + vqn);
                }).catch(function (err) {
                    console.log('MathJax render error:', err);
                    // Fallback to full page render
                    MathJax.typesetPromise().catch(function (err2) {
                        console.log('MathJax fallback render error:', err2);
                    });
                });
            } else {
                MathJax.typesetPromise().catch(function (err) {
                    console.log('MathJax render error:', err);
                });
            }
        }
    }, 100);
    	
}
function next_question(){

	if((parseInt(qn)+1) < noq){
	qn=(parseInt(qn)+1);
	   show_question(qn);
	}
}


function prev_question(){
	
	if((parseInt(qn)-1) >= 0 ){
	qn=(parseInt(qn)-1);
	   show_question(qn);
	}		
}

function change_color(qn, cqtype){
	var did='#qbtn'+qn;
	
	
	// if not answered then make red
	// alert($(did).css('backgroundColor'));
	if($(did).hasClass('not-visited')){
	   $(did).removeClass('not-visited');
	   $(did).addClass('not-answered');
        notanswered+=1;
	}
	
	
    setValues();
	
}


function checkrad(){

//  document.getElementById(did).checked=true;
    var cqtype = '#qtype'+qn;
    // answered make green
	if(qn >= '0'){
	var ldid='#qbtn'+qn;
		var green=0;
		if($(cqtype).val()=='radio' || $(cqtype).val()=='checkbox'){
            
            for(var k=0; k<=10; k++){
                var answer_value="answer_value"+qn+'-'+k;
                if(document.getElementById(answer_value)){
                    if(document.getElementById(answer_value).checked == true){	
                    green=1;
                    }
                }
            }
        }else if($(cqtype).val()=='nat'){
            var answer_value="answer"+qn;
            if(document.getElementById(answer_value)){
                if(document.getElementById(answer_value).value != ''){	
                    
				    green=1;
				}
            }
        }
		if(green==1){
            if($(ldid).hasClass('not-answered')){
                $(ldid).removeClass('not-answered');
                $(ldid).addClass('answered');
                answered +=1;
                notanswered -=1;
            }
            else if($(ldid).hasClass('review')){
                $(ldid).removeClass('review');
                $(ldid).addClass('answered');

                review-=1;
                answered +=1;
             }
            else if($(ldid).hasClass('asnwered-review'))
            {
                $(ldid).removeClass('asnwered-review');
                $(ldid).addClass('answered');

                answered +=1;
                ansrev -=1;
            }
        
		}		
		setValues();
	}
 }

function clear_response(){
    var q_type='#qtype'+qn;
    var did='#qbtn'+qn;
    
    if($(did).hasClass('answered')){
        if($(q_type).val()=='radio' || $(q_type).val()=='checkbox'){
		 
          for(var k=0; k<=10; k++){
                var answer_value="answer_value"+lqn+'-'+k;

                if(document.getElementById(answer_value)){

                    if(document.getElementById(answer_value).checked == true){

                    document.getElementById(answer_value).checked=false;
                    }
                }
            }
            notanswered+=1;
            answered-=1;
            $(did).removeClass('answered');
            $(did).addClass('not-answered');
        }else if($(q_type).val()=='nat'){
            var answer_value="answer"+qn;
            if(document.getElementById(answer_value)){
                if(document.getElementById(answer_value).value != ''){	
				    document.getElementById(answer_value).value == '';
                    notanswered+=1;
                    answered-=1;
                    $(did).removeClass('answered');
                    $(did).addClass('not-answered');
				}
            }
        }					
    }
    else if($(did).hasClass('review')){
        notanswered+=1;
        review-=1;
        $(did).removeClass('review');
        $(did).addClass('not-answered');  
    }
    else if($(did).hasClass('answered-review')){
        if($(q_type).val()=='radio' || $(q_type).val()=='checkbox'){
		 
          for(var k=0; k<=10; k++){
                var answer_value="answer_value"+lqn+'-'+k;

                if(document.getElementById(answer_value)){

                    if(document.getElementById(answer_value).checked == true){

                    document.getElementById(answer_value).checked=false;
                        
                    }
                }
            }
             notanswered+=1;
            ansrev-=1;
            $(did).removeClass('answered-review');
            $(did).addClass('not-answered');  
        }
    }
	setValues();
    
}


//Review Question


//var review_later;
//review_later[qn] && review_later[qn]
function review_later(){
	var did='#qbtn'+qn;
    
    if($(did).hasClass('review')){
//		review_later[qn]=0;
        $(did).removeClass('review');
        $(did).addClass('not-answered');
        notanswered+=1;
        review-=1;
	}else if($(did).hasClass('not-answered')){
		notanswered-=1;
        review+=1;
//		review_later[qn]=1;
        $(did).addClass('review');
        $(did).removeClass('not-answered');
	}
    else if($(did).hasClass('answered')){
        var q_type='#qtype'+qn;
        if($(q_type).val()=='radio' || $(q_type).val()=='checkbox'){
		 
          for(var k=0; k<=10; k++){
                var answer_value="answer_value"+lqn+'-'+k;

                if(document.getElementById(answer_value)){

                    if(document.getElementById(answer_value).checked == true){

                    document.getElementById(answer_value).checked=false;
                        
                    }
                }
            }
            answered-=1;
        review+=1;
//		review_later[qn]=1;
        $(did).addClass('review');
        $(did).removeClass('answered');
        }
        
        
    }
    else if($(did).hasClass('answered-review')){
        ansrev-=1;
        review+=1;
//		review_later[qn]=1;
        $(did).addClass('review');
        $(did).removeClass('answered-review');
    }
	setValues();
}

function save_review(){
    if(qn >= '0'){
	var did='#qbtn'+qn;   
    var cqtype = '#qtype'+qn;
    if($(cqtype).val()=='radio' || $(cqtype).val()=='checkbox'){
		var green=0;
		for(var k=0; k<=10; k++){
			var answer_value="answer_value"+qn+'-'+k;
			if(document.getElementById(answer_value)){
				if(document.getElementById(answer_value).checked == true){	
				green=1;
				}
			}
		}
		if(green==1){
            if($(did).hasClass('answered')){
                $(did).removeClass('answered');
                $(did).addClass('answered-review');
                ansrev +=1;
                answered -=1;
            }
            
		}else{
            alert('Please select an Option!');
        }		
		}			
	}
    setValues();
}


function submit_test(){
    
    
    save_answer(qn);
    
    $('#final-dialouge').css('display', 'flex');
    var notvisited = noq-notanswered-answered-review-ansrev;
    $('#notv2').html(notvisited);
    $('#answ2').html(answered);
    $('#nota2').html(notanswered);
    $('#mr2').html(review);
    $('#smr2').html(ansrev);
}

function final_submit_test(){
    var resId = $('#resultId').val();
//  alert(resId);
    var testId = $('#testId').val();
    var csrf = $('#csrf_token').val();
    var url = baseurl+"/result/finalSubmit";
    $.ajax({
        url: url,
        type: "POST",
        data:{ 
            _token:csrf,
            testId: testId,
            resultId: resId,
            mytime: mytime,
        },
        cache: false,
        dataType: 'json',
        beforeSend: function () {
                closeDialouge();
               $('.ring-out').removeClass('hidden');
           },
        complete: function(xmlHttp){
//            alert(xmlHttp.status);
            if(xmlHttp.status === 200){

                resId = parseInt(resId);
                var url2 = "/result/testReport/"+resId;
                window.location.href = url2;
            }
        }
    });
}
function submitReport(){
    var qid = '#qid'+qn;
    qid = $(qid).val();
    var report = $('#reportText').val();
    var testId = $('#testId').val();
    var csrf = $('#csrf_token').val();
    var url = baseurl+"/result/submitReport";
    $.ajax({
        url: url,
        type: "POST",
        data:{ 
            _token:csrf,
            testId: testId,
            questionId: qid,
            report: report,
        },
        cache: false,
        dataType: 'json',
        complete: function(xmlHttp){
//            alert(xmlHttp.status);
            if(xmlHttp.status === 200){
               closeDialouge2(); 
            }
        }
    });
}

function report_question(){
    $('#final-dialouge2').css('display', 'flex');
}

function closeDialouge(){
    $('#final-dialouge').css('display', 'none');
}function closeDialouge2(){
    $('#reportText').val('');
    $('#final-dialouge2').css('display', 'none');
}



function save_answer(vqn){
    var qid = '#qid'+vqn;
    qid = $(qid).val();
    var cqtype = '#qtype'+vqn;
    var answer = '';
    if($(cqtype).val()=='radio'){
        var rbnm = 'answer['+ vqn +'][]';
        var ele = document.getElementsByName(rbnm); 

        for(i = 0; i < ele.length; i++) { 

            if(ele[i].type="radio") { 

                if(ele[i].checked) 
                  answer = ele[i].value;
            } 
        } 
    }
    else if($(cqtype).val()=='checkbox'){
        var rbnm = 'answer['+ vqn +'][]';
        var ele = document.getElementsByName(rbnm); 
        var tempans = [];
        for(i = 0; i < ele.length; i++) { 
            if(ele[i].type="checkbox") { 
                if(ele[i].checked) 
                  tempans[i] = ele[i].value;
            }
        }
        if(tempans != ''){
            // alert(tempans)
            answer = tempans;
        }
    }
    else if($(cqtype).val()=='nat'){
        var answer_value="answer"+vqn;
        if(document.getElementById(answer_value)){
            if(document.getElementById(answer_value).value != ''){	
            //    console.log(document.getElementById(answer_value).value);
            answer = document.getElementById(answer_value).value;
                
            }
        }
        console.log(answer);
    }
    if(answer){
//        alert(answer);
        var resId = $('#resultId').val();
//        alert(resId);
        var testId = $('#testId').val();
        var csrf = $('#csrf_token').val();
        var tsec = '#tsec'+vqn;
        tsec = $(tsec).val();
        var url = baseurl+"/result/saveAnswer";
        $.ajax({
            url: url,
            type: "POST",
            data:{ 
                _token:csrf,
                testId: testId,
                resultId: resId,
                questionId: qid,
                tsecId: tsec,
                answer: answer,
            },
            cache: false,
            dataType: 'json',
            success: function(dataResult){
                console.log('Success');
            }
        });
    } 
}







function setValues(){
    var notvisited = noq-notanswered-answered-review-ansrev;
    $('#notv').html(notvisited);
    $('#answ').html(answered);
    $('#nota').html(notanswered);
    $('#mr').html(review);
    $('#smr').html(ansrev);
}



