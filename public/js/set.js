

function checkAns(sno, count, cans){
    
    var answer_value="answer_value"+count+'-'+sno;
    document.getElementById(answer_value).checked=true;
    var cqtype = '#qtype'+count;
    
    
    // Getting Checked Answer
    var answer = '';
    if($(cqtype).val()=='radio'){
        var rbnm = 'answer['+ count +'][]';
        var ele = document.getElementsByName(rbnm);
        for(i = 0; i < ele.length; i++) {

            if(ele[i].type="radio") {

                if(ele[i].checked)
                    answer = ele[i].value;
            }
        }
    }
    // Checking Correct Answer
    if(cans == answer){
        var rbnm = "answer_value"+count+'-'+sno;
        var ele = document.getElementById(rbnm);
        ele.classList.add("correct");

        var hnt = "qbh"+count;
        ele = document.getElementById(hnt);
        ele.classList.remove("d-none");
        ele.classList.add("d-block");

        // console.log('answer: '+cans);
        // console.log('coroptionid:'+rbnm);
    }else{
        
        var rbnm = "answer_value"+count+'-'+sno;
        var ele = document.getElementById(rbnm);
        ele.classList.add("wrong");
        
        var rbnm2 = "answer_value"+count+'-'+cans;
        var ele = document.getElementById(rbnm2);
        ele.classList.add("correct");
        var hnt = "qbh"+count;
        ele = document.getElementById(hnt);
        ele.classList.remove("d-none");
        ele.classList.add("d-block");
       
    }

}

function checkAns2(count, cans){
    
    var answer_value="answer"+count;

    if(document.getElementById(answer_value).value != ''){
        var cqtype = '#qtype'+count;
        // Getting Checked Answer
        var answer = '';
        if($(cqtype).val()=='nat'){
            var rbnm = 'answer'+ count;
            var ele = document.getElementById(rbnm);
            if(ele.value != ''){
                // alert(ele.value);
                answer = ele.value;
            }
        }
        // Checking Correct Answer
        if(answer != ''){
            if(cans == answer){
                var rbnm = "answer"+count;
                var ele = document.getElementById(rbnm);
                ele.classList.add("green-control");
                var hnt = "qbh"+count;
                ele = document.getElementById(hnt);
                ele.classList.remove("d-none");
                ele.classList.add("d-block");
            }else{
                var rbnm = "answer"+count;
                var ele = document.getElementById(rbnm);
                ele.classList.add("red-control");
                // console.log(cans);
                // console.log(answer);
                var hnt = "qbh"+count;
                ele = document.getElementById(hnt);
                ele.classList.remove("d-none");
                ele.classList.add("d-block");
                
            }
        }
    }
}


