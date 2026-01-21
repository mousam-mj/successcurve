<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
// use Session;
use App\Subject;
use App\User;
use App\Classe;
use App\Testcatogerie;
use App\Subjecttopic;
use App\Instruction;
use App\Questionbank;
use App\Questiontag;
use App\Questionreport;
use App\Testquestion;
use App\Testsection;
use App\Test;
use App\Testenroll;
use App\Tsenroll;
use App\Purchasetest;
use App\Coupon;
use App\Couponenroll;
use App\Imports\QuestionImport;
use App\Exports\testUserExport;
use App\Exports\TestSeriesUserExport;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;
use Razorpay\Api\Api;
use Razorpay\Api\Errors\SignatureVerificationError;
use PDF;

class TestController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */


    function mockTests(){
        $cls = Classe::get();

        $classes = [];
        $i = 0;
        foreach($cls as $cl){
            $tss = Test::join('subjects', 'tests.tSubject', '=', 'subjects.subjectId')
            ->join('classes', 'tests.tClass', '=', 'classes.classId')
            ->join('users', 'tests.created_by', '=', 'users.id')
            ->select('tests.*', 'subjects.subjectName as subjectName', 'classes.className as className', 'users.name as name', 'users.image as instructorImage')
            ->where('tClass', $cl->classId)
            ->where('tStatus', 1)
            ->orderBy('tId', 'desc')
            ->take(8)
            ->get();
            
            if (!empty($tss) && count($tss) > 0) {
                $classes[$i]['class'] = $cl;
                $classes[$i]['tests'] = $tss;
                $i++;
            }
        }

        return View('mockTest',['classes'=>$classes]);
    }

    function mockTestByClass($id){
        $cls = Classe::where('classId', $id)->first();
        
        $tss = Test::join('subjects', 'tests.tSubject', '=', 'subjects.subjectId')
            ->join('classes', 'tests.tClass', '=', 'classes.classId')
            ->join('users', 'tests.created_by', '=', 'users.id')
            ->select('tests.*', 'subjects.subjectName as subjectName', 'classes.className as className', 'users.name as name', 'users.image as instructorImage')
            ->where('tClass', $id)
            ->where('tStatus', 1)
            ->orderBy('tId', 'desc')
            ->paginate(12);
        return view("Exam.allMockTest", ["class"=>$cls, 'subject'=> null, 'tests'=>$tss]);
    }

    function mockTestFilter(Request $req){
        $cid = 0;
        // dd($req->cls);
        if ($req->cls != null && $req->cls > 0 && $req->subject != null) {
            
            $cid = $req->cls;
            Session::put('clsId', $req->cls);
        } elseif (Session::get('clsId')) {
            $cid = Session::get('clsId');
        }
        
        
        $sid = $req->subject;
        if ($req->cls != null && $req->subject > 0 && $req->subject != null) {
            $sid = $req->subject;
            Session::put('subId', $req->subject);
        } elseif (Session::get('subId')) {
            $sid = Session::get('subId');
        }

        $cls = null;
        $tss=null;
        $subject = null;
        if($cid>0 && $sid>0 ){
            $cls = Classe::where('classId', $cid)->first();
            $subject = Subject::where('subjectId', $sid)->first();

            $tss = Test::join('subjects', 'tests.tSubject', '=', 'subjects.subjectId')
                ->join('classes', 'tests.tClass', '=', 'classes.classId')
                ->join('users', 'tests.created_by', '=', 'users.id')
                ->select('tests.*', 'subjects.subjectName as subjectName', 'classes.className as className', 'users.name as name', 'users.image as instructorImage')
                ->where('tClass', $cid)
                ->where('tSubject', $sid)
                ->where('tStatus', 1)
                ->orderBy('tId', 'desc')
                ->paginate(12);
        }elseif($cid>0 && $sid == 0){
            $cls = Classe::where('classId', $cid)->first();

            $tss = Test::join('subjects', 'tests.tSubject', '=', 'subjects.subjectId')
                ->join('classes', 'tests.tClass', '=', 'classes.classId')
                ->join('users', 'tests.created_by', '=', 'users.id')
                ->select('tests.*', 'subjects.subjectName as subjectName', 'classes.className as className', 'users.name as name', 'users.image as instructorImage')
                ->where('tClass', $cid)
                ->where('tStatus', 1)
                ->orderBy('tId', 'desc')
                ->paginate(12);
        }elseif($cid == 0 && $sid > 0){
            // $cls = Classe::get();

            $subject = Subject::where('subjectId', $sid)->first();

            $tss = Test::join('subjects', 'tests.tSubject', '=', 'subjects.subjectId')
                ->join('classes', 'tests.tClass', '=', 'classes.classId')
                ->join('users', 'tests.created_by', '=', 'users.id')
                ->select('tests.*', 'subjects.subjectName as subjectName', 'classes.className as className', 'users.name as name', 'users.image as instructorImage')
                ->where('tSubject', $sid)
                ->where('tStatus', 1)
                ->orderBy('tId', 'desc')
                ->paginate(12);
        }elseif($cid == 0 && $sid == 0){
            // $cls = Classe::get();

            $tss = Test::join('subjects', 'tests.tSubject', '=', 'subjects.subjectId')
                ->join('classes', 'tests.tClass', '=', 'classes.classId')
                ->join('users', 'tests.created_by', '=', 'users.id')
                ->select('tests.*', 'subjects.subjectName as subjectName', 'classes.className as className', 'users.name as name', 'users.image as instructorImage')
                ->where('tStatus', 1)
                ->orderBy('tId', 'desc')
                ->paginate(12);
        }

         return View("Exam.allMockTest",['tests'=>$tss, 'class'=>$cls, 'subject'=>$subject, 'cids'=>$cid, 'sids'=>$sid]);
//        dd('c = '.$cid.' s= '.$sid);
    }


    function createTc(){
        $tc = Testcatogerie::get();
        return view('Admin/createTC', ['tcs'=>$tc,'success'=>'Create Test Series']);
    }

    public function filterTestSeries(Request $req){
        $testSeries = Testcatogerie::where("tcStatus","!=", 2);

        if ($req->fcls > 0) {
            $testSeries = $testSeries->where('tcClass', $req->fcls);
        }

        // if ($req->subject > 0) {
        //     $testSeries = $testSeries->where('tcSubject', $req->subject);
        // }

        $testSeries = $testSeries->get();

        return view('Admin/createTC', ['tcs'=>$testSeries,'success'=>'Filtered Test Series']);
    }

    public function activateTS($id){
        $tss = Testcatogerie::where('tcId', $id)->first();
        if(!empty($tss)){
            $tss->tsStatus = 1;
            $tss->save();

            return back()->with('success', 'Test Series Activated..');
        }else{
            return back()->with('errors', 'Invalid Test Series Id..!');
        }
    }
    
    public function deactivateTS($id){
        $tss = Testcatogerie::where('tcId', $id)->first();
        if(!empty($tss)){
            $tss->tsStatus = 0;
            $tss->save();

            return back()->with('success', 'Test Series Deactivated..');
        }else{
            return back()->with('errors', 'Invalid Test Series Id..!');
        }
    }

    public function removeTS($id){
        $tss = Testcatogerie::where('tcId', $id)->first();
        if(!empty($tss)){
            $tss->tsStatus = 2;
            $tss->save();

            return back()->with('success', 'Test Series Removed..');
        }else{
            return back()->with('errors', 'Invalid Test Series Id..!');
        }
    }

    public function tsUsers($id){
        $tss = Testcatogerie::where('tcId', $id)->first();
        if(!empty($tss)){
            $users = Tsenroll::join('users', 'users.id', '=', 'tsenrolls.uId')->select('users.name as userName', 'users.email as userEmail','users.contact as userContact', 'tsenrolls.updated_at')->where('tsId', $id)->get();
            return view('Admin/tests/testSeriesUsers',['users'=>$users, 'tss'=>$tss]);
        }else{
            return back()->with('errors', 'Invalid Test Series Id..!');
        }
    }
    
    public function exportTestSeriesUsers($id){
        return Excel::download(new TestSeriesUserExport($id), 'testSeriesUsers.xlsx');
    }

    function addTc(Request $req){
        $tc = new Testcatogerie;
        $tc->tcName = $req->input('name');
        $tc->tcClass = $req->input('cls');
        if($req->input('isPaid') == 1){
            $tc->tcType = $req->input('isPaid');
            $tc->tcPrice = $req->input('cost');
            $tc->tcValidity = $req->input('validity');
        }

        $tc->tcDescription = $req->input('description');
        $tc->tcKeywords = $req->input('keywords');
        $tc->tcMetaDesc = $req->input('metadescription');

        $tc->tcStartDate = $req->input('startDate');
        $tc->tcEndDate = $req->input('endDate');
        $tc->created_by = Session::get('auserId');

        if($req->hasFile('image')){
            $image = $req->file('image');
            $dir = public_path('/imgs/TestCatogery');
            $imageName = $image->getClientOriginalName();
            $imageNewName = time().'.'.$imageName;
            $image->move($dir, $imageNewName);
            $path = 'imgs/TestCatogery/'.$imageNewName;
        }
        $tc->tcImage = $path;
        $tc->save();
        $success= 'Test Series Is  Added Successfully';
        $tc = Testcatogerie::get();
        return view('Admin/createTC', ['tcs'=>$tc, 'success'=>$success]);
    }
    function updateTc(Request $req){
        $tcId = $req->input('utcid');
        //dd($tcId);
        $tc = Testcatogerie::where('tcId', $tcId)->first();

        $tc->tcName = $req->input('uname');
         $tc->tcClass = $req->input('ucls');
        if($req->input('uisPaid') == 1){
            $tc->tcType = $req->input('uisPaid');
            $tc->tcPrice = $req->input('ucost');
            $tc->tcValidity = $req->input('validity');
        }

       
        $tc->tcDescription = $req->input('udescription');
        if($req->input('ukeywords')){
            $tc->tcKeywords = $req->input('ukeywords');
        }
        if($req->input('umetadescription')){
            $tc->tcMetaDesc = $req->input('umetadescription');
        }
        if($req->hasFile('uimage')){
            $image = $req->file('uimage');
            $dir = public_path('/imgs/TestCatogery');
            $imageName = $image->getClientOriginalName();
            $imageNewName = time().'.'.$imageName;
            $image->move($dir, $imageNewName);
            $path = 'imgs/TestCatogery/'.$imageNewName;

            $tc->tcImage = $path;
        }
        
        $tc->save();

        return redirect('admin/createTC')->with('success','Test Series Is  Updated Successfully');
    }


    function subjectMaster(){
        $tc = Subject::get();
        return view('Admin/subjectMaster', ['tcs'=>$tc, 'success'=>'Add Subject']);
    }
    function addSM(Request $req){
        $data = new Subject;
        $data->subjectName = $req->input('name');
        if($req->hasFile('image')){
            $image = $req->file('image');
            $dir = public_path('/imgs/subjects');
            $imageName = $image->getClientOriginalName();
            $imageNewName = time().'.'.$imageName;
            $image->move($dir, $imageNewName);
            $path = 'imgs/subjects/'.$imageNewName;
        }
        $data->thumbnail = $path;
        $data->save();
        $tc = Subject::get();
        return view('Admin/subjectMaster', ['tcs'=>$tc, 'success'=>'Subject Added Successfully!!']);
    }
    function updateSM(Request $req){
        $tcId = $req->input('utcid');
        //dd($tcId);
        $tc = Subject::where('subjectId', $tcId)->first();

        $tc->subjectName = $req->input('uname');
        if($req->hasFile('uimage')){
            $image = $req->file('uimage');
            $dir = public_path('/imgs/subjects');
            $imageName = $image->getClientOriginalName();
            $imageNewName = time().'.'.$imageName;
            $image->move($dir, $imageNewName);
            $path = 'imgs/subjects/'.$imageNewName;
        }else{
            $path = $req->input('uimageprev');
        }
        $tc->thumbnail = $path;
        $tc->save();

        $tc = Subject::get();
        $success= 'Subject Is  Updated Successfully';
        return view('Admin/subjectMaster', ['tcs'=>$tc, 'success'=>$success]);
    }

    function classes(){
        $tc = Classe::get();
        return view('Admin/classes', ['tcs'=>$tc, 'success'=>'Add Classes']);
    }
    function addClass(Request $req){
        $data = new Classe;
        $data->className = $req->input('name');
        $data->save();
        $tc = Classe::get();
        return view('Admin/classes', ['tcs'=>$tc, 'success'=>'Class Added Successfully!!']);
    }
    function updateClass(Request $req){
        $tcId = $req->input('utcid');
        //dd($tcId);
        $tc = Classe::where('classId', $tcId)->first();

        $tc->className = $req->input('uname');

        $tc->save();

        $tc = Classe::get();
        $success= 'Class Is  Updated Successfully';
        return view('Admin/classes', ['tcs'=>$tc, 'success'=>$success]);
    }
    function deleteClass($id){
        $tc = Classe::where('classId', $id)->delete();
        $tc = Classe::get();
        $success= 'Class Is  Deleted Successfully';
        return view('Admin/classes', ['tcs'=>$tc, 'success'=>$success]);
    }

    function subjectTopic(){

        $tc = Subjecttopic::join('subjects', 'subjecttopics.subjectId', '=', 'subjects.subjectId')
            ->select('subjecttopics.*', 'subjects.subjectName as subjectName')
            ->get();
        return view('Admin/subjectTopic', ['tcs'=>$tc, 'success'=>'Add Subject Topic']);
    }
    function addST(Request $req){


        $st = new Subjecttopic;
        $st->stName = $req->input('name');
        // dd($req->input('subject'));
        $st->subjectId = $req->input('subject');
        $st->save();



        $st = Subjecttopic::join('subjects', 'subjecttopics.subjectId', '=', 'subjects.subjectId')
            ->select('subjecttopics.*', 'subjects.subjectName as subjectName')
            ->get();
        $success= 'Subject Topic Is  Added Successfully';
        return view('Admin/subjectTopic', ['tcs'=>$st, 'success'=>$success]);
    }
    function updateST(Request $req){
        $sid = $req->input('uid');
        // dd($sid);
        $st = Subjecttopic::where('stId', $sid)->first();
        // dd($st);
        $st->stName =  $req->input('uname');
        $st->subjectId = $req->input('usubject');
        $st->save();
        $st = Subjecttopic::join('subjects', 'subjecttopics.subjectId', '=', 'subjects.subjectId')
            ->select('subjecttopics.*', 'subjects.subjectName as subjectName')
            ->get();
        $success= 'Subject Topic Is  Updated Successfully';
        return view('Admin/subjectTopic', ['tcs'=>$st, 'success'=>$success]);
    }
    function instructions(Request $req){
        $ins = Instruction::get();
        $success= 'Test Instructions';
        return view('Admin/instructions', ['ins'=>$ins, 'success'=>$success]);
    }
    function addIns(Request $req){
        $ins = new Instruction;
        $ins->inTitle = $req->input('name');
        $ins->inDescription = $req->input('description');
        $ins->save();
        $ins = Instruction::get();
        $success= 'Test Instructions Added Successfully';
        return view('Admin/instructions', ['ins'=>$ins, 'success'=>$success]);
    }
    function updateIns(Request $req){
        $in = $req->input('insid');
        $ins = Instruction::where('inId', $in)->get();
        return view('Admin/updateInstructions', ['ins'=>$ins]);
    }
    function updateInstruction(Request $req){
        $in = $req->input('id');
        $ins = Instruction::where('inId', $in)->first();
        $ins->inTitle = $req->input('name');
        $ins->inDescription = $req->input('description');
        $ins->save();
        $ins = Instruction::get();
        $success="Test Instruction Updated Successfully";
        return view('Admin/instructions', ['ins'=>$ins, 'success'=>$success]);
    }
    function getInstructions(){
        $data = Instruction::get();
        return json_encode(array('data'=>$data));
    }
    function tests(){

        if (Session::get('auserId')) {
            $tc = Test::where('tStatus', '!=', 2)->get();

            return view('Admin/tests', ['ts'=>$tc, 'success'=>'Create Test']);
        } elseif(Session::get('fuserId')) {
            $tc = Test::where('created_by', Session::get('fuserId'))->where('tStatus', '!=', 2)->get();

            return view('Faculty/tests/tests', ['ts'=>$tc, 'success'=>'Create Test']);
        }
        
    }

    public function filterTests(Request $req) {
        $tc = Test::where('tStatus', '!=', 2);

        if ($req->cls > 0) {
            $tc = $tc->where('tClass', $req->cls);
        }

        if ($req->subject > 0) {
            $tc = $tc->where('tSubject', $req->subject);
        }

        if (Session::get('fuserId')) {
            $tc = $tc->where('created_by', Session::get('fuserId'));
        }

        $tc = $tc->get();

        if (Session::get('auserId')) {
            return view('Admin/tests', ['ts'=>$tc, 'success'=>'Filtered Test']);
        } elseif(Session::get('fuserId')) {
            return view('Faculty/tests/tests', ['ts'=>$tc, 'success'=>'Filtered Test']);
        } 
    }

    public function generateTestURI(){
        $tc = Test::select('tId')->get();

        foreach($tc as $t){
            $cors = Test::where('tId', $t->tId)->first();

            $cors->tURI = str_replace(' ', '-', $cors->tName);

            $cors->save();
        }

        dd("Tests URI generated");
    }

    function addTest(Request $req){
        $test = new Test;
        $test->tName = $req->input('name');
        $test->tURI = $req->input('uri');
        $test->tClass = $req->input('cls');
        $test->tSubject = $req->input('subject');
        $test->ipId = $req->input('instructions');
        $test->duration = $req->input('duration');
        $test->is_paid = $req->input('isPaid');
        if($req->input('isPaid') == 1){
            $test->tPrice = $req->input('cost');
            $test->tValidity = $req->input('validity');
        }

        $test->publish_result_immediately = $req->input('publish');
        $test->description = $req->input('description');
        $test->start_date = $req->input('startDate');
        $test->end_date = $req->input('endDate');

        if (Session::get('auserId')) {
            $test->created_by = Session::get('auserId');
        } elseif(Session::get('fuserId')) {
            $test->created_by = Session::get('fuserId');
        }

        if($req->hasFile('image')){
            $image = $req->file('image');
            $dir = public_path('/imgs/tests');
            $imageName = $image->getClientOriginalName();
            $imageNewName = time().'.'.$imageName;
            $image->move($dir, $imageNewName);
            $path = 'imgs/tests/'.$imageNewName;
        }else{
            $path = 'imgs/tests/dummy.jpg';
        }
        $test->tImage = $path;

        if($req->metakey){
            $test->tMetaKey = $req->metakey;
        }else{
            $test->tMetaKey = 'Default Test Meta Keyword Here';
        }
        if($req->metadesc){
            $test->tMetaDesc = $req->metadesc;
        }else{
            $test->tMetaDesc = 'Default Test Meta Description Here';
        } 
        $test->save();
        $test = Test::get();
        //dd($test);

        if (Session::get('auserId')) {
            return redirect('admin/tests');
        } elseif(Session::get('fuserId')) {
            return redirect('faculty/tests');
        }
        
    }

    function updateTest($id){
        $test = Test::where('tId', $id)->first();

        if (Session::get('auserId')) {
            return View('Admin/updateTest', ['tests'=>$test]);
        } elseif(Session::get('fuserId')) {
            return View('Faculty/tests/updateTest', ['tests'=>$test]);
        }
    }

    function updateTestContent(Request $req){
        $test = Test::where('tId', $req->tid)->first();
        $test->tName = $req->input('name');
        $test->tClass = $req->input('cls');
        $test->tSubject = $req->input('subject');
        $test->ipId = $req->input('instructions');
        $test->duration = $req->input('duration');
        $test->is_paid = $req->input('isPaid');
        
        if ($req->input('isPaid') == 1) {
            $test->tPrice = $req->input('cost');
            $test->tValidity = $req->input('validity');
        } else {
            $test->tPrice = NULL;
            $test->tValidity = NULL;
        }

        $test->publish_result_immediately = $req->input('publish');
        $test->description = $req->input('description');

        if ($req->input('startDate')) {
            $test->start_date = $req->input('startDate');
        }

        if ($req->input('endDate')) {
            $test->end_date = $req->input('endDate');
        }

        if($req->hasFile('image')){
            $image = $req->file('image');
            $dir = public_path('/imgs/tests');
            $imageName = $image->getClientOriginalName();
            $imageNewName = time().'.'.$imageName;
            $image->move($dir, $imageNewName);
            $path = 'imgs/tests/'.$imageNewName;
            $test->tImage = $path;
        }

        if($req->metakey){
            $test->tMetaKey = $req->metakey;
        }

        if($req->metadesc){
            $test->tMetaDesc = $req->metadesc;
        }

        $test->save();
        $test = Test::get();
        //dd($test);

        if (Session::get('auserId')) {
            return redirect('admin/tests')->with('success', 'Test Updated Successfully!!');
        } elseif(Session::get('fuserId')) {
            return redirect('faculty/tests')->with('success', 'Test Updated Successfully!!');
        }
    }

    public function activateTest($id){
        $test = Test::where('tId', $id)->first();

        if(!empty($test)){
            $test->tStatus = 1;
            $test->save();

            return back()->with('success', 'Test Activated Successfully..');
        }else{
            return back()->with('errors', 'Invalid Test Id..!!');
        }
    }

    public function deactivateTest($id){
        $test = Test::where('tId', $id)->first();

        if(!empty($test)){
            $test->tStatus = 0;
            $test->save();

            return back()->with('success', 'Test Deactivated Successfully..');
        }else{
            return back()->with('errors', 'Invalid Test Id..!!');
        }
    }

    public function removeTest($id){
        $test = Test::where('tId', $id)->first();

        if(!empty($test)){
            $test->tStatus = 2;
            $test->save();
            
            return back()->with('success', 'Test Removed Successfully..');
        }else{
            return back()->with('errors', 'Invalid Test Id..!!');
        }
    }

    public function testUsers($id){
        $test = Test::where('tId', $id)->first();

        if(!empty($test)){
            $users = Testenroll::join('users', 'users.id', '=', 'testenrolls.userId')->select('users.id as userId', 'users.name as userName', 'users.contact as userContact', 'users.email as userEmail')->where('testId', $id)->get();

            if (Session::get('auserId')) {
                return view('Admin/tests/testUsers', ['users'=>$users, 'tests'=>$test]);
            } elseif(Session::get('fuserId')) {
                return view('Faculty/tests/testUsers', ['users'=>$users, 'tests'=>$test]);
            }
        }else{
            return back()->with('errors', 'Invalid Test Id..!!');
        }
    }

    public function exportTestUsers($id){
        return Excel::download(new testUserExport($id), 'users.xlsx');
    }

    public function testQuestions($id){
        $data = Test::where('tId', $id)
            ->first();

        $tsecs = Testsection::where('testId', $id)->get();

        $count = 0;
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
              
            // dd($que);
            // die();

        }

        return view('Admin/tests/testQuestions',['tsts'=>$data, 'tsecs'=>$tsecs, 'questionModels'=>$testSections]  );
    }

    public function exportTestQuestions($id){
        $data = Test::where('tId', $id)
            ->first();

        $tsecs = Testsection::where('testId', $id)->get();

        $count = 0;
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
              
            // dd($que);
            // die();

        }

        // view()->share('Admin/tests/testQuestions',['questionModels'=>$testSections]);
        $pdf = PDF::loadView('Admin/tests/testQuestions', ['questionModels'=>$testSections]);
        // download PDF file with download method
        return $pdf->download('testQuestions.pdf');
    }




    function getTopics(Request $req){
        $sid = $req->input('subjectId');
        $data = Subjecttopic::where('subjectId', $sid)->get();
        return json_encode(array('data'=>$data));
    }
    function getTests(){
        $data = Test::get();
        return json_encode(array('data'=>$data));
    }


    function questionTags(){
        $tags = Questiontag::get();
        return view('Admin/questionTags', ['tags'=>$tags, 'success'=>'Add Question Tags']);
    }

    function addQuestionTag(Request $req){
        $tag = new Questiontag;
        $tag->qtName = $req->name;
        $tag->save();
        return redirect('admin/questionTags');
    }
    function updateQuestionTag(Request $req){
        $tID = $req->uid;
        $tag = Questiontag::where('qtId', $tID)->first();

        $tag->qtName = $req->uname;
        $tag->save();
        return redirect('admin/questionTags');
    }
    function deleteQuestionTag($id){
        $qt  = Questiontag::where('qtId', $id)->first();
        if(!empty($qt)){
            $qt->delete();
        }
        return redirect('admin/questionTags');
    }
    function getQuestionTags(){
        $tags = Questiontag::get();
        return json_encode(array('data'=>$tags));
    }


    function questions(Request $req){
        $ques = Questionbank::join('subjects', 'questionbanks.subjectId', '=', 'subjects.subjectId')
            ->join('classes', 'questionbanks.classId', '=', 'classes.classId')
            ->select('questionbanks.*', 'subjects.subjectName as subjectName', 'classes.className as className')
        ->orderBy('qwId', 'DESC')->get();
        return view('Admin/questions', ['ques'=>$ques, 'success'=>'Add Question']);
    }


    function downloadMCQFormat(){
        $file= public_path("\dwns\MCQ2.xlsx");
        return response()->download($file);
    }
 
    function importMCQs(Request $req){
        Excel::import(new QuestionImport, $req->file);
        return redirect('admin/questions')->with('success', 'Question Inserted Successfully!!');
    }

    function addQuestion(Request $req){
        $qw = new Questionbank;
        $qw->subjectId = $req->subject;
        $qw->topicId = $req->topic;
        $qw->classId = $req->cls;
        $qw->qwTagId = $req->tag;
        $qw->qwType = $req->questiontype;
        $qw->qwLevel = $req->level;
        $marks = $req->marks;
        $qw->qwMarks = $marks;
        $qw->is_negative_marks = $req->input('isNeg');
        if($req->input('isNeg') == 1){
            $negpercentage = $req->input('negMarks');
            $negmarks = ($marks*$negpercentage)/100;
            $negmarks = number_format($negmarks, 2);
            // dd($negmarks);
            $qw->negMarks = $negmarks;
        }
        $qw->qwTitle = $req->question;

        $totalOption = $req->totalOptions;
        $qw->totalOptions = $totalOption;
        $opt_values = [];
        $opt_keys = [];
        for($i = 0; $i< $totalOption; $i++){
            $i2 = $i+1;
            $opt_keys[$i] = 'option'.$i2;
            $opt_values[$i] = $req->input('option'.$i2);
        }
        $options = array_combine($opt_keys, $opt_values);
        $qw->qwOptions = json_encode($options);
        $qw->qwCorrectAnswer = $req->input('correctAns');
        $qw->qwStatus = 1;
        $qw->qwHint = $req->hint;
        $qw->save();

        $qt = Questiontag::where('qtID', $req->tag)->first();

        $qt->qtTotalQuestions += 1;

        $qt->save();

        return redirect('admin/questions');
    }
    function editQuestion($id){
        $qw = Questionbank::where('qwId', $id)->first();

        if ($qw->paragraphId != 0){
            return redirect('admin/qns/pr/edit/'.$id);
        } else if ($qw->qwType == "radio"){
            return redirect("admin/qns/mcq/edit/".$id);
        } else if ($qw->qwType == "checkbox"){
            return redirect("admin/qns/msq/edit/".$id);
        } else if ($qw->qwType == "nat"){
            return redirect("admin/qns/nat/edit/".$id);
        }
    }

    function updateQuestion(Request $req){
        $qw = Questionbank::where('qwId', $req->qid)->first();
        $qw->subjectId = $req->subject;
        $qw->topicId = $req->topic;
        $qw->classId = $req->cls;
        $qw->qwTagId = $req->tag;
        $qw->qwType = $req->questiontype;
        $qw->qwLevel = $req->level;
        $marks = $req->marks;
        $qw->qwMarks = $marks;
        $qw->is_negative_marks = $req->input('isNeg');
        if($req->input('isNeg') == 1){
            $negpercentage = $req->input('negMarks');
            $negmarks = ($marks*$negpercentage)/100;
            $negmarks = number_format($negmarks, 2);
            //  dd($negmarks);
            $qw->negMarks = $negmarks;
        }
        $qw->qwTitle = $req->question;

        $totalOption = $req->totalOptions;
        $qw->totalOptions = $totalOption;
        $opt_values = [];
        $opt_keys = [];
        for($i = 0; $i< $totalOption; $i++){
            $i2 = $i+1;
            $opt_keys[$i] = 'option'.$i2;
            $opt_values[$i] = $req->input('option'.$i2);
        }
        $options = array_combine($opt_keys, $opt_values);
        $qw->qwOptions = json_encode($options);
        $qw->qwCorrectAnswer = $req->input('correctAns');
        $qw->qwStatus = 1;
        $qw->qwHint = $req->hint;
        $qw->save();

        $qt = Questiontag::where('qtID', $req->tag)->first();

        $qt->qtTotalQuestions += 1;

        $qt->save();

        return redirect('admin/questions');
    }

    function testSection($id){
        $ts = Testsection::where('testId', $id)->get();

        if (Session::get('auserId')) {
            return view('Admin/testSections',['tcs'=>$ts,'tids'=>$id, 'success'=>'Test Sections']);
        } elseif(Session::get('fuserId')) {
            return view('Faculty/tests/testSections',['tcs'=>$ts,'tids'=>$id, 'success'=>'Test Sections']);
        }
        
    }
    function addTestSection(Request $req){
        $ts = new Testsection;
        $ts->testId = $req->test;
        $ts->tsecName = $req->name;
        $ts->tsMarks = $req->marks;
        $ts->tsNegMarks = $req->negmarks;
        $ts->save();

        if (Session::get('auserId')) {
            return redirect('admin/testSection/'.$req->test);
        } elseif(Session::get('fuserId')) {
            return redirect('faculty/testSection/'.$req->test);
        }
       
    }
    function updateTestSection(Request $req){
        $tsId = $req->tsId;
        $ts = Testsection::where('tsecId', $tsId)->first();
        $tid = $ts->testId;
        $ts->tsecName = $req->uname;
        $ts->tsMarks = $req->umarks;
        $ts->tsNegMarks = $req->unegmarks;
        $ts->update();
       
        if (Session::get('auserId')) {
            return redirect('admin/testSection/'.$tid);
        } elseif(Session::get('fuserId')) {
            return redirect('faculty/testSection/'.$tid);
        }
    }

    function sectionQuestion($id){
        $tsec = Testsection::where('tsecId', $id)->first();
        $ques = Testquestion::join('questionbanks', 'testquestions.questionId', '=', 'questionbanks.qwId')
            ->select('questionbanks.*')
            ->where('tsecId', $id)
            ->orderBy('tqId', 'asc')
            ->get();

        if (Session::get('auserId')) {
            return view('Admin/sectionQuestion', ['tsecs'=>$tsec, 'ques'=>$ques, 'success'=>'Test Section Questions']);
        } elseif(Session::get('fuserId')) {
            return view('Faculty/tests/sectionQuestion', ['tsecs'=>$tsec, 'ques'=>$ques, 'success'=>'Test Section Questions']);
        }
        
    }

    function addQuestionToSection($id){
        $data =  Testsection::where('tsecId', $id)->first();
        $ques = [];

        if (Session::get('auserId')) {
            return view('Admin/addQuestionToSection',['tcs'=>$data,'ques'=>$ques, 'success'=>'Add Question to Test']);
        } elseif(Session::get('fuserId')) {
            return view('Faculty/tests/addQuestionToSection',['tcs'=>$data,'ques'=>$ques, 'success'=>'Add Question to Test']);
        }
    }

    function getTopicQuestions(Request $req){
        
        $tques = Testquestion::select('questionId')->where('tsecId', $req->tsecId)->get();
        //dd('questions '.$tques);
        $qsid = [];
        $count = 0;
        foreach($tques as $qid){
            $qsid[$count++] = $qid->questionId;
        }
        //dd('questions ids '.$qsid);
        $res = [];
        // DB::enableQueryLog();
        $ques = Questionbank::where('pqbId', $req->pqbId);
        if(!empty($req->qbId)){
            $ques->where('qbId', $req->qbId);
        }
        if(!empty($req->pqtId)){
            $ques->where('pqtId', $req->pqtId);
        }
        if(!empty($req->qtId)){
            $ques->where('qtId', $req->qtId);
        }
        if(!empty($req->qlId)){
            $ques->where('qlId', $req->qlId);
        }
        if(!empty($qsid)){
            $ques->whereNotIn('qwId', $qsid);
        }
        if(!empty($req->qtype)){
            if($req->qtype == 'mcq'){
                $ques->where('qwType', 'radio')->where('paragraphId', 0);
            }elseif($req->qtype == 'msq'){
                $ques->where('qwType', 'checkbox')->where('paragraphId', 0);
            }elseif($req->qtype == 'nat'){
                $ques->where('qwType', 'nat')->where('paragraphId', 0);
            }elseif($req->qtype == 'prq'){
                $ques->where('paragraphId', '!=',0);
            }
        }
        
        $res = $ques->get();
        return json_encode(array('data'=>$res));
    }

    function getTopicQuestionsByTag(Request $req){

        $tagId = $req->tagId;
        $tques = Testquestion::select('questionId')->where('qwTagId', $tagId)->get();
//        dd('questions '.$tques);
        $qsid = [];
        $count = 0;
        foreach($tques as $qid){
            $qsid[$count++] = $qid->questionId;
        }
//        dd('questions ids '.$qsid);
        $ques = [];
        if(empty($qsid))
        {
            $ques = Questionbank::where('qwTagId', $tagId)
            ->orderBy('qwId','ASC')
            ->get();
        }
        else{
            $ques = Questionbank::where('qwTagId', $tagId)->whereNotIn('qwId', $qsid)
            ->orderBy('qwId','ASC')
            ->get();
        }

        return json_encode(array('data'=>$ques));
    }
    function addSectionQuestion(Request $req){

        $alqws = Testquestion::where('tsecId', $req->tsecId)->where('questionId', $req->qid)->first();

        if(empty($alqws)){

            $tqs = Questionbank::where('qwId', $req->qid)->first();
            //dd($tqs->qwMarks);
            $tst = Test::where('tId', $req->testId)->first();
            $tsec = Testsection::where('tsecId', $req->tsecId)->first();
            $tst->total_marks += $tsec->tsMarks;
            $tst->total_questions += 1;
            $tst->save();

            $tq = new Testquestion;
            $tq->testId = $req->testId;
            $tq->tsecId = $req->tsecId;
            $tq->questionId = $req->qid;
            $tq->save();
            $data = [
                'data'=> '1',
                'msg'=> 'Question Added Successfully',
            ];
            return json_encode(array('data'=>$data));
        }else{
            $data = [
                'data'=> '2',
                'msg'=> 'Question Already Added',
            ];
            return json_encode(array('data'=>$data));
        }
    }

    function removeSectionQuestion($qid,$tsecid){
        $tsec = Testsection::where('tsecId', $tsecid)->first();

        $ques = Questionbank::where('qwId', $qid)->first();

        $test = Test::where('tId', $tsec->testId)->first();

        $test->total_marks -= $tsec->tsMarks;
        $test->total_questions -=1;
        $test->save();

        $qw = Testquestion::where('questionId',$qid)->where('tsecid',$tsecid)->delete();

        if (Session::get('auserId')) {
            return redirect('admin/sectionQuestion/'.$tsecid);
        } elseif(Session::get('fuserId')) {
            return redirect('faculty/sectionQuestion/'.$tsecid);
        }
    }

    function questionReports(){
        $reports = Questionreport::join('questionbanks', 'questionreports.questionId', '=', 'questionbanks.qwId')
            ->select('questionreports.*', 'questionbanks.qwTitle as qwTitle', 'questionbanks.qwId as qwId', )
            ->orderBy('rpId', 'DESC')
            ->get();

        if (Session::get('auserId')) {
            return view('Admin/questionReports', ['reports'=>$reports]);
        } elseif(Session::get('fuserId')) {
            return view('Faculty/tests/questionReports', ['reports'=>$reports]);
        }
        
    }
    function deleteReport($id){
        Questionreport::where('rpId', $id)->delete();
       

        if (Session::get('auserId')) {
            return redirect('admin/questionReports')->with('success', 'Issue Removed!');
        } elseif(Session::get('fuserId')) {
            return redirect('faculty/questionReports')->with('success', 'Issue Removed!');
        }
    }

    public function purchaseTest(Request $req){
        $test =  Test::join('users', 'tests.created_by', '=', 'users.id')
        ->select('tests.*', 'users.name as userName', 'users.image as instructorImage')
        ->where('tId', $req->testId)
        ->orderBy('tId', 'desc')
        ->first();

        if(!empty($test) && $test->tPrice != null && $test->tPrice > 0){
            $buyc = Purchasetest::where('testId', $req->testId)->where('userId', Session::get('userId'))->where('paymentStatus', 0)->first();
            
            $data = [];

            /*
                - Check Coupon code is entered or not.
                - Check whether the coupon code is expired or not.
                - check coupon code uses type 
                - check coupon code use limit
                - check coupon code have used erlier or not.
            */

            $isValidCoupon = false;
            $coupon = null;
            if ($req->couponCode != null && $req->couponCode != '') {

                $coupon = Coupon::where('cpCode', $req->couponCode)->first();
                if (!empty($coupon) && $coupon->expires_at > Carbon::now()){

                    if ($coupon->cpFor == 1 || $coupon->cpFor == 3) {

                        $cenroll = Couponenroll::where('userId', Session::get('userId'))->where('cpId', $coupon->cpId)->count();
                        if ($cenroll < $coupon->cpLimit) {
                            
                            $isValidCoupon = true;
                        }
                    }
                    
                }   
            }

            if(!empty($buyc)){
                if ($isValidCoupon) {
                    // dd('valid coupon');
                    if ($buyc->couponCode != null && $buyc->couponCode == $req->couponCode && $buyc->created_at > $test->updated_at) {

                        // if the coupon code was applied erlier and now are same  

                        $data = [
                            'orderId'=>$buyc->orderId,
                            'amount' => $buyc->amount,
                            'name'=>$test->tName,
                            'key'=>config("razor.razor_key"),
                        ];
                    } else{

                        // if the coupon code was applied erlier and now are not same 

                        $amount = $test->tPrice - floor(($test->tPrice * $coupon->cpDiscount) / 100);
                        
                        $api = new Api(config('razor.razor_key'), config('razor.razor_secret'));
                        $order  = $api->order->create(array('receipt' => '123', 'amount' => $amount * 100 , 'currency' => 'INR')); // Creates order
                        $orderId = $order['id'];

                        $pur = new Purchasetest();
                        $pur->userId = Session::get('userId');
                        $pur->testId = $req->testId;
                        $pur->couponCode = $req->couponCode;
                        $pur->amount = $amount;
                        $pur->orderId = $orderId;
                        $pur->save();
                        $data = [
                            'orderId'=>$orderId,
                            'amount' => $amount,
                            'name'=>$test->tName,
                            'key'=>config("razor.razor_key"),
                        ];
                    }
                } else {
                    // dd('invalid coupon');
                    // if the coupon code was in not valid

                    if ($buyc->couponId == null && $buyc->created_at > $test->updated_at) {

                        // if the coupon code is & was not applied

                        $data = [
                            'orderId'=>$buyc->orderId,
                            'amount' => $buyc->amount,
                            'name'=>$test->tName,
                            'key'=>config("razor.razor_key"),
                        ];
                    } else{
                        $amount = $test->tPrice;
                        
                        $api = new Api(config('razor.razor_key'), config('razor.razor_secret'));
                        $order  = $api->order->create(array('receipt' => '123', 'amount' => $amount * 100 , 'currency' => 'INR')); // Creates order
                        $orderId = $order['id'];

                        $pur = new Purchasetest();
                        $pur->userId = Session::get('userId');
                        $pur->testId = $req->testId;
                        $pur->amount = $amount;
                        $pur->orderId = $orderId;
                        $pur->save();
                        $data = [
                            'orderId'=>$orderId,
                            'amount' => $amount,
                            'name'=>$test->tName,
                            'key'=>config("razor.razor_key"),
                        ];
                    }
                }
                
            }else{
                
                // dd($pck);
                 $amount = $test->tPrice;
                
                 if($isValidCoupon){
                    $amount = $test->tPrice - floor(($test->tPrice * $coupon->cpDiscount) / 100);
                }
                
                $api = new Api(config('razor.razor_key'), config('razor.razor_secret'));
                $order  = $api->order->create(array('receipt' => '123', 'amount' => $amount * 100 , 'currency' => 'INR')); // Creates order
                $orderId = $order['id'];

                $pur = new Purchasetest();
                $pur->userId = Session::get('userId');
                $pur->testId = $req->testId;

                if ($isValidCoupon) {
                    $pur->couponCode = $req->couponCode;
                }

                $pur->amount = $amount;
                $pur->orderId = $orderId;
                $pur->save();
                $data = [
                    'orderId'=>$orderId,
                    'amount' => $amount,
                    'name'=>$test->tName,
                    'key'=>config("razor.razor_key"),
                ];
            }

            // dd($test);

            // dd($data);
            return view('buyTest',['tests'=>$test, 'datas'=>$data]);
        }
    }
    public function payTest(Request $req){
        $data = $req->all();
        $testPurchase = Purchasetest::where('orderId', $data['razorpay_order_id'])->first();
        $testPurchase->paymentStatus = 1;
        $testPurchase->paymentId = $data['razorpay_payment_id'];

        $api = new Api(config('razor.razor_key'), config('razor.razor_secret'));


        try{
            $attributes = array(
                'razorpay_signature' => $data['razorpay_signature'],
                'razorpay_payment_id' => $data['razorpay_payment_id'],
                'razorpay_order_id' => $data['razorpay_order_id']
            );
            $order = $api->utility->verifyPaymentSignature($attributes);
            $success = true;
        }catch(SignatureVerificationError $e){

            $succes = false;
        }

        $testId = $testPurchase->testId;
        if($success){
            $c = Test::where('tId', $testId)->first();
            $testPurchase->expires_at = carbon::now()->addMonths($c->tValidity);
            $testPurchase->paymentType = 0;

            $testPurchase->save();

            if ($testPurchase->couponCode != null) {
                $coupon = Coupon::where('cpCode', $testPurchase->couponCode)->first();

                if (!empty($coupon)) {
                    $coupon->cpUsed += 1;
                    $coupon->save();
                }

                $cpe = new Couponenroll();
                $cpe->cpId  = $coupon->cpId;
                $cpe->userId = Session::get('userId');
                $cpe->usedFor = 2;
                $cpe->save();
            }

            $ce = new Testenroll();
            $ce->testId = $testId;
            $ce->userId = Session::get('userId');
            $ce->expires_at = carbon::now()->addMonths($c->tValidity);
            $ce->save();
            
            return redirect('exam/test/'.$testId.'/'.$c->tURI);
        }else{
            return redirect('paymentFailed');
        }
    }

    public function testPayments($id ) {
        $tests = Test::where('tId', $id)->first();
        if (!empty($tests)) {
            $pcs = Purchasetest::join('users', 'users.id', '=', 'purchasetests.userId')
            ->select('purchasetests.*', 'users.name as userName', 'users.contact as userContact')
            ->where('testId', $id)
            ->where('paymentStatus', 1)
            ->orderBy('pcId', 'desc')
            ->get();

            if (Session::get('fuserId')) {
                return view('Faculty/payments/testPayments', ['tests'=>$tests, 'pcs'=>$pcs]);
            }

            return view('Admin/payments/testPayments', ['tests'=>$tests, 'pcs'=>$pcs]);
        }
        return back()->with('errors', 'Invalid Test Id..');
    }


//    End of Controller
}






















