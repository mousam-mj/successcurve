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
use App\Questionreport;

use Illuminate\Support\Facades\Mail;
use App\Mail\TestenrollMail;
use App\Paragraph;

class ExamController extends Controller
{
    function getExam($id, $name){
        $test = Test::join('subjects', 'tests.tSubject', '=', 'subjects.subjectId')
            ->join('classes', 'tests.tClass', '=', 'classes.classId')
            ->join('users', 'tests.created_by', '=', 'users.id')
            ->select('tests.*', 'subjects.subjectName as subjectName', 'classes.className as className', 'users.name as name', 'users.image as instructorImage')
            ->where('tId', $id)
            ->orderBy('tId', 'desc')
            ->first();

        // $metas = Test::select('tName', 'tMetaKey', 'tMetaDesc')->where('tId', $id)->first();
        $enrolls = 0;
        if(Session::get('userId')){
            $enrol = Testenroll::where('userId', Session::get('userId'))->where('testId', $id)->get();

            if(!$enrol->isEmpty()){
                $enrolls = 1;
            }
        }
        
        return view('Exam/examDescription', ['tests'=>$test, 'enrolls'=>$enrolls]);

    }
    function enrollTest($id){

        $ts = Testenroll::where('testId', $id)->where('userId', Session::get('userId'))->first();
        $tt='';
        if(empty($ts)){
            $testenroll = new Testenroll;
            $testenroll->testId = $id;
            $testenroll->userId = Session::get('userId');
            $testenroll->save();

            $tt = Test::where('tId', $id)->first();
            $tt->students +=1;
            $tt->save();
            $curl= 'https://successcurve.in/exam/test/'.$id.'/'.$tt->tURI;
            $data= [
                'name'=>Session::get('user'),
                'testtitle'=>$tt->tName,
                'testURL'=>$curl
            ];
            Mail::to(Session::get('userEmail'))->send(new TestenrollMail($data));
        }else{
            $tt = Test::where('tId', $id)->first();
        }

        return redirect('exam/test/'.$id.'/'.str_replace(' ', '-', $tt->tName));
    }
    function testInstruction($id){
        $data = Test::join('instructions', 'tests.ipid', '=', 'instructions.inId')
            ->select('tests.*', 'instructions.*')
            ->where('tId', $id)
            ->first();

        return view('Exam/testInstruction',['tsts'=>$data]);
    }
 
    function startTest($id){
      $data = Test::join('instructions', 'tests.ipid', '=', 'instructions.inId')
            ->select('tests.*', 'instructions.*')
            ->where('tId', $id)
            ->first();
        $tsecs = Testsection::where('testId', $id)->get();

        $count = 0;
        $tqno = 0;
        $testSections = [];

        foreach ($tsecs as $tsec) {
            $que = Testquestion::join('questionbanks', 'testquestions.questionId', '=', 'questionbanks.qwId')
            ->select('testquestions.*', 'questionbanks.*')
            ->where('testid', $id)
            ->where('tsecId', $tsec->tsecId)
            ->where('questionbanks.paragraphId', '0')
            ->orderBy('tsecId', 'ASC')
            ->get();

            $pques = TestQuestion::join('questionbanks', 'testquestions.questionId', '=', 'questionbanks.qwId')
            ->select('questionbanks.qwId')
            ->where('testid', $id)
            ->where('tsecId', $tsec->tsecId)
            ->where('questionbanks.paragraphId', '!=', '0')
            ->orderBy('tsecId', 'ASC')
            ->get();

            $pqids = [];
            $c = 0;
            foreach($pques as $pq){
                $pqids[$c] = $pq->qwId;
                $c++;
            }

            $pques = Questionbank::join('paragraphs', 'paragraphs.prgId', '=', 'questionbanks.paragraphId')
            ->select('paragraphs.prgContent as prgContent', 'questionbanks.*')
            ->whereIn('qwId', $pqids)
            ->orderBy('paragraphs.prgId', 'ASC')
            ->get();

            $tqno += $que->count();
            $tqno += $pques->count();

            $testSections[$count]['tsec'] = $tsec;
            if (!empty($que) && count($que) > 0) {
                $testSections[$count]['questions'] = $que;
            } else {
                $testSections[$count]['questions'] = null;
            }

            if (!empty($pques) && count($pques) > 0) {
                $testSections[$count]['paragraphs'] = $pques;
            } else {
                $testSections[$count]['paragraphs'] = null;
            }
            
            $count++;
              
            // dd($que);
            // die();

        }
 
        // print_r("<pre>");
        // print_r($testSections);
        // die();

        $res = Result::where('userId', Session::get('userId'))
            ->where('examId', $id)
            ->orderBy('resultId', 'DESC')
            ->first();
            // dd($res);
        $resultId = '';
         if(!empty($res)){
             $resultId = $res->resultId;
             $res->attempts +=1;
             $res->save();

             Exam_answer::where('resultId', $resultId)->delete();
         }else{

             $ret = new Result;
             $ret->userId = Session::get('userId');
             $ret->examId = $id;
             $ret->save();

              $relt = Result::where('userId', Session::get('userId'))
            ->where('examId', $id)
            ->orderBy('resultId', 'DESC')
            ->first();

            $resultId = $relt->resultId;
            //  dd('executing this one '.$resultId);
         }
//        dd($resultId);
        return view('Exam/test',['tsts'=>$data, 'tsecs'=>$tsecs, 'testSections'=>$testSections, 'tqns'=>$tqno, 'ress'=>$resultId]);
    }

    function testAnswers($id){
        $result = Result::where('resultId', $id)->first();

        $testId = $result->examId;

        $data = Test::where('tId', $testId)
        ->first();

        $tsecs = Testsection::where('testId', $testId)->get();       

        $count = 0;
        $tqno = 0;

        $testSections = [];

        foreach ($tsecs as $tsec) {
            $que = Testquestion::join('questionbanks', 'testquestions.questionId', '=', 'questionbanks.qwId')
            ->select('testquestions.*', 'questionbanks.*')
            ->where('testid', $testId)
            ->where('tsecId', $tsec->tsecId)
            ->where('questionbanks.paragraphId', '0')
            ->orderBy('tsecId', 'ASC')
            ->get();

            $pques = TestQuestion::join('questionbanks', 'testquestions.questionId', '=', 'questionbanks.qwId')
            ->select('questionbanks.qwId')
            ->where('testid', $testId)
            ->where('tsecId', $tsec->tsecId)
            ->where('questionbanks.paragraphId', '!=', '0')
            ->orderBy('tsecId', 'ASC')
            ->get();

            // dd($pques);

            $pqids = [];
            $c = 0;
            foreach($pques as $pq){
                $pqids[$c] = $pq->qwId;
                $c++;
            }

            // dd($pqids);

            $pques = Questionbank::join('paragraphs', 'paragraphs.prgId', '=', 'questionbanks.paragraphId')
            ->select('paragraphs.prgContent as prgContent', 'questionbanks.*')
            ->whereIn('qwId', $pqids)
            ->orderBy('paragraphs.prgId', 'ASC')
            ->get();

            // dd($pques);


            $tqno += $que->count();
            $tqno += $pques->count();

            if (!empty($que) && count($que) > 0) {
                $testSections[$count]['tsec'] = $tsec;
                $testSections[$count]['questions'] = $que;
            }

            if (!empty($pques) && count($pques) > 0) {
                $testSections[$count]['paragraphs'] = $pques;
            } else {
                $testSections[$count]['paragraphs'] = null;
            }
            
            $count++;

        }

        $ques = Exam_answer::where('testid', $testId)
        ->where('userId', Session::get('userId'))
        ->orderBy('eaId', 'ASC')
        ->get();

        $examAnswers = [];
        $qids=[];
        $ea=0;
        foreach($ques as $q){
            $qids[$ea]=$q->questionId;
            $ea++;
            $examAnswers[$q->questionId]['remarks'] = $q->remarks;
            $examAnswers[$q->questionId]['answer'] = $q->answer;
        }


       
//        dd($resultId);
        return view('Student/testAnswers',['tsts'=>$data, 'tsecs'=>$tsecs, 'testSections'=>$testSections, 'tqns'=>$tqno, 'ress'=>$result, 'examAnswers'=>$examAnswers, 'qids'=>$qids]);
    }


    function reportQuestion(Request $req){
        $rt = new Questionreport;
        $rt->testId= $req->testId;
        $rt->questionId= $req->questionId;
        $rt->rpContent= $req->report;
        $rt->userId = Session::get('userId');
//        dd('Question reported');
        $rt->save();
        return 'Success';
    }



}
