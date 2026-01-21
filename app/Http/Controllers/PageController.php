<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Course;
use App\Classe;

use App\User;
use App\Test;
use App\Contact;
use Session;
use Crypt;
class PageController extends Controller
{
    function aboutUs(){
        $users = User::where('type', 'faculty')->get();
        
        return view('about');
    }
    function contact(Request $req){
        $cn = new Contact;
        $cn->name = $req->name;
        $cn->email = $req->email;
        $cn->contact = $req->contact;
        $cn->message = $req->message;
        $cn->save();
        return redirect('contact')->with('errors', 'Our Team Will Reach You Soon!!');
    }
    function sitemap(){
        $crs = Course::orderBy('courseId', 'desc')->get();
        $tests = Test::orderBy('tId', 'desc')->get();
        $cls = Classe::orderBy('className', 'ASC')->get();
        return view('sitemap', ['cls'=>$cls, 'tests'=>$tests, 'crs'=>$crs]);
    }
}
