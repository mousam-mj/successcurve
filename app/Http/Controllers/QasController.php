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
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\File;

class QasController extends Controller
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
        
        return View('qas/dashboard', ['cs'=>$courses, 'sts'=>$students, 'tsts'=>$tests, 'cls'=>$classes, 'sbs'=>$subjects, 'tps'=>$topics, 'qs'=>$questions, 'tss'=>$series]);
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
                $userId = Session::get('qaUserId');
                $user = User::where('id', $userId)->first();
                $user->image = $path;
                $user->save();
                
                $req->session()->put('qaImage',$path);
                return redirect('qas/profile')->with('success','Profile Picture Uploaded Successfully');
                
            }else{
                return redirect('qas/uploadImage')->with('errors','The Maximum File Upload Size is 1MB.');
            }
            
        }else{
            return redirect('qas/uploadImage')->with('errors','Please Select a File First');
        }
    }
    function editProfile(Request $req){
        $userId = Session::get('qaUserId');
        $user = User::where('id', $userId)->first();
        $user->name = $req->input('name');
        $user->email = $req->input('email');
        $user->contact = $req->input('contact');
        $user->save();
        $req->session()->put('qaUser',$req->input('name'));
        $req->session()->put('qaEmail',$req->input('email'));
        $req->session()->put('qaContact',$req->input('contact'));
        return redirect('qas/profile')->with('success','Profile Updated Successfully');
    }

    public function changePassword(Request $req){
        $user = User::where('id', Session::get('qaUserId'))->first();
        if($req->newPass == $req->confPass){
            if($req->oldPass == Crypt::decrypt($user->password)){
                $user->password = Crypt::encrypt($req->newPass);
                $user->save();

                return redirect('qas/profile')->with("success", 'Password Updated Successfully!!');
            }else{
                $data = [
                    'msg' => 'Old Password does not matches!!',
                    'op'=>$req->oldPass,
                    'np' => $req->newPass,
                ];
                return redirect('qas/profile')->with('errors', $data);
            }
        }else{
            $data = [
                'msg' => 'Confirm Password does not matches!!',
                'op'=>$req->oldPass,
                'np' => $req->newPass,
            ];
            return redirect('qas/profile')->with('errors', $data);
        }
        
    }

}
