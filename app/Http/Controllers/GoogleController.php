<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


use Socialite;
use Exception;
use App\User;
use Illuminate\Support\Facades\Crypt;


class GoogleController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }
    
    public function handleGoogleCallback(Request $req)
    {
        try {
    
            $user = Socialite::driver('google')->user();
     
            $finduser = User::where('email', $user->email)->first();
     
            if($finduser){
                $req->session()->put('user',$finduser->name);
                $req->session()->put('userId',$finduser->id);
                $req->session()->put('userEmail',$finduser->email);
                $req->session()->put('userImage',$finduser->image);
                return redirect('/');
     
            }else{
                $newuser = new User;
                $newuser->name = $user->name;
                $newuser->email = $user->email;
                $newuser->password = Crypt::encrypt(rand(100000,999999));
                $newuser->save();
                $userId = $user->id;
                $req->session()->put('user',$req->input('name'));
                $req->session()->put('userId',$userId);
                $req->session()->put('userEmail',$req->input('email'));
                $req->session()->put('userImage','imgs/profile.png'	);
                return redirect('/');
            }
    
        } catch (Exception $e) {
//            dd($e->getMessage());
        }
    }
}
 