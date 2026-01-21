<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Http\Request;
use Validator;
use Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use App\Mail\WelcomeMail;
use App\Mail\CourseenrollMail;
use App\Mail\ForgetPasswordMail;
use App\Course;
use App\Subject;
use App\User;
use App\Classe;
use App\Week;
use App\Lecture;
use App\Courseenroll;
use App\Slider;
use App\Test;
use App\Result;
use App\Testenroll;
use App\Tsenroll;
use App\Testcatogerie;
use App\Exam_answer;
use App\Lecturequestion;
use App\Paragraph;

use App\Purchasecourse;
use App\Purchasetest;
use App\Purchasetestseries;

use Carbon\Carbon;

class SucessController extends Controller
{
    //Demo FUnction
    function index(){
        $data = Subject::get();
        $classe = Classe::get();
        $course = Course::join('subjects', 'courses.courseSubject', '=', 'subjects.subjectId')
            ->join('classes', 'courses.courseClass', '=', 'classes.classId')
            ->join('users', 'courses.courseInstructor1', '=', 'users.id')
            ->select('courses.*', 'subjects.subjectName as subjectName', 'classes.className as className', 'users.name as name', 'users.image as instructorImage')
            ->where('courseStatus', 'Published')
            ->orderBy('courseId', 'desc')
            ->take(10)
            ->get();

        $test = Test::join('subjects', 'tests.tSubject', '=', 'subjects.subjectId')
            ->join('classes', 'tests.tClass', '=', 'classes.classId')
            ->join('users', 'tests.created_by', '=', 'users.id')
            ->select('tests.*', 'subjects.subjectName as subjectName', 'classes.className as className', 'users.name as name', 'users.image as instructorImage')
            ->orderBy('tId', 'desc')
            ->take(10)
            ->get();

        $slider = Slider::where('status', 1)->get();

        $testSeries =  Testcatogerie::join('classes', 'testcatogeries.tcClass', '=', 'classes.classId')
            ->select('testcatogeries.*', 'classes.className as className')
            ->orderBy('tcId', 'DESC')
            ->take(10)
            ->get();

        return view('home',['products'=>$data, 'classes'=>$classe, 'courses'=>$course, 'sliders'=>$slider, 'tests'=>$test, 'series'=>$testSeries]);
    }
    function stuDashboard(){
        $course=[];
        $test=[];
        if(Session::get('userClass') != 0){
            $course = Course::join('subjects', 'courses.courseSubject', '=', 'subjects.subjectId')
                ->join('classes', 'courses.courseClass', '=', 'classes.classId')
                ->join('users', 'courses.courseInstructor1', '=', 'users.id')
                ->select('courses.*', 'subjects.subjectName as subjectName', 'classes.className as className', 'users.name as name', 'users.image as instructorImage')
                ->where('courseStatus', 'Published')
                ->where('courseClass', Session::get('userClass'))
                ->orderBy('courseId', 'desc')
                ->take(6)
                ->get();

            $test = Test::join('subjects', 'tests.tSubject', '=', 'subjects.subjectId')
                ->join('classes', 'tests.tClass', '=', 'classes.classId')
                ->join('users', 'tests.created_by', '=', 'users.id')
                ->select('tests.*', 'subjects.subjectName as subjectName', 'classes.className as className', 'users.name as name', 'users.image as instructorImage')
                ->where('tClass', Session::get('userClass'))
                ->orderBy('tId', 'desc')
                ->take(6)
                ->get();
        }elseif(Session::get('userClass') == 0){
            $course = Course::join('subjects', 'courses.courseSubject', '=', 'subjects.subjectId')
                ->join('classes', 'courses.courseClass', '=', 'classes.classId')
                ->join('users', 'courses.courseInstructor1', '=', 'users.id')
                ->select('courses.*', 'subjects.subjectName as subjectName', 'classes.className as className', 'users.name as name', 'users.image as instructorImage')
                ->where('courseStatus', 'Published')
                ->orderBy('courseId', 'desc')
                ->take(6)
                ->get();

            $test = Test::join('subjects', 'tests.tSubject', '=', 'subjects.subjectId')
                ->join('classes', 'tests.tClass', '=', 'classes.classId')
                ->join('users', 'tests.created_by', '=', 'users.id')
                ->select('tests.*', 'subjects.subjectName as subjectName', 'classes.className as className', 'users.name as name', 'users.image as instructorImage')
                ->orderBy('tId', 'desc')
                ->take(6)
                ->get();
        }

        $courses = Course::where('courseStatus','Published')->count();
        $tests = Test::count();
        $tenrolls = Testenroll::where('userId', Session::get('userId'))->count();
        $cenrolls = Courseenroll::where('userId', Session::get('userId'))->count();
        return view('Student/studentDashboard',['courses'=>$course, 'tests'=>$test, 'tsts'=>$tests, 'cs'=>$courses, 'cse'=>$cenrolls, 'tsen'=>$tenrolls]);

    }
    function mytests(){
        $tids = Testenroll::select('testId')->where('userId', Session::get('userId'))->get();
        $tis = [];
        $ct = 0;
        foreach($tids as $tid){
            $tis[$ct] = $tid->testId;
            $ct++;
        }


        $test = Test::join('subjects', 'tests.tSubject', '=', 'subjects.subjectId')
            ->join('classes', 'tests.tClass', '=', 'classes.classId')
            ->join('users', 'tests.created_by', '=', 'users.id')
            ->select('tests.*', 'subjects.subjectName as subjectName', 'classes.className as className', 'users.name as name', 'users.image as instructorImage')
            ->whereIn('tId', $tis)
            ->orderBy('tId', 'desc')
            ->paginate(12);
        return view('Student/tests', ['tests'=>$test]);
    }

    function getMyTestSeries(){

        $tsids = Tsenroll::select('tsId')->where('uId', Session::get('userId'))->get();
        $tis = [];
        $ct = 0;

        foreach($tsids as $tid){
            $tis[$ct] = $tid->tsId;
            $ct++;
        }

        $tss = Testcatogerie::join('classes', 'testcatogeries.tcClass', '=', 'classes.classId')
            ->select('testcatogeries.*', 'classes.className as className')
            ->whereIn('tcId', $tis)
            ->orderBy('tcId', 'DESC')
            ->paginate(12);
        return View('Student/mySeries',['tss'=>$tss]);
    }

    function testResults(){
        $results = Result::join('tests', 'results.examId', '=', 'tests.tId')
            ->select('results.*', 'tests.*')
            ->where('userId', Session::get('userId'))
            ->orderBy('resultId', 'DESC')
            ->get();
        return view('Student/testResult', ['trs'=>$results]);
    }
    function testAnswers($id){
        $result = Result::where('resultId', $id)->first();

        $testId = $result->examId;

        $ques = Exam_answer::join('questionbanks', 'exam_answers.questionId', '=', 'questionbanks.qwId')
            ->select('exam_answers.*', 'questionbanks.*')
            ->where('testid', $testId)
            ->where('userId', Session::get('userId'))
            ->orderBy('eaId', 'ASC')
            ->get();

        return view('Student/testAnswers', ['ques'=>$ques]);
    }


    function exploreByClass($id, $name){
        $crs = Course::join('subjects', 'courses.courseSubject', '=', 'subjects.subjectId')
            ->join('classes', 'courses.courseClass', '=', 'classes.classId')
            ->join('users', 'courses.courseInstructor1', '=', 'users.id')
            ->select('courses.*', 'subjects.subjectName as subjectName', 'classes.className as className', 'users.name as name', 'users.image as instructorImage')
            ->where('courseClass', $id)
            ->where('courseStatus', 'Published')
            ->orderBy('courseId', 'desc')
            ->take(8)->get();

        $test = Test::join('subjects', 'tests.tSubject', '=', 'subjects.subjectId')
            ->join('classes', 'tests.tClass', '=', 'classes.classId')
            ->join('users', 'tests.created_by', '=', 'users.id')
            ->select('tests.*', 'subjects.subjectName as subjectName', 'classes.className as className', 'users.name as name', 'users.image as instructorImage')
            ->where('tClass', $id)
            ->orderBy('tId', 'desc')
            ->take(8)->get();

        $testSeries =  Testcatogerie::join('classes', 'testcatogeries.tcClass', '=', 'classes.classId')
            ->select('testcatogeries.*', 'classes.className as className')
            ->where('tcClass', $id)
            ->orderBy('tcId', 'DESC')
            ->take(8)
            ->get();


        $cls = Classe::where('classId', $id)->first();

        return view('exploreCourseAndTest', ['courses' => $crs, 'tests'=>$test, 'testseries'=>$testSeries, 'subject'=>null, "class"=>$cls]);
    }

    public function exploreTestsByClass($id){
        $tests = Test::join('subjects', 'tests.tSubject', '=', 'subjects.subjectId')
            ->join('classes', 'tests.tClass', '=', 'classes.classId')
            ->join('users', 'tests.created_by', '=', 'users.id')
            ->select('tests.*', 'subjects.subjectName as subjectName', 'classes.className as className', 'users.name as name', 'users.image as instructorImage')
            ->where('tClass', $id)
            ->orderBy('tId', 'desc')
            ->paginate(8);

        $cls = Classe::where('classId', $id)->first();

        return view("Exam.allMockTest", ["class"=>$cls, 'subject'=> null, 'tests'=>$tests]);
    }

    public function exploreTestSeriesByClass($id){
        $testSeries =  Testcatogerie::join('classes', 'testcatogeries.tcClass', '=', 'classes.classId')
        ->select('testcatogeries.*', 'classes.className as className')
        ->where('tcClass', $id)
        ->orderBy('tcId', 'DESC')
        ->paginate(8);

        $cls = Classe::where('classId', $id)->first();

        return view('TestSeries.allTestSeries', ['testseries'=>$testSeries, 'class'=>$cls]);
    }
    
    public function exploreCoursesByClass($id){
        $crs = Course::join('subjects', 'courses.courseSubject', '=', 'subjects.subjectId')
            ->join('classes', 'courses.courseClass', '=', 'classes.classId')
            ->join('users', 'courses.courseInstructor1', '=', 'users.id')
            ->select('courses.*', 'subjects.subjectName as subjectName', 'classes.className as className', 'users.name as name', 'users.image as instructorImage')
            ->where('courseClass', $id)
            ->where('courseStatus', 'Published')
            ->orderBy('courseId', 'desc')
            ->paginate(12);

        return view('courses', ['courses' => $crs]);
    }


    function exploreBySubject($id, $name){
        $crs = Course::join('subjects', 'courses.courseSubject', '=', 'subjects.subjectId')
            ->join('classes', 'courses.courseClass', '=', 'classes.classId')
            ->join('users', 'courses.courseInstructor1', '=', 'users.id')
            ->select('courses.*', 'subjects.subjectName as subjectName', 'classes.className as className', 'users.name as name', 'users.image as instructorImage')
            ->where('courseSubject', $id)
            ->where('courseStatus', 'Published')
            ->orderBy('courseId', 'desc')
            ->take(8)->get();

        $test = Test::join('subjects', 'tests.tSubject', '=', 'subjects.subjectId')
            ->join('classes', 'tests.tClass', '=', 'classes.classId')
            ->join('users', 'tests.created_by', '=', 'users.id')
            ->select('tests.*', 'subjects.subjectName as subjectName', 'classes.className as className', 'users.name as name', 'users.image as instructorImage')
            ->where('tSubject', $id)
            ->orderBy('tId', 'desc')
            ->take(8)->get();

            $testSeries =  Testcatogerie::join('classes', 'testcatogeries.tcClass', '=', 'classes.classId')
            ->select('testcatogeries.*', 'classes.className as className')
            ->orderBy('tcId', 'DESC')
            ->take(8)
            ->get();

        $subject = Subject::where('subjectId', $id)->first();
        return view('exploreCourseAndTest', ['courses' => $crs, 'tests'=>$test, 'testseries'=>$testSeries, 'subject'=>$subject, "class"=>null]);
    }

    
    public function exploreTestsBySubject($id){
        $tests = Test::join('subjects', 'tests.tSubject', '=', 'subjects.subjectId')
            ->join('classes', 'tests.tClass', '=', 'classes.classId')
            ->join('users', 'tests.created_by', '=', 'users.id')
            ->select('tests.*', 'subjects.subjectName as subjectName', 'classes.className as className', 'users.name as name', 'users.image as instructorImage')
            ->where('tSubject', $id)
            ->orderBy('tId', 'desc')
            ->paginate(8);

        $subject = Subject::where('subjectId', $id)->first();

        return view("Exam.allMockTest", ["class"=>null, 'subject'=> $subject, 'tests'=>$tests]);
    }
    
    public function exploreCoursesBySubject($id){
        $crs = Course::join('subjects', 'courses.courseSubject', '=', 'subjects.subjectId')
            ->join('classes', 'courses.courseClass', '=', 'classes.classId')
            ->join('users', 'courses.courseInstructor1', '=', 'users.id')
            ->select('courses.*', 'subjects.subjectName as subjectName', 'classes.className as className', 'users.name as name', 'users.image as instructorImage')
            ->where('courseSubject', $id)
            ->where('courseStatus', 'Published')
            ->orderBy('courseId', 'desc')
            ->paginate(12);

        return view('courses', ['courses' => $crs]);
    }

    function showAllCourses(Request $req ){
        $data = Course::join('subjects', 'courses.courseSubject', '=', 'subjects.subjectId')
        ->join('classes', 'courses.courseClass', '=', 'classes.classId')
        ->join('users', 'courses.courseInstructor1', '=', 'users.id')
        ->select('courses.*', 'subjects.subjectName as subjectName', 'classes.className as className', 'users.name as name', 'users.image as instructorImage')
        ->where('courseStatus', 'Published')
        ->orderBy('courseId', 'desc')
        ->paginate(12);
        return view('courses', ['courses' => $data]);
    }
    function courseDetails($id, $name){

        $data = Course::join('subjects', 'courses.courseSubject', '=', 'subjects.subjectId')
            ->join('classes', 'courses.courseClass', '=', 'classes.classId')
            ->join('users', 'courses.courseInstructor1', '=', 'users.id')
            ->select('courses.*', 'subjects.subjectName as subjectName', 'classes.className as className', 'users.name as name', 'users.image as instructorImage')
            ->where('courseId', $id)
            ->orderBy('courseId', 'desc')
            ->first();

        $weeks = Week::where('courseId', $id)->get();
        $lectures = Lecture::where('courseId', $id)->get();

        $enrolls = 0;
        if(Session::get('userId')){
            $ens = Courseenroll::where('userId', Session::get('userId'))->where('courseId', $id)->orderBy('enrollId', 'desc')->first();

            if(!empty($ens)){
                if ($ens->expires_at == null){
                    $enrolls = 1;
                } else if ($ens->expires_at > Carbon::now()){
                    $enrolls = 1;
                }
            }
        }

        return view('courseDetails', ['products' => $data, 'weeks'=> $weeks, 'lectures'=>$lectures,'enrolls'=>$enrolls]);
    }
    
    function enrollCourse(Request $req){
        $courseId = $req->get('courseId');
        $ce = Courseenroll::where('courseId', $courseId)->where('userId', Session::get('userId'))->first();
        if(empty($ce)){
            if(Course::where('courseId', $courseId)->value('courseTitle')){
                $courseEnroll = new Courseenroll;
                $courseEnroll->courseId = $courseId;
                $courseEnroll->userId = Session::get('userId');
                $courseEnroll->save();
    
                $cr = Course::where('courseId', $courseId)->first();
                $cr->students +=1;
                $cname = $cr->courseTitle;
                $cr->save();
                $curl= 'https://successcurve.in/course/'.$courseId.'/'.str_replace(' ', '-', $cname);
                $data= [
                    'name'=>Session::get('user'),
                    'coursetitle'=>$cname,
                    'courseURL'=>$curl
                ];
                Mail::to(Session::get('userEmail'))->send(new CourseenrollMail($data));
    
                //module Data
                $weeks = Week::where('courseId', $courseId)->get();
                //lectures Data
                $lectures = Lecture::where('courseId', $courseId)->get();
    
                //geting first lecture id
                $firstLecture = Lecture::where('courseId', $courseId)->orderBy('lectureId', 'asc')->first();
                if(empty($firstLecture)){
                    $errors = "There is No Lecture Avialable in This Course";
                    $content = [];
                    return view('lectures', ['weeks'=> $weeks, 'lectures'=>$lectures, 'contents'=>$content, 'errors'=>$errors]);
                 
                }
                else{
                    $firstLectureId = $firstLecture->lectureId;
                    //Getting content of first lecture
                    $content = Lecture::where('lectureId', $firstLectureId)->first();
                    if($content->lectureType == '0'){
                        
                        return view('lectures', ['weeks'=> $weeks, 'lectures'=>$lectures, 'contents'=>$content]);
                    }elseif($content->lectureType == '1'){
                        
                        $que = Lecturequestion::join('questionbanks', 'lecturequestions.qId', '=', 'questionbanks.qwId')
                        ->select('lecturequestions.*', 'questionbanks.*')
                        ->where('lId', $firstLectureId)
                        ->orderBy('lqId', 'ASC')
                        ->get();
                        // $tqno = $que->count();
                        $ques = [];
                        $count = 0;
                        foreach($que as $qu){
            
                            $prid = 0;
                            $prcon = '';
                        
                            if($qu->paragraphId != 0){
                                $pr = Paragraph::where('prgId', $qu->paragraphId)->first();
                                $prid = $pr->prgId;
                                $prcon = $pr->prgContent;
                            }
                        
                            
                            $ques[$count]['qwId'] = $qu->qwId;
                            $ques[$count]['qwTitle'] = $qu->qwTitle;
                            $ques[$count]['qwOptions'] = $qu->qwOptions;
                            $ques[$count]['totalOptions'] = $qu->totalOptions;
                            $ques[$count]['qwCorrectAnswer'] = $qu->qwCorrectAnswer;
                            $ques[$count]['qwType'] = $qu->qwType;
                            $ques[$count]['qwHint'] = $qu->qwHint;
                            $ques[$count]['paragraphId'] = $prid;
                            $ques[$count]['paragraph'] = $prcon;
                            $count++;
                        }
                        dd($ques);
                        return view('lectures', ['weeks'=> $weeks, 'lectures'=>$lectures, 'contents'=>$content, 'ques'=>$ques]);
                    }
                }
    
    
                return view('lectures', ['weeks'=> $weeks, 'lectures'=>$lectures, 'contents'=>$content]);
            }
        }else{
            return redirect('goToCourse/?courseId='.$courseId);
        }  
    }

    function goToCourse(Request $req){
        $courseId = $req->get('courseId');

        if(Course::where('courseId', $courseId)->value('courseTitle')){

            //module Data
            $weeks = Week::where('courseId', $courseId)->get();
            //lectures Data
            $lectures = Lecture::where('courseId', $courseId)->get();

            //geting first lecture id
            $firstLecture = Lecture::where('courseId', $courseId)->orderBy('lectureId', 'asc')->first();
            if(empty($firstLecture)){
                $errors = "There is No Lecture Avialable in This Course";
                $content = [];
                return view('lectures', ['weeks'=> $weeks, 'lectures'=>$lectures, 'contents'=>$content, 'errors'=>$errors]);
                
            }
            else{
                $firstLectureId = $firstLecture->lectureId;
                //Getting content of first lecture
                $content = Lecture::where('lectureId', $firstLectureId)->first();
                if($content->lectureType == '0'){
                    
                    return view('lectures', ['weeks'=> $weeks, 'lectures'=>$lectures, 'contents'=>$content]);
                }elseif($content->lectureType == '1'){
                    
                    $que = Lecturequestion::join('questionbanks', 'lecturequestions.qId', '=', 'questionbanks.qwId')
                    ->select('lecturequestions.*', 'questionbanks.*')
                    ->where('lId', $firstLectureId)
                    ->orderBy('lqId', 'ASC')
                    ->get();
                    // $tqno = $que->count();
                    $ques = [];
                    $count = 0;
                    foreach($que as $qu){
        
                        $prid = 0;
                        $prcon = '';
                    
                        if($qu->paragraphId != 0){
                            $pr = Paragraph::where('prgId', $qu->paragraphId)->first();
                            $prid = $pr->prgId;
                            $prcon = $pr->prgContent;
                        }
                    
                        
                        $ques[$count]['qwId'] = $qu->qwId;
                        $ques[$count]['qwTitle'] = $qu->qwTitle;
                        $ques[$count]['qwOptions'] = $qu->qwOptions;
                        $ques[$count]['totalOptions'] = $qu->totalOptions;
                        $ques[$count]['qwCorrectAnswer'] = $qu->qwCorrectAnswer;
                        $ques[$count]['qwType'] = $qu->qwType;
                        $ques[$count]['qwHint'] = $qu->qwHint;
                        $ques[$count]['paragraphId'] = $prid;
                        $ques[$count]['paragraph'] = $prcon;
                        $count++;
                    }
                    dd($ques);
                    return view('lectures', ['weeks'=> $weeks, 'lectures'=>$lectures, 'contents'=>$content, 'ques'=>$ques]);
                }
            }
        }
    }


    function getLecture(Request $req){
        $courseId = $req->get('courseId');
        $lectureId = $req->get('lectureId');
        $weeks = Week::where('courseId', $courseId)->get();
        $lectures = Lecture::where('courseId', $courseId)->get();
        if($lectureId){
            $firstLectureId = $lectureId;
        }else{
            $firstLecture = Lecture::where('courseId', $courseId)->orderBy('lectureId', 'asc')->first();
            $firstLectureId = $firstLecture->lectureId;
        }
        $content = Lecture::where('lectureId', $firstLectureId)->first();
        if($content->lectureType == '0'){
            // dd('kaddu 00000000');
            return view('lectures', ['weeks'=> $weeks, 'lectures'=>$lectures, 'contents'=>$content]);
        }elseif($content->lectureType == '1'){
            // dd('kaddu 111111');
            $que = Lecturequestion::join('questionbanks', 'lecturequestions.qId', '=', 'questionbanks.qwId')
            ->select('lecturequestions.*', 'questionbanks.*')
            ->where('lId', $lectureId)
            ->orderBy('lqId', 'ASC')
            ->get();
            // $tqno = $que->count();
            $ques = [];
            $count = 0;
            foreach($que as $qu){

                $prid = 0;
                $prcon = '';
            
                if($qu->paragraphId != 0){
                    $pr = Paragraph::where('prgId', $qu->paragraphId)->first();
                    $prid = $pr->prgId;
                    $prcon = $pr->prgContent;
                }
            
                
                $ques[$count]['qwId'] = $qu->qwId;
                $ques[$count]['qwTitle'] = $qu->qwTitle;
                $ques[$count]['qwOptions'] = $qu->qwOptions;
                $ques[$count]['totalOptions'] = $qu->totalOptions;
                $ques[$count]['qwCorrectAnswer'] = $qu->qwCorrectAnswer;
                $ques[$count]['qwType'] = $qu->qwType;
                $ques[$count]['qwHint'] = $qu->qwHint;
                $ques[$count]['paragraphId'] = $prid;
                $ques[$count]['paragraph'] = $prcon;
                $count++;
            }
            
            return view('lectures', ['weeks'=> $weeks, 'lectures'=>$lectures, 'contents'=>$content, 'ques'=>$ques]);
        }
        
    }
    function getSubjects(){
        $subjectData = Subject::get();
        return json_encode(array('data'=>$subjectData));
    }
    function getClasses(){
        $classData = Classe::orderBy('className', 'ASC')->get();
        return json_encode(array('data'=>$classData));
    }
    function getInstructor(){
        $id = Session::get('fuserId');
        $instructorData = User::where('type', 'faculty')->where('id','!=',$id)->get();
        return json_encode(array('data'=>$instructorData));
    }
    function getCourses(){
        $courseData = Course::get();
        return json_encode(array('data'=>$courseData));
    }
    function getWeek(Request $req){
        $courseId = $req->input('courseId');
        $courseData = Week::where('courseId', $courseId)->get();
        return json_encode(array('data'=>$courseData));
    }
    function getLecs(Request $req){
        $weekId = $req->input('weekId');
        $weekData = Lecture::where('weekId', $weekId)->get();
        return json_encode(array('data'=>$weekData));
    }




    //User Registration
    function register(Request $req){
        
        $user = User::where('email', $req->email)->first();
        
        if(!empty($user)){
            return redirect('register')->with('errors', 'Email is Already Registered!');
        }else{
            if(!empty($req->password)){
                $user = new User;
                $user->name = $req->input('name');
                $user->email = $req->input('email');
                $user->password = Crypt::encrypt($req->input('password'));
                $user->userClass = 0;
                $user->contact = $req->input('contact');
                $user->save();
                $userId = $user->id;
                
                $data = [
                    'name'=> $req->input('name'),
                    'username'=>$req->input('email'),
                    'password'=>$req->input('password')
                ];
                Mail::to($req->email)->send(new WelcomeMail($data));
                
                $req->session()->put('user',$req->input('name'));
                $req->session()->put('userId',$userId);
                $req->session()->put('userClass','0');
                $req->session()->put('userEmail',$req->input('email'));
                $req->session()->put('userImage','imgs/profile.png'	);
                return redirect('/');
            }
            else{
                return redirect('register')->with('errors', 'Please Choose a Password!');
            }
            
        }
        
    }
    function login(Request $req){
        $req->session()->forget('user');
        $req->session()->forget('userId');
        $req->session()->forget('userEmail');
        $req->session()->forget('userImage');
        $req->session()->forget('fuser');
        $req->session()->forget('fuserId');
        $req->session()->forget('fuserEmail');
        $req->session()->forget('fuserImage');
        $req->session()->forget('auser');
        $req->session()->forget('auserId');
        $req->session()->forget('auserEmail');
        $req->session()->forget('auserImage');
        $req->session()->forget('qaUser');
        $req->session()->forget('qaUserId');
        $req->session()->forget('qaEmail');
        $req->session()->forget('qaImage');
        $user = User::where("email",$req->input('email'))->first();

        if(!empty($user)){
             if(Crypt::decrypt($user->password)==$req->input('password')){

            $type = $user->type;
            if($type == 'admin'){
                $req->session()->put('auserId',$user->id);
                $req->session()->put('auser',$user->name);
                $req->session()->put('auserEmail',$user->email);
                $req->session()->put('auserContact',$user->contact);
                $req->session()->put('auserImage',$user->image);
                return redirect('/admin/dashboard/');
            }elseif($type == 'faculty'){
                $req->session()->put('fuserId',$user->id);
                $req->session()->put('fuser',$user->name);
                $req->session()->put('fuserEmail',$user->email);
                $req->session()->put('fuserContact',$user->contact);
                $req->session()->put('fuserImage',$user->image);
                return redirect('/faculty/dashboard/');
            }elseif($type == 'qas'){
                $req->session()->put('qaUserId',$user->id);
                $req->session()->put('qaUser',$user->name);
                $req->session()->put('qaEmail',$user->email);
                $req->session()->put('qaContact',$user->contact);
                $req->session()->put('qaImage',$user->image);
                return redirect('/qas/dashboard/');
            }else{
                $req->session()->put('userId',$user->id);
                $req->session()->put('user',$user->name);
                $req->session()->put('userEmail',$user->email);
                $req->session()->put('userContact',$user->contact);
                $req->session()->put('userClass', $user->userClass);

                $req->session()->put('userImage',$user->image);
                return redirect('/student/dashboard/');
            }


        }
        else{
            return redirect('login')->with('errors','Username or Password is Wrong');
        }
        }else{
            return redirect('login')->with('errors','Username or Password is Wrong');
        }

    }

    function forgetPassword(Request $req){
        $user = User::where("email",$req->input('email'))->first();

        if(!empty($user)){
            $password = Str::random(8);
            $user->password = Crypt::encrypt($password);
            $user->save();
            $data = [
                'name'=> $user->name,
                'username'=>$req->input('email'),
                'password'=>$password
            ];
            Mail::to($req->email)->send(new ForgetPasswordMail($data));
            return redirect('forget')->with('errors', 'Forget Password Email has been Sent!!');
        }else{
            return redirect('forget')->with('errors','Username Does not Exist!');
        }
    }



    function logout(Request $req){
        $req->session()->forget('user');
        $req->session()->forget('userId');
        $req->session()->forget('userEmail');
        $req->session()->forget('userImage');
        $req->session()->forget('fuser');
        $req->session()->forget('fuserId');
        $req->session()->forget('fuserEmail');
        $req->session()->forget('fuserImage');
        $req->session()->forget('auser');
        $req->session()->forget('auserId');
        $req->session()->forget('auserEmail');
        $req->session()->forget('auserImage');
        $req->session()->forget('qaUser');
        $req->session()->forget('qaUserId');
        $req->session()->forget('qaImage');
        $req->session()->forget('qaContact');
        $req->session()->forget('qaEmail');
        return redirect('/');
    }

    function uploadProfileImage(Request $req){
        if($req->hasFile('image')){
            $image = $req->file('image');
            $dir = public_path('/imgs/students');
            $imageName = $image->getClientOriginalName();
            $imageSize = $image->getSize();
            if($imageSize <= 1050000){
                $imageNewName = time().'.'.$imageName;
                $image->move($dir, $imageNewName);
                $path = 'imgs/students/'.$imageNewName;
                $userId = Session::get('userId');
                $user = User::where('id', $userId)->first();
                $user->image = $path;
                $user->save();

                $req->session()->put('userImage',$path);
                return redirect('student/profile')->with('success','Profile Picture Uploaded Successfully');

            }else{
                return redirect('student/uploadImage')->with('errors','The Maximum File Upload Size is 1MB.');
            }

        }else{
            return redirect('student/uploadImage')->with('errors','Please Select a File First');
        }
    }

    function editProfile(Request $req){
        $userId = Session::get('userId');
        $user = User::where('id', $userId)->first();
        $user->name = $req->input('name');
        $user->email = $req->input('email');
        $user->contact = $req->input('contact');
        $user->userClass = $req->input('cls');

        $user->save();
        $req->session()->put('user',$req->input('name'));
        $req->session()->put('userEmail',$req->input('email'));
        $req->session()->put('userContact',$req->input('contact'));
        $req->session()->put('userClass',$req->input('cls'));
        return redirect('student/profile')->with('success','Profile Updated Successfully');
    }

    public function changePassword(Request $req){
        $user = User::where('id', Session::get('userId'))->first();
        if($req->newPass == $req->confPass){
            if($req->oldPass == Crypt::decrypt($user->password)){
                $user->password = Crypt::encrypt($req->newPass);
                $user->save();

                return redirect('student/profile')->with("success", 'Password Updated Successfully!!');
            }else{
                $data = [
                    'msg' => 'Old Password does not matches!!',
                    'op'=>$req->oldPass,
                    'np' => $req->newPass,
                ];
                return redirect('student/profile')->with('errors', $data);
            }
        }else{
            $data = [
                'msg' => 'Confirm Password does not matches!!',
                'op'=>$req->oldPass,
                'np' => $req->newPass,
            ];
            return redirect('student/profile')->with('errors', $data);
        }
        
    }

    function changeUserClass(Request $req){

        $userId = Session::get('userId');
        $user = User::where('id', $userId)->first();
        $user->userClass = $req->input('cls');
        $user->save();
        $req->session()->put('userClass',$req->input('cls'));
//        dd('class Updated Successfully!!!');
        return redirect('student/dashboard');
    }


    function getMyCourse(){
        $cids = Courseenroll::select('courseId')
            ->where('userId', Session::get('userId'))
            ->get();

        $crid = [];
        $count = 0;
        foreach($cids as $cid){
            $crid[$count++] = $cid->courseId;
        }
        $course = Course::join('subjects', 'courses.courseSubject', '=', 'subjects.subjectId')
            ->join('classes', 'courses.courseClass', '=', 'classes.classId')
            ->join('users', 'courses.courseInstructor1', '=', 'users.id')
            ->select('courses.*', 'subjects.subjectName as subjectName', 'classes.className as className', 'users.name as name', 'users.image as instructorImage')
            ->whereIn('courseId', $crid)
            ->orderBy('courseId', 'desc')
            ->paginate(9);


        return view('Student/mycourses',['courses'=>$course]);
    }


    function search(Request $req){
        $name = $req->input('name');
        $cls = $req->input('sc');
        
        $data = Course::join('subjects', 'courses.courseSubject', '=', 'subjects.subjectId')
            ->join('classes', 'courses.courseClass', '=', 'classes.classId')
            ->join('users', 'courses.courseInstructor1', '=', 'users.id')
            ->select('courses.*', 'subjects.subjectName as subjectName', 'classes.className as className', 'users.name as name', 'users.image as instructorImage')
            ->where('courseTitle', 'LIKE', "%{$name}%")
            ->orWhere('courseMetaKey', 'LIKE', "%{$name}%");
        if($cls != ""){
            $data->where('courseClass', $cls);
        }
            
        $data = $data->where('courseStatus', 'Published')
            ->orderBy('courseId', 'desc')
            ->get();
         $clcount = $data->count();

        $test = Test::join('subjects', 'tests.tSubject', '=', 'subjects.subjectId')
            ->join('classes', 'tests.tClass', '=', 'classes.classId')
            ->join('users', 'tests.created_by', '=', 'users.id')
            ->select('tests.*', 'subjects.subjectName as subjectName', 'classes.className as className', 'users.name as name', 'users.image as instructorImage')
            ->where('tName', 'LIKE', "%{$name}%")
            ->where('tStatus', 1)
            ->orWhere('tMetaKey', 'LIKE', "%{$name}%");
         if($cls != ""){
            $test = $test->where('tClass', $cls);
         }
            
        $test = $test->orderBy('tId', 'desc')
            ->get();

        $tcount = $test->count();


        $testSeries =  Testcatogerie::join('classes', 'testcatogeries.tcClass', '=', 'classes.classId')
            ->select('testcatogeries.*', 'classes.className as className')
            ->where('tcName', 'LIKE', "%{$name}%")
            ->where('tcStatus', 1)
            ->orWhere('tcKeywords', 'LIKE', "%{$name}%");
        if($cls != ""){
            $testSeries = $testSeries->where('tcClass', $cls);
        }
            
        $testSeries = $testSeries->orderBy('tcId', 'DESC')
            ->get();

        $tscount = $testSeries->count();

        return view('search', ['products' => $data, 'st'=>$name,'tests'=>$test, 'series'=>$testSeries,'testcounts'=>$tcount, 'counts'=>$clcount, 'seriescounts'=>$tscount]);

    }

    public function coursePayments() {
        $pcs = Purchasecourse::join('courses', 'courses.courseId', '=', 'purchasecourses.courseId')
            ->select('purchasecourses.*', 'courses.courseTitle as courseTitle')
            ->where('userId', Session::get('userId'))
            ->where('paymentStatus', 1)
            ->orderBy('pcId', 'desc')
            ->get();

        return view('Student/payments/coursePayments', ['pcs'=>$pcs]);
    }

    public function testPayments() {
        $pcs = Purchasetest::join('tests', 'tests.tId', '=', 'purchasetests.testId')
            ->select('purchasetests.*', 'tests.tName as testName')
            ->where('userId', Session::get('userId'))
            ->where('paymentStatus', 1)
            ->orderBy('pcId', 'desc')
            ->get();

        return view('Student/payments/testPayments', ['pcs'=>$pcs]);
    }

    public function testseriesPayments() {
        $pcs = Purchasetestseries::join('testcatogeries', 'testcatogeries.tcId', '=', 'purchasetestseries.tcId')
            ->select('purchasetestseries.*', 'testcatogeries.tcName as tsName')
            ->where('userId', Session::get('userId'))
            ->where('paymentStatus', 1)
            ->orderBy('pcId', 'desc')
            ->get();

        return view('Student/payments/testseriesPayments', ['pcs'=>$pcs]);
    }

}

