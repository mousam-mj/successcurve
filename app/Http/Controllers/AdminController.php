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

use App\Slider;
use App\Contact;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\File;
use App\Exports\ClassUserExport;
use App\Exports\UsersExport;
use Maatwebsite\Excel\Facades\Excel;

class AdminController extends Controller
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
        
        return View('Admin/dashboard', ['cs'=>$courses, 'sts'=>$students, 'tsts'=>$tests, 'cls'=>$classes, 'sbs'=>$subjects, 'tps'=>$topics, 'qs'=>$questions, 'tss'=>$series]);
//        dd($classes);
    }

    // User Profile  
    function uploadProfileImage(Request $req){
        if($req->hasFile('image')){
            $image = $req->file('image');
            $dir = public_path('imgs/admin');
            $imageName = $image->getClientOriginalName();
            $imageSize = $image->getSize();
            if($imageSize <= 1050000){
                $imageNewName = time().'.'.$imageName;
                $image->move($dir, $imageNewName);
                $path = 'imgs/admin/'.$imageNewName;
                $userId = Session::get('auserId');
                $user = User::where('id', $userId)->first();
                $user->image = $path;
                $user->save();
                
                $req->session()->put('auserImage',$path);
                return redirect('admin/profile')->with('success','Profile Picture Uploaded Successfully');
                
            }else{
                return redirect('admin/uploadImage')->with('errors','The Maximum File Upload Size is 1MB.');
            }
            
        }else{
            return redirect('admin/uploadImage')->with('errors','Please Select a File First');
        }
    }
    function editProfile(Request $req){
        $userId = Session::get('auserId');
        $user = User::where('id', $userId)->first();
        $user->name = $req->input('name');
        $user->email = $req->input('email');
        $user->contact = $req->input('contact');
        $user->save();
        $req->session()->put('auserName',$req->input('name'));
        $req->session()->put('auserEmail',$req->input('email'));
        $req->session()->put('auserContact',$req->input('contact'));
        return redirect('admin/profile')->with('success','Profile Updated Successfully');
    }

    public function changePassword(Request $req){
        $user = User::where('id', Session::get('auserId'))->first();
        if($req->newPass == $req->confPass){
            if($req->oldPass == Crypt::decrypt($user->password)){
                $user->password = Crypt::encrypt($req->newPass);
                $user->save();

                return redirect('admin/profile')->with("success", 'Password Updated Successfully!!');
            }else{
                $data = [
                    'msg' => 'Old Password does not matches!!',
                    'op'=>$req->oldPass,
                    'np' => $req->newPass,
                ];
                return redirect('admin/profile')->with('errors', $data);
            }
        }else{
            $data = [
                'msg' => 'Confirm Password does not matches!!',
                'op'=>$req->oldPass,
                'np' => $req->newPass,
            ];
            return redirect('admin/profile')->with('errors', $data);
        }
        
    }


    function getTopCourses(){
        $data = Course::where('courseStatus', 'Published')->orderBy('students', 'DESC')->take(5)->get();
        return response()->json($data);
    }
    function getTopTests(){
        $data = Test::orderBy('students', 'DESC')->take(5)->get();
        return response()->json($data);
    }

    // Sliders Methods
    public function sliders(){
        $sliders = Slider::get();
        
        return view('Admin/slider/sliders', ['sliders'=>$sliders]);
    }

    public function newSlider(){
        return view('Admin/slider/addSlider', ['title'=>"Add Slider", 'status'=> 0, 'slider'=>null]);
    }
    
    function addSlider(Request $req){
        if(!empty($req->id)){
            $slider = Slider::where('id', $req->id)->first();
            $slider->name = $req->name;
            $slider->url = $req->url;
            $slider->status = $req->status;
            if($req->hasFile('image')){
                $image = $req->file('image');
                $dir = public_path('imgs/Sliders');
                $imageName = $image->getClientOriginalName();
                $imageNewName = time().'.'.$imageName;
                $image->move($dir, $imageNewName);
                $path = 'imgs/Sliders/'.$imageNewName;
                $slider->image = $path;
            }
           
            $slider->save();
            return redirect('admin/sliders')->with('success','Slider Is  Updated Successfully');
        } else {
            $slider = new Slider;
            $slider->name = $req->input('name');
            $slider->url = $req->url;
            $slider->status = $req->input('status');
            if($req->hasFile('image')){
                $image = $req->file('image');
                $dir = public_path('\imgs\Sliders');
                $imageName = $image->getClientOriginalName();
                $imageNewName = time().'.'.$imageName;
                $image->move($dir, $imageNewName);
                $path = 'imgs/Sliders/'.$imageNewName;
            }
            $slider->image = $path;
            $slider->save();
            return redirect('admin/sliders')->with('success','Slider Is  Added Successfully');
        }
        
    }
    public function editSlider($id){
        $slider = Slider::where('id', $id)->first();
        return view('Admin/slider/addSlider', ['title'=>"Update Slider", 'status'=> 1, 'slider'=>$slider]);
    }

    public function deactivateSlider($id){
        $slider = Slider::where('id', $id)->first();

        if (!empty($slider)) {
            $slider->status = 0;
            $slider->save();
            
            return back()->with('success', 'Slider Deactivated Successfully..');
        } else {
            return back()->with('errors', 'Invalid Slider Id!!');
        }
    }
    public function activateSlider($id){
        $slider = Slider::where('id', $id)->first();

        if (!empty($slider)) {
            $slider->status = 1;
            $slider->save();
            
            return back()->with('success', 'Slider Activated Successfully..');
        } else {
            return back()->with('errors', 'Invalid Slider Id!!');
        }
    }
    public function removeSlider($id){
        $slider = Slider::where('id', $id)->first();

        if (!empty($slider)) {
            $image = $slider->image;
        
            if(File::exists($image)) {
                // dd("exist");
                File::delete($image);
            }
            Slider::where('id', $id)->delete();
            
            return back()->with('success', 'Slider Removed Successfully..');
        } else {
            return back()->with('errors', 'Invalid Slider Id!!');
        }
    }
    
//    Course Module
    
    
    
    function getMyCourses(){
        $course = Course::join('subjects', 'courses.courseSubject', '=', 'subjects.subjectId')
            ->join('classes', 'courses.courseClass', '=', 'classes.classId')
            ->join('users', 'courses.courseInstructor1', '=', 'users.id')
            ->select('courses.*', 'subjects.subjectName as subjectName', 'classes.className as className', 'users.name as name', 'users.image as instructorImage')
            ->where('courseStatus', '!=', 'Removed')
            ->orderBy('courseId', 'desc')
            ->get();
        
        return view('Admin/courses/myCourses',['courses'=>$course]);
    }
    function publishedCourses(){
        $course = Course::join('subjects', 'courses.courseSubject', '=', 'subjects.subjectId')
            ->join('classes', 'courses.courseClass', '=', 'classes.classId')
            ->join('users', 'courses.courseInstructor1', '=', 'users.id')
            ->select('courses.*', 'subjects.subjectName as subjectName', 'classes.className as className', 'users.name as name', 'users.image as instructorImage')
            ->where('courseStatus', '=', 'Published')
            ->orderBy('courseId', 'desc')
            ->get();
        
        return view('Admin/myCourses',['courses'=>$course]);
    }
    function pendingCourses(){
        $course = Course::join('subjects', 'courses.courseSubject', '=', 'subjects.subjectId')
            ->join('classes', 'courses.courseClass', '=', 'classes.classId')
            ->join('users', 'courses.courseInstructor1', '=', 'users.id')
            ->select('courses.*', 'subjects.subjectName as subjectName', 'classes.className as className', 'users.name as name', 'users.image as instructorImage')
            ->where('courseStatus', '=', 'Pending')
            ->orderBy('courseId', 'desc')
            ->get();
        
        return view('Admin/myCourses',['courses'=>$course]);
    }
    function removedCourses(){
        $course = Course::join('subjects', 'courses.courseSubject', '=', 'subjects.subjectId')
            ->join('classes', 'courses.courseClass', '=', 'classes.classId')
            ->join('users', 'courses.courseInstructor1', '=', 'users.id')
            ->select('courses.*', 'subjects.subjectName as subjectName', 'classes.className as className', 'users.name as name', 'users.image as instructorImage')
            ->where('courseStatus', '=', 'Removed')
            ->orderBy('courseId', 'desc')
            ->get();
        
        return view('Admin/myCourses',['courses'=>$course]);
    }
    function removeCourse(Request $req){
        $courseId = $req->get('courseId');
        $course = Course::where('courseId', '=', $courseId)->first();
        $course->courseStatus = 'Removed';
        $course->save();
        
        return redirect('admin/dashboard')->with('errors','Course Moved To Trash Successfully');
    }
    function getPendingCourses(){
        $courseData = Course::where('courseStatus', '=', 'Pending')->count();
        return json_encode(array('data'=>$courseData));
    }
    function getPublishedCourses(){
        $courseData = Course::where('courseStatus', '=', 'Published')->count();
        return json_encode(array('data'=>$courseData));
    }
    function getAllCourses(){
        $courseData = Course::where('courseStatus', '!=', 'Removed')->count();
        return json_encode(array('data'=>$courseData));
    }
    function getRemovedCourses(){
        $courseData = Course::where('courseStatus', '=', 'Removed')->count();
        return json_encode(array('data'=>$courseData));
    }

    // COntact Requests Methods
    
    public function contacts(){
        $cs = Contact::get();
        return view('Admin/contacts', ['contacts'=>$cs]);
    }
    public function contactDetails($id){
        $cn = Contact::where('contactId', $id)->first();
        return view('Admin/contactDetails', ['cs'=>$cn]);
    }

    public function deleteContact($id){
        $cn = Contact::where('contactId', $id)->first();
        
        if (!empty($cn)) {
            $cn = Contact::where('contactId', $id)->delete();
            return back()->with('errors','Contact Removed Successfully!!');
        } else {
            return back()->with('errors','Invalid Contact Id!!');
        }
    }

    // Class User Export
    public function classUsers($id){
        $cls = Classe::where('classId', $id)->first();

        $users = User::where('userClass', $id)->get();

        return view('Admin/users/userExport', ['cls'=>$cls, 'users'=>$users]);
    }

    public function exportClassUsers($id){
        return Excel::download(new ClassUserExport($id), 'classUser.xlsx');
    }


    public function admins(){
        $user = User::where('type', 'admin')->get();

        return view('Admin.users.admins', ['title'=>"Admins", 'users'=>$user]);
    }

    public function instructors(){
        $user = User::where('type', 'faculty')->get();

        return view('Admin.users.admins', ['title'=>"Instructors",'users'=>$user]);
    }

    public function users(Request $req = null){
        $query = User::where('type', 'user');
        
        // Apply filters if provided
        if ($req && $req->has('filter')) {
            if ($req->status != '') {
                if ($req->status == 'active') {
                    $query->where('userStatus', '!=', 2);
                } elseif ($req->status == 'banned') {
                    $query->where('userStatus', 2);
                }
            }
            
            if ($req->search != '') {
                $search = $req->search;
                $query->where(function($q) use ($search) {
                    $q->where('name', 'like', '%'.$search.'%')
                      ->orWhere('email', 'like', '%'.$search.'%')
                      ->orWhere('contact', 'like', '%'.$search.'%');
                });
            }
        }
        
        $user = $query->get();

        return view('Admin.users.admins', ['title'=>"Users",'users'=>$user]);
    }
    
    public function filterUsers(Request $req){
        $query = User::where('type', 'user');
        
        if ($req->status != '') {
            if ($req->status == 'active') {
                $query->where('userStatus', '!=', 2);
            } elseif ($req->status == 'banned') {
                $query->where('userStatus', 2);
            }
        }
        
        if ($req->search != '') {
            $search = $req->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', '%'.$search.'%')
                  ->orWhere('email', 'like', '%'.$search.'%')
                  ->orWhere('contact', 'like', '%'.$search.'%');
            });
        }
        
        $user = $query->get();

        return view('Admin.users.admins', [
            'title'=>"Users",
            'users'=>$user,
            'filterStatus' => $req->status ?? '',
            'filterSearch' => $req->search ?? ''
        ]);
    }
    
    public function exportUsers(Request $req){
        $filters = [
            'type' => 'user',
            'status' => $req->status ?? '',
            'search' => $req->search ?? '',
        ];
        
        return Excel::download(new UsersExport($filters), 'users_export.xlsx');
    }

    public function qas(){
        $user = User::where('type', 'qas')->get();

        return view('Admin.users.admins', ['title'=>"Question Uploaders",'users'=>$user]);
    }
    
    
    public function banUser($id){
        $user = User::where('id', $id)->first();
        $type = $user->type;
        $user->userStatus = 2;
        $user->save();

        return back()->with('success', 'User Banned Successfully!!');
    }
    public function unbanUser($id){
        $user = User::where('id', $id)->first();
        $type = $user->type;
        $user->userStatus = 1;
        $user->save();

        return back()->with('success', 'User Unbanned Successfully!!');
    }
    public function newUser(){
        return view('Admin.users.addUsers');
    }
    function addUser(Request $req){
        $user = new User;
        $user->name = $req->input('name');
        $user->email = $req->input('email');
        $user->password = Crypt::encrypt($req->input('password'));
        $user->contact = $req->input('contact');
        $user->type = $req->type;
        if($req->hasFile('image')){
            $image = $req->file('image');
            $dir = public_path('\imgs\user');
            $imageName = $image->getClientOriginalName();
            $imageNewName = time().'.'.$imageName;
            $image->move($dir, $imageNewName);
            $path = 'imgs/user/'.$imageNewName;
        }else{
            $path = 'imgs/user/profile.png';
        }
        
        
        $user->image = $path;
        $user->save();

        if($req->type == 'admin'){
            return redirect('admin/users/admins')->with('success', 'Admin Added Successfully!!');
        }
        
    }
    
}
