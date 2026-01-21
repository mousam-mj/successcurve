<?php

namespace App\Http\Controllers;

use App\Paragraph;
use Illuminate\Http\Request;
use App\Qbank;
use App\Qtopic;
use App\Qlession;
use App\Question;
use App\Questionbank;
use App\Imports\QuestionImport;
use Maatwebsite\Excel\Facades\Excel;


use Illuminate\Support\Facades\Session;

class QuestionController extends Controller
{

    // Question Banks methods

    public function qbs(){
        $qbs = Qbank::select('qbId', 'qbName')->where('parentQbId', null)->where('qbStatus', 1)->get();
        
        $qBanks = array();
        $count = 0;

        foreach($qbs as $qb){
            $totalQuestions = Questionbank::where('pqbId', $qb->qbId);
            
            if (Session::get('qaUserId')) {
                $totalQuestions = $totalQuestions->where('qwCreatedBy', Session::get('qaUserId'));
            }

            $totalQuestions = $totalQuestions->count();

            $qBanks[$count]['qbId'] = $qb->qbId; 
            $qBanks[$count]['qbName'] = $qb->qbName; 
            $qBanks[$count]['tqnos'] = $totalQuestions; 

            $count++;
        }

        if (Session::get('qaUserId')) {
            return view('qas/questions/qbanks', ['qbs'=>$qBanks, 'titles'=>'Question Banks', 'status'=>1]);
        }

        return view('Admin/questions/qbanks', ['qbs'=>$qBanks, 'titles'=>'Question Banks', 'status'=>1]);
    }

    public function addQbs(Request $req){
        $creator = Session::get('auserId');
        
        if (Session::get('qaUserId')) {
            $creator = Session::get('qaUserId');
        }

        $qb  = new Qbank();
        $qb->qbName = $req->title;
        $qb->qbCreatedBy = $creator;
        $qb->save();

        if (Session::get('qaUserId')) {
            return redirect('qas/qbs')->with('success', 'Question Bank Created Successfully!!');
        }

        return redirect('admin/qbs')->with('success', 'Question Bank Created Successfully!!');
    }

    public function updateQbs(Request $req){
        $qb  = Qbank::where('qbId', $req->uqbId)->first();
        $qb->qbName = $req->utitle;

        $qb->save();

        if (Session::get('qaUserId')) {
            return redirect('qas/qbs')->with('success', 'Question Bank Updated Successfully!!');
        }

        return redirect('admin/qbs')->with('success', 'Question Bank Updated Successfully!!');
    }

    public function qbsTrash(){
        $qbs = Qbank::select('qbId', 'qbName')->where('parentQbId', null)->where('qbStatus', 0)->get();
        
        $qBanks = array();
        $count = 0;

        foreach($qbs as $qb){
            $totalQuestions = Questionbank::where('pqbId', $qb->qbId)->count();

            $qBanks[$count]['qbId'] = $qb->qbId; 
            $qBanks[$count]['qbName'] = $qb->qbName; 
            $qBanks[$count]['tqnos'] = $totalQuestions; 

            $count++;
        }
        return view('Admin/questions/qbanks', ['qbs'=>$qBanks, 'titles'=>'Trashed Question Banks', 'status'=>0]);
    }

    public function removeQbs($id){
        $qb  = Qbank::where('qbId', $id)->first();
        if(!empty($qb)){
            $qb->qbStatus = 0;
            $qb->save();

            return back()->with('success', 'Question Bank Removed Successfully..');
        } else {
            return back()->with('errors', 'Invalid Question Bank Id!!');
        }
    }

    public function restoreQbs($id){
        $qb  = Qbank::where('qbId', $id)->first();
        if(!empty($qb)){
            $qb->qbStatus = 1;
            $qb->save();

            return back()->with('success', 'Question Bank Restored Successfully..');
        } else {
            return back()->with('errors', 'Invalid Question Bank Id!!');
        }
    }

    public function deleteQbs($id){
        $qb  = Qbank::where('qbId', $id)->first();
        if(!empty($qb)){
            $qb->qbStatus = 2;
            $qb->save();

            return back()->with('success', 'Question Bank Deleted Successfully..');
        } else {
            return back()->with('errors', 'Invalid Question Bank Id!!');
        }
    }

    // Sub Question Bnaks Methods 

    public function sqbs($id){
        $sqbs = Qbank::select('qbId', 'qbName')->where('parentQbId', $id)->where('qbStatus', 1)->get();
        
        $qbs = Qbank::select('qbId', 'qbName')->where('qbId', $id)->first();

        $sqBanks = array();
        $count = 0;

        foreach($sqbs as $qb){
            $totalQuestions = Questionbank::where('qbId', $qb->qbId);
            
            if (Session::get('qaUserId')) {
                $totalQuestions = $totalQuestions->where('qwCreatedBy', Session::get('qaUserId'));
            }
            
            $totalQuestions = $totalQuestions->count();

            $sqBanks[$count]['qbId'] = $qb->qbId; 
            $sqBanks[$count]['qbName'] = $qb->qbName; 
            $sqBanks[$count]['tqnos'] = $totalQuestions; 

            $count++;
        }

        if (Session::get('qaUserId')) {
            return view('qas/questions/sqbanks', ['qbs'=>$qbs, 'sqbs'=>$sqBanks, 'titles'=>"Sub Question Bank", 'status'=> 1]);
        }

        return view('Admin/questions/sqbanks', ['qbs'=>$qbs, 'sqbs'=>$sqBanks, 'titles'=>"Sub Question Bank", 'status'=> 1]);
    }

    public function sqbsTrash($id){
        $sqbs = Qbank::select('qbId', 'qbName')->where('parentQbId', $id)->where('qbStatus', 0)->get();
        
        $qbs = Qbank::select('qbId', 'qbName')->where('qbId', $id)->first();

        $sqBanks = array();
        $count = 0;

        foreach($sqbs as $qb){
            $totalQuestions = Questionbank::where('qbId', $qb->qbId)->count();

            $sqBanks[$count]['qbId'] = $qb->qbId; 
            $sqBanks[$count]['qbName'] = $qb->qbName; 
            $sqBanks[$count]['tqnos'] = $totalQuestions; 

            $count++;
        }
        
        return view('Admin/questions/sqbanks', ['qbs'=>$qbs, 'sqbs'=>$sqBanks, 'titles'=>"Trashed Sub Question Bank", 'status'=>0]);
    }

    public function addSqbs(Request $req){
        $qb  = new Qbank();
        $qb->qbName = $req->title;
        $qb->parentQbId = $req->qbid;
        
        if (Session::get('qaUserId')) {
            $qb->qbCreatedBy = Session::get('qaUserId');
        } else {
            $qb->qbCreatedBy = Session::get('auserId');
        }
        
        $qb->save();

        if (Session::get('qaUserId')) {
            return redirect('qas/sqbs/'.$req->qbid)->with('success', 'Sub Bank Created Successfully!!');
        }

        return redirect('admin/sqbs/'.$req->qbid)->with('success', 'Sub Bank Created Successfully!!');
    }

    public function updateSqbs(Request $req){
        $qb  = Qbank::where('qbId', $req->usqbId)->first();
        $qb->qbName = $req->utitle;
        $qb->save();
        return back()->with('success', 'Sub Bank Updated Successfully..');
    }


    public function removeSqbs($id){
        $qb  = Qbank::where('qbId', $id)->first();

        if(!empty($qb)){
            $qbId = $qb->parentQbId;
            $qb->qbStatus = 0;
            $qb->save();

            return back()->with('success', 'Question Bank Removed Successfully..');
        } else {
            return back()->with('errors', 'Invalid Question Bank Id!!');
        }
    }

    public function restoreSqbs($id){
        $qb  = Qbank::where('qbId', $id)->first();
        if(!empty($qb)){
            $qb->qbStatus = 1;
            $qb->save();

            return back()->with('success', 'Question Bank Restored Successfully..');
        } else {
            return back()->with('errors', 'Invalid Question Bank Id!!');
        }
    }

    public function deleteSqbs($id){
        $qb  = Qbank::where('qbId', $id)->first();
        if(!empty($qb)){
            $qb->qbStatus = 2;
            $qb->save();

            return back()->with('success', 'Sub Question Bank Deleted Successfully..');
        } else {
            return back()->with('errors', 'Invalid Sub Question Bank Id!!');
        }
    }


    // Question topics methods 

    public function qts($id){
        $qt = Qtopic::select('qtId', 'qtName')->where('parentQtId', null)->where('qbId', $id)->where('qtStatus', 1)->get();
        
        $sqbs = Qbank::where('qbId', $id)->first();

        $qTopics = array();
        $count = 0;

        foreach($qt as $qb){
            $totalQuestions = Questionbank::where('pqtId', $qb->qtId);

            if (Session::get('qaUserId')) {
                $totalQuestions = $totalQuestions->where('qwCreatedBy', Session::get('qaUserId'));
            }

            $totalQuestions = $totalQuestions->count();

            $qTopics[$count]['qtId'] = $qb->qtId; 
            $qTopics[$count]['qtName'] = $qb->qtName; 
            $qTopics[$count]['tqnos'] = $totalQuestions; 

            $count++;
        }

        if (Session::get('qaUserId')) {
            return view('qas/questions/qtopics', ['qts'=>$qTopics, 'sqbs'=>$sqbs, 'titles'=>"Question Topics", 'status'=>0]);
        }

        return view('Admin/questions/qtopics', ['qts'=>$qTopics, 'sqbs'=>$sqbs, 'titles'=>"Question Topics", 'status'=>0]);
    }

    public function qtsTrash($id){
        $qt = Qtopic::select('qtId', 'qtName')->where('parentQtId', null)->where('qbId', $id)->where('qtStatus', 0)->get();
        
        $sqbs = Qbank::where('qbId', $id)->first();

        $qTopics = array();
        $count = 0;

        foreach($qt as $qb){
            $totalQuestions = Questionbank::where('pqtId', $qb->qtId);

            $qTopics[$count]['qtId'] = $qb->qtId; 
            $qTopics[$count]['qtName'] = $qb->qtName; 
            $qTopics[$count]['tqnos'] = $totalQuestions; 

            $count++;
        }


        return view('Admin/questions/qtopics', ['qts'=>$qTopics, 'sqbs'=>$sqbs, 'titles'=>"Trashed Question Topics", 'status'=>1]);
    }

    public function addQts(Request $req){
        $qt = new Qtopic();
        $qt->qtName = $req->title;
        $qt->qbId = $req->qbid;
        $qt->parentQbId = $req->pqbid;

        if (Session::get('qaUserId')) {
            $qt->qtCreatedBy = Session::get('qaUserId');
        } else {
            $qt->qtCreatedBy = Session::get('auserId');
        }
        
        $qt->save();

        if (Session::get('qaUserId')) {
            return redirect('qas/qts/'.$req->qbid)->with('success', 'Question Topic Created Successfully!!');
        }
        
        return redirect('admin/qts/'.$req->qbid)->with('success', 'Question Topic Created Successfully!!');
    }

    public function updateQts(Request $req){
        $qt = Qtopic::where('qtId', $req->uqtid)->first();
        $qt->qtName = $req->utitle;
        $qt->save();
        return back()->with('success', 'Question Topic Updated Successfully!!');
    }

    public function removeQts($id){
        $qt  = Qtopic::where('qtId', $id)->first();

        if(!empty($qt)){
            $qt->qtStatus = 0;
            $qt->save();

            return back()->with('success', 'Question Topic Removed Successfully..');
        } else {
            return back()->with('errors', 'Invalid Question Topic Id!!');
        }
    }

    public function restoreQts($id){
        $qt  = Qtopic::where('qtId', $id)->first();

        if(!empty($qt)){
            $qt->qtStatus = 1;
            $qt->save();

            return back()->with('success', 'Question Topic Restored Successfully..');
        } else {
            return back()->with('errors', 'Invalid Question Topic Id!!');
        }
    }

    public function deleteQts($id){
        $qt  = Qtopic::where('qtId', $id)->first();

        if(!empty($qt)){
            $qt->qtStatus = 2;
            $qt->save();

            return back()->with('success', 'Question Topic Deleted Successfully..');
        } else {
            return back()->with('errors', 'Invalid Question Topic Id!!');
        }
    }

    // Sub topics methods

    public function sqts($id){
        $qts = Qtopic::where('qtId', $id)->first();
        $sqts = Qtopic::select('qtId', 'qtName')->where('parentQtId', $id)->where('qtStatus', 1)->get();

        $qTopics = array();
        $count = 0;

        foreach($sqts as $qb){
            $totalQuestions = Questionbank::where('qtId', $qb->qtId);

            if (Session::get('qaUserId')) {
                $totalQuestions = $totalQuestions->where('qwCreatedBy', Session::get('qaUserId'));
            }
            
            $totalQuestions = $totalQuestions->count();

            $qTopics[$count]['qtId'] = $qb->qtId; 
            $qTopics[$count]['qtName'] = $qb->qtName; 
            $qTopics[$count]['tqnos'] = $totalQuestions; 

            $count++;
        }

        if (Session::get('qaUserId')) {
            return view('qas/questions/sqtopics', ['qts'=>$qts, 'sqts'=>$qTopics, 'titles'=>"Question Sub Topics", 'status'=>0]);
        }

        return view('Admin/questions/sqtopics', ['qts'=>$qts, 'sqts'=>$qTopics, 'titles'=>"Question Sub Topics", 'status'=>0]);
    }

    public function sqtsTrash($id){
        $qts = Qtopic::where('qtId', $id)->first();
        $sqts = Qtopic::select('qtId', 'qtName')->where('parentQtId', $id)->where('qtStatus', 0)->get();

        $qTopics = array();
        $count = 0;

        foreach($sqts as $qb){
            $totalQuestions = Questionbank::where('qtId', $qb->qtId)->count();

            $qTopics[$count]['qtId'] = $qb->qtId; 
            $qTopics[$count]['qtName'] = $qb->qtName; 
            $qTopics[$count]['tqnos'] = $totalQuestions; 

            $count++;
        }

        return view('Admin/questions/sqtopics', ['qts'=>$qts, 'sqts'=>$qTopics, 'titles'=>"Trashed Sub Topics", 'status'=>1]);
    }


    public function addSqts(Request $req){
        $qt = new Qtopic();
        $qt->qtName = $req->title;
        $qt->parentQtId = $req->qtid;
        $qt->qbId = $req->qbid;
        $qt->parentQbId = $req->pqbid;

        if (Session::get('qaUserId')) {
            $qt->qtCreatedBy = Session::get('qaUserId');
        } else {
            $qt->qtCreatedBy = Session::get('auserId');
        }
        
        $qt->save();

        if (Session::get('qaUserId')) {
            return redirect('qas/sqts/'.$req->qtid)->with('success', 'Question Sub Topic Created Successfully!!');
        }

        return redirect('admin/sqts/'.$req->qtid)->with('success', 'Question Sub Topic Created Successfully!!');
    }
    
    public function updateSqts(Request $req){
        $qt = Qtopic::where('qtId', $req->usqtId)->first();
        $qt->qtName = $req->utitle;
        $qt->save();
        return back()->with('success', 'Question Sub Topic Updated Successfully!!');
    }

    public function removeSqts($id){
        $qt  = Qtopic::where('qtId', $id)->first();

        if(!empty($qt)){
            $qt->qtStatus = 0;
            $qt->save();

            return back()->with('success', 'Sub Question Topic Removed Successfully..');
        } else {
            return back()->with('errors', 'Invalid Sub Question Topic Id!!');
        }
    }

    public function restoreSqts($id){
        $qt  = Qtopic::where('qtId', $id)->first();

        if(!empty($qt)){
            $qt->qtStatus = 1;
            $qt->save();

            return back()->with('success', 'Sub Question Topic Restored Successfully..');
        } else {
            return back()->with('errors', 'Invalid Sub Question Topic Id!!');
        }
    }

    public function deleteSqts($id){
        $qt  = Qtopic::where('qtId', $id)->first();

        if(!empty($qt)){
            $qt->qtStatus = 2;
            $qt->save();

            return back()->with('success', 'Sub Question Topic Deleted Successfully..');
        } else {
            return back()->with('errors', 'Invalid Sub Question Topic Id!!');
        }
    }


    public function qls($id){
        $ql = Qlession::select('qlId', 'qlName')->where('qtId', $id)->where('qlStatus', 1)->get();
        $qts = Qtopic::where('qtId', $id)->first();

        $qLessions = array();
        $count = 0;

        foreach($ql as $qb){
            $totalQuestions = Questionbank::where('qlId', $qb->qlId);

            if (Session::get('qaUserId')) {
                $totalQuestions = $totalQuestions->where('qwCreatedBy', Session::get('qaUserId'));
            }
            
            $totalQuestions = $totalQuestions->count();

            $qLessions[$count]['qlId'] = $qb->qlId; 
            $qLessions[$count]['qlName'] = $qb->qlName; 
            $qLessions[$count]['tqnos'] = $totalQuestions; 

            $count++;
        }

        if (Session::get('qaUserId')) {
            return view('qas/questions/qlessions', ['qls'=>$qLessions, 'qts'=>$qts, 'titles'=>'Question Lessons', 'status'=> 0]);
        }

        return view('Admin/questions/qlessions', ['qls'=>$qLessions, 'qts'=>$qts, 'titles'=>'Question Lessons', 'status'=> 0]);
    }

    public function qlsTrash($id){
        $ql = Qlession::select('qlId', 'qlName')->where('qtId', $id)->where('qlStatus', 0)->get();
        $qts = Qtopic::where('qtId', $id)->first();

        $qLessions = array();
        $count = 0;

        foreach($ql as $qb){
            $totalQuestions = Questionbank::where('qlId', $qb->qlId)->count();

            $qLessions[$count]['qlId'] = $qb->qlId; 
            $qLessions[$count]['qlName'] = $qb->qlName; 
            $qLessions[$count]['tqnos'] = $totalQuestions; 

            $count++;
        }

        return view('Admin/questions/qlessions', ['qls'=>$qLessions, 'qts'=>$qts, 'titles'=>'Trashed Question Lessons', 'status'=>1]);
    }

    public function addQls(Request $req){
        $ql = new Qlession();
        $ql->qtId = $req->qtid;
        $ql->parentQtId = $req->pqtid;
        $ql->qbId = $req->qbid;
        $ql->parentQbId = $req->pqbid;
        $ql->qlName = $req->title;

        if (Session::get('qaUserId')) {
            $ql->qlCreatedBy = Session::get('qaUserId');
        } else {
            $ql->qlCreatedBy = Session::get('auserId');
        }

        $ql->save();

        if (Session::get('qaUserId')) {
            return redirect('qas/qls/'.$req->qtid)->with('success', 'Question Lession Created Successfully!!');
        }

        return redirect('admin/qls/'.$req->qtid)->with('success', 'Question Lession Created Successfully!!');
    }

    public function updateQls(Request $req){
        $ql = Qlession::where('qlId', $req->uqlid)->first();
        
        $ql->qlName = $req->utitle;

        $ql->save();

        return back()->with('success', 'Question Lession Updated Successfully!!');
    }

    
    public function removeQls($id){
        $qt  = Qlession::where('qlId', $id)->first();;

        if(!empty($qt)){
            $qt->qlStatus = 0;
            $qt->save();

            return back()->with('success', 'Question Lesson Removed Successfully..');
        } else {
            return back()->with('errors', 'Invalid Question Lesson Id!!');
        }
    }
    
    public function restoreQls($id){
        $qt  = Qlession::where('qlId', $id)->first();;

        if(!empty($qt)){
            $qt->qlStatus = 1;
            $qt->save();

            return back()->with('success', 'Question Lesson Restored Successfully..');
        } else {
            return back()->with('errors', 'Invalid Question Lesson Id!!');
        }
    }
    
    public function deleteQls($id){
        $qt  = Qlession::where('qlId', $id)->first();;

        if(!empty($qt)){
            $qt->qlStatus = 2;
            $qt->save();

            return back()->with('success', 'Question Lesson Deleted Successfully..');
        } else {
            return back()->with('errors', 'Invalid Question Lesson Id!!');
        }
    }

    // Question methods 


    public function qns($id){
        // $qns = Question::where('qlId', $id)->get();
        $qns = Questionbank::where('qlId', $id);

        if (Session::get('qaUserId')) {
            $qns = $qns->where('qwCreatedBy', Session::get('qaUserId'));
        }
        
        $qns = $qns->where('qwStatus', 1)->get();

        // dd($qns);

        $qls = Qlession::where('qlId', $id)->first();

        if (Session::get('qaUserId')) {
            return view('qas/questions/questions', ['qns'=>$qns, 'qls'=>$qls]);
        }

        return view('Admin/questions/questions', ['qns'=>$qns, 'qls'=>$qls]);
    }
    
    public function trashQns($id){
        // $qns = Question::where('qlId', $id)->get();
        $qns = Questionbank::where('qlId', $id)
                ->where('qwStatus', 0)
                ->get();

        $qls = Qlession::where('qlId', $id)->first();
        
        return view('Admin/questions/questionTrash', ['qns'=>$qns, 'qls'=>$qls]);
    }
    // public function newQns($id){
    //     $qls = Qlession::where('qlId', $id)->first();
    //     return view('admin/questions/addQuestion', ['qls'=>$qls]);
    // }
    public function newMCQns($id){
        $qls = Qlession::where('qlId', $id)->first();

        if (Session::get('qaUserId')) {
            return view('qas/questions/addMCQ', ['qls'=>$qls]);
        }
        return view('Admin/questions/addMCQ', ['qls'=>$qls]);
    }
    public function newMSQns($id){
        $qls = Qlession::where('qlId', $id)->first();

        if (Session::get('qaUserId')) {
            return view('qas/questions/addMSQ', ['qls'=>$qls]);
        }
        return view('Admin/questions/addMSQ', ['qls'=>$qls]);
    }
    public function newNATQns($id){
        $qls = Qlession::where('qlId', $id)->first();

        if (Session::get('qaUserId')) {
            return view('qas/questions/addNAT', ['qls'=>$qls]);
        }
        return view('Admin/questions/addNAT', ['qls'=>$qls]);
    }
    public function newPRQns($id){
        $qls = Qlession::where('qlId', $id)->first();

        if (Session::get('qaUserId')) {
            return view('qas/questions/addPRQ', ['qls'=>$qls]);
        }
        return view('Admin/questions/addPRQ', ['qls'=>$qls]);
    }
    public function addMCQns(Request $req){
        // dd($req);
        $qls = Qlession::where('qlId', $req->qlId)->first();
        $qns = new Questionbank();
        $qns->pqbId = $qls->parentQbId;
        $qns->qbId = $qls->qbId;
        $qns->pqtId = $qls->parentQtId;
        $qns->qtId = $qls->qtId;
        $qns->qlId = $qls->qlId;
        $qns->qwTitle = $req->question;
        $qns->qwType = "radio";

        if($req->totalOptions){
            $qns->totalOptions = $req->totalOptions;
            $opt_values = [];
            $opt_keys = [];
            for($i = 0; $i< $req->totalOptions; $i++){
                $i2 = $i+1;
                $opt_keys[$i] = 'option'.$i2;
                $opt_values[$i] = $req->input('option'.$i2);
            }
            $options = array_combine($opt_keys, $opt_values);
            $qns->qwOptions = json_encode($options);
        }
        $qns->qwCorrectAnswer= $req->correctAns;
        if($req->hint){
            $qns->qwHint = $req->hint;
        }
        $qns->qwLevel = $req->level;

        if (Session::get('qaUserId')) {
            $qns->qwCreatedBy = Session::get('qaUserId');
        } else {
            $qns->qwCreatedBy = Session::get('auserId');
        }

        $qns->save();

        if (Session::get('qaUserId')) {
            return redirect('qas/qns/mcq/new/'.$req->qlId)->with('success', 'Question Added Successfully!!');
        }

        return redirect('admin/qns/mcq/new/'.$req->qlId)->with('success', 'Question Added Successfully!!');
    }
    public function addMSQns(Request $req){
        // dd($req);
        $qls = Qlession::where('qlId', $req->qlId)->first();
        $qns = new Questionbank();
        $qns->pqbId = $qls->parentQbId;
        $qns->qbId = $qls->qbId;
        $qns->pqtId = $qls->parentQtId;
        $qns->qtId = $qls->qtId;
        $qns->qlId = $qls->qlId;
        $qns->qwTitle = $req->question;
        $qns->qwType = "checkbox";

        if($req->totalOptions){
            $qns->totalOptions = $req->totalOptions;
            $opt_values = [];
            $opt_keys = [];
            for($i = 0; $i< $req->totalOptions; $i++){
                $i2 = $i+1;
                $opt_keys[$i] = 'option'.$i2;
                $opt_values[$i] = $req->input('option'.$i2);
            }
            $options = array_combine($opt_keys, $opt_values);
            $qns->qwOptions = json_encode($options);
        }
        $qns->qwCorrectAnswer= $req->correctAns;
        if($req->hint){
            $qns->qwHint = $req->hint;
        }
        $qns->qwLevel = $req->level;
        
        if (Session::get('qaUserId')) {
            $qns->qwCreatedBy = Session::get('qaUserId');
        } else {
            $qns->qwCreatedBy = Session::get('auserId');
        }
        $qns->save();

        if (Session::get('qaUserId')) {
            return redirect('qas/qns/msq/new/'.$req->qlId)->with('success', 'Question Added Successfully!!');
        }

        return redirect('admin/qns/msq/new/'.$req->qlId)->with('success', 'Question Added Successfully!!');
    }
    public function addNATQns(Request $req){
        // dd($req);
        $qls = Qlession::where('qlId', $req->qlId)->first();
        $qns = new Questionbank();
        $qns->pqbId = $qls->parentQbId;
        $qns->qbId = $qls->qbId;
        $qns->pqtId = $qls->parentQtId;
        $qns->qtId = $qls->qtId;
        $qns->qlId = $qls->qlId;
        $qns->qwTitle = $req->question;
        $qns->qwType = "nat";
        $qns->qwCorrectAnswer= $req->correctAns;

        if ($req->minAns) {
            $qns->qwMinRange= $req->minAns;
        }

        if ($req->maxAns) {
            $qns->qwMaxRange= $req->maxAns;
        }
        
        if($req->hint){
            $qns->qwHint = $req->hint;
        }
        $qns->qwLevel = $req->level;
        
        if (Session::get('qaUserId')) {
            $qns->qwCreatedBy = Session::get('qaUserId');
        } else {
            $qns->qwCreatedBy = Session::get('auserId');
        }

        $qns->save();

        if (Session::get('qaUserId')) {
            return redirect('qas/qns/nat/new/'.$req->qlId)->with('success', 'Question Added Successfully!!');
        }

        return redirect('admin/qns/nat/new/'.$req->qlId)->with('success', 'Question Added Successfully!!');
    }
    
    public function addQns(Request $req){
        // dd($req);
        $qls = Qlession::where('qlId', $req->qlId)->first();
        $qns = new Questionbank();
        $qns->pqbId = $qls->parentQbId;
        $qns->qbId = $qls->qbId;
        $qns->pqtId = $qls->parentQtId;
        $qns->qtId = $qls->qtId;
        $qns->qlId = $qls->qlId;
        $qns->qwTitle = $req->question;
        $qns->qwType = $req->questiontype;
        if($req->paragraphid){
            $qns->paragraphId = $req->paragraphid;
        }
        if($req->totalOptions){
            $qns->totalOptions = $req->totalOptions;
            $opt_values = [];
            $opt_keys = [];
            for($i = 0; $i< $req->totalOptions; $i++){
                $i2 = $i+1;
                $opt_keys[$i] = 'option'.$i2;
                $opt_values[$i] = $req->input('option'.$i2);
            }
            $options = array_combine($opt_keys, $opt_values);
            $qns->qwOptions = json_encode($options);
        }
        $qns->qwCorrectAnswer= $req->correctAns;
        if($req->hint){
            $qns->qwHint = $req->hint;
        }
        $qns->qwLevel = $req->level;
        
        if (Session::get('qaUserId')) {
            $qns->qwCreatedBy = Session::get('qaUserId');
        } else {
            $qns->qwCreatedBy = Session::get('auserId');
        }

        $qns->save();

        if (Session::get('qaUserId')) {
            return redirect('qas/qns/pr/new/'.$req->qlId)->with('success', 'Question Added Successfully!!');
        }

        return redirect('admin/qns/pr/new/'.$req->qlId)->with('success', 'Question Added Successfully!!');
    }
 
    public function newPara($id){
        $qls = Qlession::where('qlId', $id)->first();

        if (Session::get('qaUserId')) {
            return view('qas/questions/addParagraph', ['qls'=>$qls]);
        }
        return view('Admin/questions/addParagraph', ['qls'=>$qls]);
    }

    public function addPara(Request $req){
        $qls = Qlession::where('qlId', $req->qlId)->first();
        $qns = new Paragraph();
        $qns->pqbId = $qls->parentQbId;
        $qns->qbId = $qls->qbId;
        $qns->pqtId = $qls->parentQtId;
        $qns->qtId = $qls->qtId;
        $qns->qlId = $qls->qlId;
        $qns->prgContent = $req->paragraph;
        
        if (Session::get('qaUserId')) {
            $qns->createdBy = Session::get('qaUserId');
        } else {
            $qns->createdBy = Session::get('auserId');
        }
        
        $qns->save();

        if (Session::get('qaUserId')) {
            return redirect('qas/qns/newPara/'.$req->qlId)->with('success', 'Paragraph Added Successfully!!');
        }

        return redirect('admin/qns/newPara/'.$req->qlId)->with('success', 'Paragraph Added Successfully!!');
    }

    public function listPara($id){
        $qls = Qlession::where('qlId', $id)->first();

        $paras = Paragraph::where('qlId', $id);

        if (Session::get('qaUserId')) {
            $paras = $paras->where("createdBy", Session::get('qaUserId'));
        }

        $paras = $paras->get();
        
        if (Session::get('qaUserId')) {
            return view('qas/questions/listParagraphs', ['qls'=>$qls, 'paras'=>$paras]);     
        }

        return view('Admin/questions/listParagraphs', ['qls'=>$qls, 'paras'=>$paras]);
    }

    public function listMCQ($id){
        $qls = Qlession::where('qlId', $id)->first();

        $qns = Questionbank::where('qlId', $id)->where('paragraphId', '0')->where('qwType', 'radio'); 
        
        if (Session::get('qaUserId')) {
            $qns = $qns->where('qwCreatedBy', Session::get('qaUserId'));
        }
        $qns = $qns->get();

        if (Session::get('qaUserId')) {
            return view('qas/questions/questions', ['qns'=>$qns, 'qls'=>$qls]);
        }
        return view('Admin/questions/questions', ['qns'=>$qns, 'qls'=>$qls]);
    }

    public function listMSQ($id){
        $qls = Qlession::where('qlId', $id)->first();

        $qns = Questionbank::where('qlId', $id)->where('paragraphId', '0')->where('qwType', 'checkbox')->get(); 
        
        if (Session::get('qaUserId')) {
            $qns = $qns->where('qwCreatedBy', Session::get('qaUserId'));
        }
        $qns = $qns->get();

        if (Session::get('qaUserId')) {
            return view('qas/questions/questions', ['qns'=>$qns, 'qls'=>$qls]);
        }
        return view('Admin/questions/questions', ['qns'=>$qns, 'qls'=>$qls]);
    }

    public function listNAT($id){
        $qls = Qlession::where('qlId', $id)->first();

        $qns = Questionbank::where('qlId', $id)->where('paragraphId', '0')->where('qwType', 'nat')->get(); 
        
        if (Session::get('qaUserId')) {
            $qns = $qns->where('qwCreatedBy', Session::get('qaUserId'));
        }
        $qns = $qns->get();

        if (Session::get('qaUserId')) {
            return view('qas/questions/questions', ['qns'=>$qns, 'qls'=>$qls]);
        }
        return view('Admin/questions/questions', ['qns'=>$qns, 'qls'=>$qls]);
    }

    public function listPRQ($id){
        $qls = Qlession::where('qlId', $id)->first();

        $qns = Questionbank::where('qlId', $id)->where('paragraphId','!=', '0')->get(); 
        
        if (Session::get('qaUserId')) {
            $qns = $qns->where('qwCreatedBy', Session::get('qaUserId'));
        }
        $qns = $qns->get();

        if (Session::get('qaUserId')) {
             return view('qas/questions/questions', ['qns'=>$qns, 'qls'=>$qls]);
        }
        return view('Admin/questions/questions', ['qns'=>$qns, 'qls'=>$qls]);
    }

    public function editMCQ($id){
        $qls = Questionbank::where('qwId', $id)->first();
        
        if (Session::get('qaUserId')) {
            return view('qas/questions/editMCQ', ['qls'=>$qls]);
        }
        return view('Admin/questions/editMCQ', ['qls'=>$qls]);
    }

    public function editMSQ($id){
        $qls = Questionbank::where('qwId', $id)->first();
        
        if (Session::get('qaUserId')) {
            return view('qas/questions/editMSQ', ['qls'=>$qls]);
        }
        return view('Admin/questions/editMSQ', ['qls'=>$qls]);
    }

    public function editNAT($id){
        $qls = Questionbank::where('qwId', $id)->first();
        
        if (Session::get('qaUserId')) {
            return view('qas/questions/editNAT', ['qls'=>$qls]);
        }
        return view('Admin/questions/editNAT', ['qls'=>$qls]);
    }

    public function editPRQ($id){
        $qls = Questionbank::where('qwId', $id)->first();
        
        if (Session::get('qaUserId')) {
            return view('qas/questions/editPRQ', ['qls'=>$qls]);
        }
        return view('Admin/questions/editPRQ', ['qls'=>$qls]);
    }

    public function updateMCQns(Request $req){
        // dd($req);
        $qns = Questionbank::where('qwId', $req->qwId)->first();

        
        $qns->qwTitle = $req->question;
        // $qns->qwType = "radio";

        if($req->totalOptions){
            $qns->totalOptions = $req->totalOptions;
            $opt_values = [];
            $opt_keys = [];
            for($i = 0; $i< $req->totalOptions; $i++){
                $i2 = $i+1;
                $opt_keys[$i] = 'option'.$i2;
                $opt_values[$i] = $req->input('option'.$i2);
            }
            $options = array_combine($opt_keys, $opt_values);
            $qns->qwOptions = json_encode($options);
        }
        $qns->qwCorrectAnswer= $req->correctAns;
        if($req->hint){
            $qns->qwHint = $req->hint;
        }
        $qns->qwLevel = $req->level;
        // $qns->qwCreatedBy = Session::get('auserId');

        $qns->save();

        if (Session::get('qaUserId')) {
            return redirect('qas/qns/'.$req->qlId)->with('success', 'Question Updated Successfully!!');
        }

        return redirect('admin/qns/'.$req->qlId)->with('success', 'Question Updated Successfully!!');
    }
    public function updateMSQns(Request $req){
        // dd($req);
        // $qls = Qlession::where('qlId', $req->qlId)->first();
        $qns = Questionbank::where('qwId', $req->qwId)->first();
        
        $qns->qwTitle = $req->question;
        // $qns->qwType = "checkbox";

        if($req->totalOptions){
            $qns->totalOptions = $req->totalOptions;
            $opt_values = [];
            $opt_keys = [];
            for($i = 0; $i< $req->totalOptions; $i++){
                $i2 = $i+1;
                $opt_keys[$i] = 'option'.$i2;
                $opt_values[$i] = $req->input('option'.$i2);
            }
            $options = array_combine($opt_keys, $opt_values);
            $qns->qwOptions = json_encode($options);
        }
        $qns->qwCorrectAnswer= $req->correctAns;
        if($req->hint){
            $qns->qwHint = $req->hint;
        }
        $qns->qwLevel = $req->level;
        // $qns->qwCreatedBy = Session::get('auserId');

        $qns->save();

        if (Session::get('qaUserId')) {
            return redirect('qas/qns/'.$req->qlId)->with('success', 'Question Updated Successfully!!');
        }

        return redirect('admin/qns/'.$req->qlId)->with('success', 'Question Updated Successfully!!');
    }
    public function updateNATQns(Request $req){
        // dd($req);
        $qns = Questionbank::where('qwId', $req->qwId)->first();
        
        $qns->qwTitle = $req->question;
        // $qns->qwType = "nat";
        $qns->qwCorrectAnswer= $req->correctAns;

        if ($req->minAns) {
            $qns->qwMinRange= $req->minAns;
        }

        if ($req->maxAns) {
            $qns->qwMaxRange= $req->maxAns;
        }

        if($req->hint){
            $qns->qwHint = $req->hint;
        }
        $qns->qwLevel = $req->level;
        // $qns->qwCreatedBy = Session::get('auserId');

        $qns->save();

        if (Session::get('qaUserId')) {
            return redirect('qas/qns/'.$req->qlId)->with('success', 'Question Updated Successfully!!');
        }

        return redirect('admin/qns/'.$req->qlId)->with('success', 'Question Updated Successfully!!');
    }
    
    public function updateQns(Request $req){
        // dd($req);
        $qns = Questionbank::where('qwId', $req->qwId)->first();
       
        $qns->qwTitle = $req->question;
        $qns->qwType = $req->questiontype;
        if($req->paragraphid){
            $qns->paragraphId = $req->paragraphid;
        }
        if($req->totalOptions){
            $qns->totalOptions = $req->totalOptions;
            $opt_values = [];
            $opt_keys = [];
            for($i = 0; $i< $req->totalOptions; $i++){
                $i2 = $i+1;
                $opt_keys[$i] = 'option'.$i2;
                $opt_values[$i] = $req->input('option'.$i2);
            }
            $options = array_combine($opt_keys, $opt_values);
            $qns->qwOptions = json_encode($options);
        }
        $qns->qwCorrectAnswer= $req->correctAns;
        if($req->hint){
            $qns->qwHint = $req->hint;
        }
        $qns->qwLevel = $req->level;
        // $qns->qwCreatedBy = Session::get('auserId');

        $qns->save();

        if (Session::get('qaUserId')) {
            return redirect('qas/qns/'.$req->qlId)->with('success', 'Question Updated Successfully!!');
        }

        return redirect('admin/qns/'.$req->qlId)->with('success', 'Question Updated Successfully!!');
    }

    // Preview Questions
    public function previewQuestion($id) {
        $qns = Questionbank::where('qwId', $id)->first();

        $para = null;
        if ($qns->paragraphId != 0){
            $para = Paragraph::where('prgId', $qns->paragraphId)->first();
        }
        // dd($para);
        if (Session::get('qaUserId')) {
            return view("qas/questions/previewQns", ['qns'=>$qns, 'paragraphs'=>$para]);
        }

        return view("Admin/questions/previewQns", ['qns'=>$qns, 'paragraphs'=>$para]);
    }
 
    public function newUploadMCQ($id){
        $qls = Qlession::where('qlId', $id)->first();
        
        if (Session::get('qaUserId')) {
            return view('qas/questions/importMCQ', ['qls'=>$qls]);
        }

        return view('Admin/questions/importMCQ', ['qls'=>$qls]);
    }

    public function downloadFormat(){
        $file= public_path("/dwns/mcqFormatNew.xlsx");
        return response()->download($file);
    }

    public function uploadMCQ(Request $req){
        Excel::import(new QuestionImport, $req->file);

        if (Session::get('qaUserId')) {
            return redirect('qas/qns/'.$req->qlId)->with('success', 'Question Inserted Successfully!!');
        }

        return redirect('admin/qns/'.$req->qlId)->with('success', 'Question Inserted Successfully!!');
    }

    // Delete Questions
    public function removeQns($id){
        $question  = Questionbank::where('qwId', $id)->first();
        if(!empty($question)){
            $question->qwStatus = 0;
            $question->save();

            return back()->with('success', 'Question Removed Successfully..');
        } else {
            return back()->with('errors', 'Invalid Question Id!!');
        }
    }
    
    public function restoreQns($id){
        $question  = Questionbank::where('qwId', $id)->first();
        if(!empty($question)){
            $question->qwStatus = 1;
            $question->save();

            return back()->with('success', 'Question Restored Successfully..');
        } else {
            return back()->with('errors', 'Invalid Question Id!!');
        }
    }
    
    public function deleteQns($id){
        $question  = Questionbank::where('qwId', $id)->first();
        if(!empty($question)){
            $question  = Questionbank::where('qwId', $id)->delete();

            return back()->with('success', 'Question Deleted Successfully..');
        } else {
            return back()->with('errors', 'Invalid Question Id!!');
        }
    }

    // Data Accessors methods
    public function fetchqbs(){
        $qbs = Qbank::where('parentQbId', null)->where('qbStatus', 1)->get();
        return json_encode(array('data'=>$qbs));
    }
    public function fetchsqbs(Request $req){
        $qbs = Qbank::where('parentQbId', $req->pqbId)->where('qbStatus', 1)->get();
        return json_encode(array('data'=>$qbs));
    }
    public function fetchqts(Request $req){
        $qbs = Qtopic::where('qbId', $req->qbId)->where('parentQtId', null)->get();
        return json_encode(array('data'=>$qbs));
    }
    public function fetchsqts(Request $req){
        $qbs = Qtopic::where('parentQtId', $req->pqtId)->get();
        return json_encode(array('data'=>$qbs));
    }
    public function fetchqls(Request $req){
        $qbs = Qlession::where('qtId', $req->qtId)->get();
        return json_encode(array('data'=>$qbs));
    }

}
