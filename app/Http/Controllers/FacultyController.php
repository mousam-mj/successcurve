<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Course;
use App\Subject;
use App\User;
use App\Classe;
use App\Week;
use App\Lecture;
use App\Test;
use App\Subjecttopic;
use App\Questionbank;
use App\Testcatogerie;


use Illuminate\Support\Facades\Session;

class FacultyController extends Controller
{
    public function dashboard(){
        $courses = Course::where('courseStatus','Published')->count();
        $students = User::where('type', 'user')->count();
        $tests = Test::count();
        $classes = Classe::count();
        $subjects = Subject::count();
        $topics = Subjecttopic::count();
        $questions = Questionbank::count();
        $series = Testcatogerie::count();
        
        return View('Faculty/dashboard', ['cs'=>$courses, 'sts'=>$students, 'tsts'=>$tests, 'cls'=>$classes, 'sbs'=>$subjects, 'tps'=>$topics, 'qs'=>$questions, 'tss'=>$series]);
//        dd($classes);
    }

    function getCourses(){
        $insId = Session::get('fuserId');
        $courseData = Course::where('courseInstructor1', $insId)
            ->orWhere('courseInstructor2', $insId)
            ->get();
        return json_encode(array('data'=>$courseData));
    }
    function createCourse(Request $req){
        $course = new Course;
        $courseCode = $req->input('coursecode');
        $subject = $req->input('subject');
        $subjectName = Subject::where('subjectId', $subject)->value('subjectName');
        
        $cls = $req->input('cls');
        $clsName = Classe::where('classId', $cls)->value('className');
        
        $instructor = $req->input('instructor');
        $instructorName = User::where('id', $instructor)->value('name');
        
        if(Course::where('courseCode', $courseCode)->value('courseTitle')){
            return redirect('faculty/createCourse')
                ->with('name',$req->input('name'))
                ->with('courseCode',$courseCode)
                ->with('subjects',$subject)
                ->with('subjectName',$subjectName)
                ->with('clss',$cls)
                ->with('clsName',$clsName)
                ->with('instructor',$instructor)
                ->with('instructorName',$instructorName)
                ->with('description',$req->input('description'))
                ->with('errors','Course Code has Already Taken');
        }else{
            $course->courseTitle = $req->input('name');
            $course->courseCode = $courseCode;
            $course->courseSubject = $subject;
            $course->courseClass = $cls;
            $course->courseInstructor1 = Session::get('fuserId');
            if($instructor>=1){
                $course->courseInstructor2 = $instructor;
            }
            $course->courseDescription = $req->input('description');
            if($req->hasFile('image')){
                $image = $req->file('image');
                $dir = public_path('/imgs/courses');
                $imageName = $image->getClientOriginalName();
                $imageNewName = time().'.'.$imageName;
                $image->move($dir, $imageNewName);
                $path = 'imgs/courses/'.$imageNewName;
            }else{
                $path = 'imgs/courses/dummyCourse.png';
            }

            
            $course->courseThumbnail = $path;
            if($req->metakey){
                $course->courseMetaKey = $req->metakey;
            }else{
                $course->courseMetaKey = 'Default Course Meta Keyword Here';
            }
            if($req->metadesc){
                $course->courseMetaDesc = $req->metadesc;
            }else{
                $course->courseMetaDesc = 'Default Course Meta Description Here';
            }
            $course->save();
            $courseId = $course->id;
            $req->session()->put('courseId',$courseId);
            return redirect('faculty/addWeek')->with('success','Course Created Successfully!');

        }
    }
    function addWeek(Request $req){
        $week = new Week;
        if($req->input('course') >=1 ){
            $week->courseId=$req->input('course');
            $week->weekname = $req->input('name');
            $week->save();
            $weekId = $week->id;
            $req->session()->put('weekId',$weekId);
            $req->session()->put('courseId',$req->input('course'));
            return redirect('faculty/addLecture')->with('success','Week/Section is Added to The Course');
            
        }else{
            return redirect('faculty/addWeek')->with('errors','Please Select a Course First!');
        }
    }
    function editModule(){
        $insId = Session::get('fuserId');
        $course = Course::where('courseInstructor1',$insId)->get();
        return view('Faculty/editModule',['courses'=>$course]);
    }
    function editModuleContent(Request $req){
        if($req->input('course') >=1 ){
            if($req->input('week') >= 1){
                $week = Week::where('weekId', $req->input('week'))->first();
                $week->courseId=$req->input('course');
                $week->weekname = $req->input('name');
                $week->save();
                return redirect('faculty/editModule')->with('success','Module Updated Successfully');
            }else{
                return redirect('faculty/editModule')->with('errors','Please Select a Module First!');
            }
        }else{
            return redirect('faculty/editModule')->with('errors','Please Select a Course First!');
        }
    }
    function addLecture(Request $req){
        $lecture = new Lecture;
        if($req->input('course')>=1){
            if($req->input('week')>=1){
                $lecture->courseId = $req->input('course');
                $lecture->weekId = $req->input('week');
                $lecture->lectureTitle = $req->input('name');
                $lecture->lectureVideo = $req->input('video');
                $lecture->lectureContent = $req->input('description');
                $lecture->save();
                return redirect('faculty/addLecture')->with('success','Lecture Created Successfully');
            }else{
                return redirect('faculty/addLecture')->with('errors','Please Select a Course First');
            }
        }
        else{
            return redirect('faculty/addLecture')->with('errors','Please Select a Course First');
        }
    }
    
    function editLecture(){
        $insId = Session::get('fuserId');
        $course = Course::where('courseInstructor1',$insId)->get();
        return view('Faculty/editLecture',['courses'=>$course]);
    }
    
    function editLecture2(Request $req){
        $lectureId = $req->input('lecture');
        $lecture = Lecture::where('lectureId',$lectureId)->get();
        return view('Faculty/editLectureContent',['courses'=>$lecture]);
    }
    function updateLecture(Request $req){
        $lectureId = $req->input('lectureId');
        $lecture = Lecture::where('lectureId',$lectureId)->first();
        $lecture->courseId = $req->input('courseId');
        $lecture->weekId = $req->input('weekId');
        $lecture->lectureTitle = $req->input('name');
        $lecture->lectureVideo = $req->input('video');
        $lecture->lectureContent = $req->input('description');
        
        $lecture->save();
//        $lecture = Lecture::where('lectureId',$lectureId)->get();
        $success =  'Course Is Updated Successfully!';
//        return view('faculty/editLectureContent', ['courses'=> $lecture, 'sucess'=>$sucess]);
        return redirect('faculty/dashboard')->with('success', $success);
    }
    function uploadProfileImage(Request $req){
        if($req->hasFile('image')){
            $image = $req->file('image');
            $dir = public_path('imgs/faculty');
            $imageName = $image->getClientOriginalName();
            $imageSize = $image->getSize();
            if($imageSize <= 1050000){
                $imageNewName = time().'.'.$imageName;
                $image->move($dir, $imageNewName);
                $path = 'imgs/faculty/'.$imageNewName;
                $userId = Session::get('fuserId');
                $user = User::where('id', $userId)->first();
                $user->image = $path;
                $user->save();
                
                $req->session()->put('fuserImage',$path);
                return redirect('faculty/profile')->with('success','Profile Picture Uploaded Successfully');
                
            }else{
                return redirect('faculty/uploadImage')->with('errors','The Maximum File Upload Size is 1MB.');
            }
            
        }else{
            return redirect('faculty/uploadImage')->with('errors','Please Select a File First');
        }
    }
    
    function editProfile(Request $req){
        $userId = Session::get('fuserId');
        $user = User::where('id', $userId)->first();
        $user->name = $req->input('name');
        $user->email = $req->input('email');
        $user->contact = $req->input('contact');
        $user->save();
        $req->session()->put('fuserName',$req->input('name'));
        $req->session()->put('fuserEmail',$req->input('email'));
        $req->session()->put('fuserContact',$req->input('contact'));
        return redirect('faculty/profile')->with('success','Profile Updated Successfully');
    }
    function getMyCourses(){
        $instructorId = Session::get('fuserId');
        $course = Course::join('subjects', 'courses.courseSubject', '=', 'subjects.subjectId')
            ->join('classes', 'courses.courseClass', '=', 'classes.classId')
            ->join('users', 'courses.courseInstructor1', '=', 'users.id')
            ->select('courses.*', 'subjects.subjectName as subjectName', 'classes.className as className', 'users.name as name', 'users.image as instructorImage')
            ->where('courseInstructor1', '=', $instructorId)
            ->where('courseStatus', '!=', 'Removed')
            ->orderBy('courseId', 'desc')
            ->get();
        
        return view('Faculty/myCourses',['courses'=>$course]);
    }
    function publishedCourses(){
        $instructorId = Session::get('fuserId');
        $course = Course::join('subjects', 'courses.courseSubject', '=', 'subjects.subjectId')
            ->join('classes', 'courses.courseClass', '=', 'classes.classId')
            ->join('users', 'courses.courseInstructor1', '=', 'users.id')
            ->select('courses.*', 'subjects.subjectName as subjectName', 'classes.className as className', 'users.name as name', 'users.image as instructorImage')
            ->where('courseInstructor1', '=', $instructorId)
            ->where('courseStatus', '=', 'Published')
            ->orderBy('courseId', 'desc')
            ->get();
        
        return view('Faculty/myCourses',['courses'=>$course]);
    }
    function pendingCourses(){
        $instructorId = Session::get('fuserId');
        $course = Course::join('subjects', 'courses.courseSubject', '=', 'subjects.subjectId')
            ->join('classes', 'courses.courseClass', '=', 'classes.classId')
            ->join('users', 'courses.courseInstructor1', '=', 'users.id')
            ->select('courses.*', 'subjects.subjectName as subjectName', 'classes.className as className', 'users.name as name', 'users.image as instructorImage')
            ->where('courseInstructor1', '=', $instructorId)
            ->where('courseStatus', '=', 'Pending')
            ->orderBy('courseId', 'desc')
            ->get();
        
        return view('Faculty/myCourses',['courses'=>$course]);
    }
    function removedCourses(){
        $instructorId = Session::get('fuserId');
        $course = Course::join('subjects', 'courses.courseSubject', '=', 'subjects.subjectId')
            ->join('classes', 'courses.courseClass', '=', 'classes.classId')
            ->join('users', 'courses.courseInstructor1', '=', 'users.id')
            ->select('courses.*', 'subjects.subjectName as subjectName', 'classes.className as className', 'users.name as name', 'users.image as instructorImage')
            ->where('courseInstructor1', '=', $instructorId)
            ->where('courseStatus', '=', 'Removed')
            ->orderBy('courseId', 'desc')
            ->get();
        
        return view('Faculty/myCourses',['courses'=>$course]);
    }
    function removeCourse(Request $req){
        $courseId = $req->get('courseId');
        $course = Course::where('courseId', '=', $courseId)->first();
        $course->courseStatus = 'Removed';
        $course->save();
        
        return redirect('faculty/dashboard')->with('errors','Course Moved To Trash Successfully');
    }
    function getPendingCourses(){
        $courseData = Course::where('courseStatus', '=', 'Pending')
            ->where('courseInstructor1', Session::get('fuserId'))
            ->count();
        return json_encode(array('data'=>$courseData));
    }
    function getPublishedCourses(){
        $courseData = Course::where('courseStatus', '=', 'Published')
            ->where('courseInstructor1', Session::get('fuserId'))->count();
        return json_encode(array('data'=>$courseData));
    }
    function getAllCourses(){
        $courseData = Course::where('courseStatus', '!=', 'Removed')
            ->where('courseInstructor1', Session::get('fuserId'))->count();
        return json_encode(array('data'=>$courseData));
    }
    function getRemovedCourses(){
        $courseData = Course::where('courseStatus', '=', 'Removed')
            ->where('courseInstructor1', Session::get('fuserId'))->count();
        return json_encode(array('data'=>$courseData));
    }
    function editCourse(Request $req){
        $courseId = $req->get('courseId');
        $data = Course::join('subjects', 'courses.courseSubject', '=', 'subjects.subjectId')
            ->join('classes', 'courses.courseClass', '=', 'classes.classId')
            ->join('users', 'courses.courseInstructor1', '=', 'users.id')
            ->select('courses.*', 'subjects.subjectName as subjectName', 'classes.className as className', 'users.name as name', 'users.image as instructorImage')
            ->where('courseId', $courseId)
            ->orderBy('courseId', 'desc')
            ->get();
        
        $instructorId = Session::get('fuserId');
        foreach($data as $course){
         if($course->courseInstructor1 == $instructorId)
         {
             return view('faculty/editCourse', ['courses'=> $data]);
         }else{
            $errors = 'Access Denied';
            $course = [];
            return view('faculty/editCourse',['courses'=>$data, 'errors'=> $errors]);
        }
        }
  
    }
    function editCourseContent(Request $req){
        $courseId = $req->input('courseId');
        
        $data = Course::where('courseId', $courseId)->first();
        
        $data->courseTitle = $req->input('name');
        $data->courseCode = $req->input('coursecode');
        $data->courseSubject = $req->input('subject');
        $data->courseClass = $req->input('cls');
        $data->courseInstructor1 = Session::get('fuserId');
        if($req->input('instructor')){
            $data->courseInstructor2 = $req->input('instructor');
        }
        
        $data->courseDescription = $req->input('description');
        
        if($req->hasFile('image')){
            $image = $req->file('image');
            $dir = public_path('/imgs/courses');
            $imageName = $image->getClientOriginalName();
            $imageNewName = time().'.'.$imageName;
            $image->move($dir, $imageNewName);
            $path = 'imgs/courses/'.$imageNewName;
        }else{
            $path = $req->input('prevImage');
        }
        $data->courseThumbnail = $path;
        $data->courseStatus = $req->input('status');
        $data->save();
        
        $data = Course::join('subjects', 'courses.courseSubject', '=', 'subjects.subjectId')
            ->join('classes', 'courses.courseClass', '=', 'classes.classId')
            ->join('users', 'courses.courseInstructor1', '=', 'users.id')
            ->select('courses.*', 'subjects.subjectName as subjectName', 'classes.className as className', 'users.name as name', 'users.image as instructorImage')
            ->where('courseId', $courseId)
            ->orderBy('courseId', 'desc')
            ->get();
        return view('faculty/editCourse', ['courses'=> $data]);
    }
    
    function getTopCourses(){
        $data = Course::where('createdBy', Session::get('fuserId'))->where('courseStatus', 'Published')->orderBy('students', 'DESC')->take(5)->get();
        return response()->json($data);
    }
    function getTopTests(){
        $data = Test::where('createdBy', Session::get('fuserId'))->orderBy('students', 'DESC')->take(5)->get();
        return response()->json($data);
    }
    
}
 