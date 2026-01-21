<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Doubt;
use App\Subject;
use App\User;
use App\Classe;
use App\Doubtanswer;
use App\Doubtreply;
use Session;

class DoubtController extends Controller
{
    public function doubts(){
        
        $doubts = Doubt::join('users', 'doubts.userId', '=', 'users.id')
            ->select('doubts.*', 'users.name as userName')
            ->orderBy('doubtId', 'DESC')->get();
        
        $mydoubts = Doubt::join('users', 'doubts.userId', '=', 'users.id')
            ->select('doubts.*', 'users.name as userName')
            ->where('userId', Session::get('userId'))
            ->orderBy('doubtId', 'DESC')->get();
        
        return View('Student/doubts', ['doubts'=>$doubts, 'mydoubts'=>$mydoubts]);
    }
    public function askDoubt(Request $req){
        $doubt = new Doubt;
        $doubt->userId = Session::get('userId');
        $doubt->subjectId = $req->dsub;
        $doubt->classId = $req->dcls;
        if($req->dcontent){
            $doubt->doubtContent = $req->dcontent;
        }
        $doubt->status = 0;
        
        if($req->hasFile('image')){
            $image = $req->file('image');
            $dir = public_path('\imgs\doubts');
            $imageName = $image->getClientOriginalName();
            $imageNewName = time().'.'.$imageName;
            $image->move($dir, $imageNewName);
            $path = 'imgs/doubts/'.$imageNewName;
            $doubt->doubtImage = $path;
        }  
        $doubt->save();
        return redirect('student/doubts');
    }
    
    public function singleDoubt($id){
        $mydoubts = Doubt::join('users', 'doubts.userId', '=', 'users.id')
            ->select('doubts.*', 'users.name as userName')
            ->where('doubtId', $id)
            ->first();
        
         return View('Student/singleDoubt', ['mydoubts'=>$mydoubts]);
    }
}














 