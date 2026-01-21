<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Subject;
use App\User;
use App\Classe;
use App\Testcatogerie;
use App\Subjecttopic;
use App\Instruction;
use App\Questionbank;
use App\Testquestion;
use App\Testsection;
use App\Testenroll;
use App\Test;
use App\Exam_answer;
use App\Result;
use App\Subjectanalysi;


use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use App\Mail\ExamResultMail;



class ResultController extends Controller
{
    function saveAnswer(Request $req){
        $testId = $req->testId;
        $resId = $req->resultId;
        $questionId = $req->questionId;
        $answer = $req->answer;
        $tsecId = $req->tsecId;
        $ques = Questionbank::where('qwId', $questionId)->first();
        $ts = Testsection::where('tsecId', $tsecId)->first();
        $marks = $ts->tsMarks;
        $neg_marks = $ts->tsNegMarks;

        //dd($marks.' / '.$neg_marks);
        $tques = Testquestion::where('testId', $testId)
            ->where('questionId', $questionId)->first();

        $remarks = 0;
        if($ques->qwType == "checkbox"){
            $answer = implode(',',$answer);
        }
        
        if ($ques->qwCorrectAnswer == $answer){
            $remarks = 1;
        } else if ($ques->qwType == "nat" && $ques->qwMinRange <= $answer && $ques->qwMaxRange >= $answer) {
            $remarks = 1;
        }

        $ra = Exam_answer::where('resultId', $resId)
            ->where('testId', $testId)
            ->where('userId', Session::get('userId'))
            ->where('examSectionId', $tsecId)
            ->where('questionId', $questionId)
            ->first();
        if (!empty($ra)) {
            $ra->answer = $answer;
            $ra->remarks = $remarks;
            if($remarks == 1){
                $ra->marks = $marks;
                $ra->neg_marks = 0;
            } else {
                $ra->marks = 0;
                $ra->neg_marks = $neg_marks;
            }

            $ra->correct_answer= $ques->qwCorrectAnswer;

            $ra->save();
        }else{
            $rans = new Exam_answer;
            $rans->resultId = $resId;
            $rans->testId = $testId;
            $rans->userId = Session::get('userId');
            $rans->examSectionId = $tsecId;
            $rans->correct_answer = $ques->qwCorrectAnswer;
            $rans->questionId = $questionId;
            $rans->answer = $answer;
            $rans->remarks = $remarks;
            if($remarks == 1){
                $rans->marks = $marks;
                $rans->neg_marks = 0;
            }
            else{
                $rans->marks = 0;
                $rans->neg_marks = $neg_marks;
            }
            $rans->save();
        }


//        dd('TestId = '.$testId.' ResultId = '.$resId.' QuestionId = '.$questionId.' Answer = '.$answer);
        return 'Success';

    }


    public function finalSubmit(Request $req){
        $testId = $req->testId;
        $resultId = $req->resultId;
        $mytime = $req->mytime;
        $ans = Exam_answer::where('resultId', $resultId)
            ->where('testId', $testId)
            ->where('userId', Session::get('userId'))
            ->get();
        $rightAns = $ans->where('remarks', '1')->count();
        $wrongAns = $ans->where('remarks', '0')->count();
        //dd('Right = '.$rightAns.' Wrong = '.$wrongAns);
        $rightMarks = 0;
        $wrongMarks = 0;
        foreach($ans as $an){
            $rightMarks += $an->marks;
            $wrongMarks += $an->neg_marks;
        }
        $finalMarks = $rightMarks - $wrongMarks;
        //dd($resultId);
        $res = Result::where('resultId', $resultId)->first();
        // dd($res);
        $res->correct_ans = $rightAns;
        $res->wrong_ans = $wrongAns;
        $res->correct_marks = $rightMarks;
        $res->wrong_marks = $wrongMarks;
        $res->final_marks = $finalMarks;
        $res->time_taken = $mytime;
        $res->save();

        // Section Analysis
        $tsecIds = TestSection::select('tsecId','tsMarks')->where('testId', $testId)->get();
        foreach($tsecIds as $tsec){
            $tsecId = $tsec->tsecId;
            $tst = Testquestion::where('tsecId', $tsecId)->get();
            $tstc = $tst->count();

            
            $tstmks = $tstc * $tsec->tsMarks;
            // dd($tstmks);
            //dd($tstmks);
            $tsrmks = Exam_answer::where('resultId', $resultId)
            ->where('examSectionId', $tsecId)
            ->where('userId', Session::get('userId'))
            ->sum('marks');
            $tswmks = Exam_answer::where('resultId', $resultId)
            ->where('examSectionId', $tsecId)
            ->where('userId', Session::get('userId'))
            ->sum('neg_marks');
            // dd($tswmks);
            $tsymks = $tsrmks - $tswmks;

            $ra = Subjectanalysi::updateOrCreate([
                'resultId'   => $resultId,
                'tsecId'   => $tsecId,
                'userId' => Session::get('userId')
            ],[
                'total_marks'=> $tstmks,
                'right_marks'=> $tsrmks,
                'wrong_marks'=> $tswmks,
                'your_marks'=> $tsymks
            ]);
        }
        $mts = Test::where('tId', $testId)->first();
        $data= [
            'name'=>Session::get('user'),
            'test'=>$mts->tName,
            'ymarks'=>$finalMarks,
            'tmarks' => $mts->total_marks,
            'time'=> Carbon::now(),
            'resultUrl'=>'https://www.successcurve.in/result/testReport/'.$resultId,
        ];
        Mail::to(Session::get('userEmail'))->send(new ExamResultMail($data));
        return 'success';
    }

    public function testReport($id){

        $result = Result::where('resultId', $id)->first();



        $testId  = $result->examId;
//        dd($result->examId);
        $test = Test::where('tId', $testId)->first();

        $rank = Result::where('examId', $testId)
            ->where('final_marks', '>=' ,$result->final_marks)
            ->count();
        $totalStudentsEnrolls = Result::where('examId', $testId)->count();

       
        $minmarks = Result::select('final_marks')
            ->where('examId', $testId)
            ->orderBy('final_marks', 'ASC')
            ->first();

        $belowStds = Result::where('examId', $testId)->where('final_marks', '<', $result->final_marks)->count();

        $tstds = Result::where('examId', $testId)
            ->count();
        $percentile = 0;
        if($tstds == 1){
            $percentile = 100;
        }elseif($tstds > 1 ){
            $percentile = number_format((float)(( $belowStds *100)/($tstds-1)), 2, '.', '');
        }
        
        $percentage = number_format((float)( $result->final_marks *100 / $test->total_marks ), 2, '.', '');

        $yAcc = 0;
        if ($result->correct_ans > 0 || $result->wrong_ans > 0) {
            $yAcc = number_format((float)(($result->correct_ans)/($result->correct_ans + $result->wrong_ans) * 100), 2, '.', '' );
        }
        

        // Caclculating Toppers Details
        
        $topper = Result::where('examId', $testId)
        ->orderBy('final_marks', 'DESC')
        ->first();

        $tAcc = 0;
        if ($topper->correct_ans > 0 || $topper->wrong_ans > 0) {
            $tAcc = number_format((float)(($topper->correct_ans)/($topper->correct_ans + $topper->wrong_ans) * 100), 2, '.', '' );
        }
        
        // Calculating Avarage Deatils

        $avg = array();

        $avg['score'] = Result::where('examId', $testId)
        ->avg('final_marks');
        $avg['right'] = Result::where('examId', $testId)
        ->avg('correct_ans');
        $avg['wrong'] = Result::where('examId', $testId)->avg('wrong_ans');
        $avg['time_taken'] = Result::where('examId', $testId)
        ->avg('time_taken');
        $avg['attempts'] = Result::where('examId', $testId)
        ->avg('attempts');
        $avg['accuracy'] = ($avg['right'] / ($avg['right'] + $avg['wrong'])) * 100;

        //  Section Ananlysis
        $anas=[];
        $tsecIds = TestSection::select('tsecId','tsecName')->where('testId', $testId)->get();
        
        $sac = 0;
        foreach($tsecIds as $tsec){

            $tsecId = $tsec->tsecId;
            $tsecName = $tsec->tsecName;
            $ra = Subjectanalysi::where('tsecId', $tsecId)
                ->where('resultId', $id)
                ->first();

            if($ra->total_marks!=0){
                $mkper = number_format((float)(($ra->your_marks*100)/$ra->total_marks), 2, '.', '');
            }
            else{
                $mkper = 0;
            }

            $mkavg = Subjectanalysi::where('tsecId', $tsecId)->avg('your_marks');
            $mktop = Subjectanalysi::select('your_marks')->where('tsecId', $tsecId)->orderBy('your_marks','DESC')->first();
            $anas[$sac]=[
                'secdata'=>$ra,
                'secName'=>$tsecName,
                'perc'=>$mkper,
                'avg'=>$mkavg,
                'topr'=>$mktop
            ];
            $sac++;
        }

        $overs = [];
        $overs['rank'] = $rank;
        $overs['totalStudents'] = $totalStudentsEnrolls;
        $overs['minmarks'] = $minmarks;
        $overs['percentile'] = $percentile;
        $overs['percentage'] = $percentage;
        $overs['accuracy'] = $yAcc;
        $overs['topperAccuracy'] = $tAcc;

        return View('Exam/testReport', ['res'=>$result, 'topper'=> $topper, 'average' => $avg,'tests'=>$test, 'overs'=>$overs, 'anas'=>$anas]);
    }
}
