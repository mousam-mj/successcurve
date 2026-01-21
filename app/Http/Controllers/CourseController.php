<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Course;
use App\Subject;
use App\User;
use App\Classe;
use App\Week;
use App\Lecture;
use App\Lecturequestion;
use App\Questionbank;
use App\Courseenroll;
use App\Purchasecourse;
use App\Coupon;
use App\Couponenroll;
use App\Exports\CourseUsersExport;
use Maatwebsite\Excel\Facades\Excel;

use Carbon\Carbon;
use Razorpay\Api\Api;
use Razorpay\Api\Errors\SignatureVerificationError;

class CourseController extends Controller
{
    public function courses(){

        if (Session::get('auserId')) {
            $course = Course::join('classes', 'courses.courseClass', '=', 'classes.classId')
                ->join('users', 'courses.courseInstructor1', '=', 'users.id')
                ->select('courses.*',  'classes.className as className', 'users.name as name')
                ->where('courseStatus', '!=', 'Removed')
                ->orderBy('courseId', 'desc')
                ->get();

            return view('Admin/courses/courses',['courses'=>$course]);
        } else if (Session::get('fuserId')) {

            $course = Course::join('classes', 'courses.courseClass', '=', 'classes.classId')
                ->join('users', 'courses.courseInstructor1', '=', 'users.id')
                ->select('courses.*',  'classes.className as className', 'users.name as name')
                ->where('courseInstructor1', Session::get('fuserId'))
                ->whereIn('courseStatus', ['Pending', "Published"])
                ->orderBy('courseId', 'desc')
                ->get();
            return view('Faculty/courses/courses',['courses'=>$course]);
        }
    
    }

    public function coursesTrash(){

        if (Session::get('auserId')) {
            $course = Course::join('classes', 'courses.courseClass', '=', 'classes.classId')
                ->join('users', 'courses.courseInstructor1', '=', 'users.id')
                ->select('courses.*',  'classes.className as className', 'users.name as name')
                ->where('courseStatus', '=', 'Removed')
                ->orderBy('courseId', 'desc')
                ->get();

            return view('Admin/courses/coursesTrash',['courses'=>$course]);
        } else if (Session::get('fuserId')) {

            $course = Course::join('classes', 'courses.courseClass', '=', 'classes.classId')
                ->join('users', 'courses.courseInstructor1', '=', 'users.id')
                ->select('courses.*',  'classes.className as className', 'users.name as name')
                ->where('courseInstructor1', Session::get('fuserId'))
                ->where('courseStatus', "Removed")
                ->orderBy('courseId', 'desc')
                ->get();
            return view('Faculty/courses/coursesTrash',['courses'=>$course]);
        }
    
    }

    public function filterCourse(Request $req){
        $course = Course::join('classes', 'courses.courseClass', '=', 'classes.classId')
            ->join('users', 'courses.courseInstructor1', '=', 'users.id')
            ->select('courses.*',  'classes.className as className', 'users.name as name')
            ->where('courseStatus', '!=', 'Removed');

            if ($req->cls > 0) {
                $course = $course->where('courseClass', $req->cls);
            }
    
            if ($req->subject > 0) {
                $course = $course->where('courseSubject', $req->subject);
            }

            if (Session::get('fuserId')) {
                $course = $course->where("courseInstructor1", Session::get('fuserId'))->whereIn('courseStatus', ['Pending', "Published"]);
            }

            $course = $course->orderBy('courseId', 'desc')->get();

        if (Session::get('auserId')) {
            return view('Admin/courses/courses',['courses'=>$course]);
        } else if (Session::get('fuserId')) {
            return view('Faculty/courses/courses',['courses'=>$course]);
        }
        
    }

    public function generateURI(){
        $courses = Course::select('courseId')->get();

        foreach($courses as $course){
            $cors = Course::where('courseId', $course->courseId)->first();

            $cors->courseURI = str_replace(' ', '-', $cors->courseTitle);

            $cors->save();
        }

        dd("Course URI generated");
    }

    function createCourse(Request $req){
        $course = new Course;
        $courseCode = $req->input('coursecode');
        $subject = $req->input('subject');
        $subjectName = Subject::where('subjectId', $subject)->value('subjectName');

        $cls = $req->input('cls');
        $clsName = Classe::where('classId', $cls)->value('className');

        $instructor = '';
        $instructorName = '';

        if (Session::get('fuserId')) {
            $instructor = Session::get('fuserId');
            $instructorName = Session::get('fuserName');
        } else{
            $instructor = $req->input('instructor');
            $instructorName = User::where('id', $instructor)->value('name');
        }
        
        $instructor2 = '';
        if(!empty($req->input('instructor2'))){
            $instructor2 = $req->input('instructor2');
             $instructorName2 = User::where('id', $instructor2)->value('name');
        }
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
            $course->courseURI = $req->uri;
            $course->courseCode = $courseCode;
            $course->courseSubject = $subject;
            $course->courseClass = $cls;
            $course->courseInstructor1 = $instructor;

            if(!empty($instructor2)){
                 $course->courseInstructor2= $instructor2;
            }

            if ($req->price) {
                $course->coursePrice = $req->price;
            }

            if ($req->validity) {
                $course->courseValidity = $req->validity;
            }

            $course->courseDescription = $req->input('description');
            if($req->hasFile('image')){
                $image = $req->file('image');
                $dir = public_path('imgs/courses');
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
            
            if (Session::get('auserId')) {
                return redirect('admin/courses')->with('success','Course Created Successfully!');
            } else if (Session::get('fuserId')) {
                return redirect('faculty/courses')->with('success','Course Created Successfully!');
            }
           
        }
    }
    function editCourse($id){

        $data = Course::where('courseId', $id)->first();
        if (Session::get('auserId')) {
            return view('Admin/courses/editCourse', ['courses'=> $data]);
        } else if (Session::get('fuserId')) {
            return view('Faculty/courses/editCourse', ['courses'=> $data]);
        }
        
    }


    function editCourseContent(Request $req){
        $courseId = $req->input('courseId');

        $data = Course::where('courseId', $courseId)->first();

        $data->courseTitle = $req->input('name');
        $data->courseCode = $req->input('coursecode');
        $data->courseSubject = $req->input('subject');
        $data->courseClass = $req->input('cls');
        
        if ($req->input('instructor')) {
            $data->courseInstructor1 = $req->input('instructor');
        }
        if($req->input('instructor2')){
            $data->courseInstructor2 = $req->input('instructor2');
        }
        if ($req->price) {
            $data->coursePrice = $req->price;
        }

        if ($req->validity) {
            $data->courseValidity = $req->validity;
        }

        $data->courseDescription = $req->input('description');

        if($req->hasFile('image')){
            $image = $req->file('image');
            $dir = public_path('imgs/courses');
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

        if (Session::get('auserId')) {
            return redirect('admin/courses')->with('success', 'Course Updated Successfully!!');
        } else if (Session::get('fuserId')) {
            return redirect('faculty/courses')->with('success', 'Course Updated Successfully!!');
        }
        
    }

    public function removeCourse($id){

        $data = Course::where('courseId', $id)->first();

        if (!empty($data)) {
            $data->courseStatus = "Removed";
            $data->save();

            return back()->with('success', 'Course Removed Successfully..');
        } else {
            return back()->with('errors', 'Invalid Course Id..');
        }
    }
    public function restoreCourse($id){

        $data = Course::where('courseId', $id)->first();

        if (!empty($data)) {
            $data->courseStatus = "Published";
            $data->save();

            return back()->with('success', 'Course Restored Successfully..');
        } else {
            return back()->with('errors', 'Invalid Course Id..');
        }
    }
    public function deleteCourse($id){

        $data = Course::where('courseId', $id)->first();

        if (!empty($data)) {
            Course::where('courseId', $id)->delete();

            return back()->with('success', 'Course Deleted Successfully..');
        } else {
            return back()->with('errors', 'Invalid Course Id..');
        }
    }

    public function courseUsers($id){
        $course = Course::where('courseId', $id)->first();

        if(!empty($course)){
            $users = Courseenroll::join('users', 'users.id', '=', 'courseenrolls.userId')->select('users.id as userId', 'users.name as userName', 'users.contact as userContact', 'users.email as userEmail')->where('courseId', $id)->get();

            if (Session::get('auserId')) {
                return view('Admin/courses/courseUsers', ['users'=>$users, 'courses'=>$course]);
            } elseif(Session::get('fuserId')) {
                return view('Faculty/courses/courseUsers', ['users'=>$users, 'tests'=>$course]);
            }
        }else{
            return back()->with('errors', 'Invalid Test Id..!!');
        }
    }

    public function exportCourseUsers($id){
        return Excel::download(new CourseUsersExport($id), 'course-'.$id.'-Users.xlsx');
    }

    public function modules($id){
        $modules = Week::where('courseId', $id)->get();

        $crs =  Course::where('courseId', $id)->first();
        
        if (Session::get('auserId')) {
            return view('Admin/courses/modules', ['crs'=>$crs, 'modules'=>$modules]);
        } else if (Session::get('fuserId')) {
            return view('Faculty/courses/modules', ['crs'=>$crs, 'modules'=>$modules]);
        }
    }

    function addModule(Request $req){
        $week = new Week;
        $week->courseId = $req->courseId;
        $week->weekname = $req->name;
        $week->save();

        if (Session::get('auserId')) {
            return redirect('admin/courses/modules/'.$req->courseId)->with('success','Module is Added to The Course');
        } else if (Session::get('fuserId')) {
            return redirect('faculty/courses/modules/'.$req->courseId)->with('success','Module is Added to The Course');
        }
        
    }
    function editModule(){
        $course = Course::get();
        return view('Admin/editModule',['courses'=>$course]);
    }
    function editModuleContent(Request $req){
        if($req->input('course') >=1 ){
            if($req->input('week') >= 1){
                $week = Week::where('weekId', $req->input('week'))->first();
                $week->courseId=$req->input('course');
                $week->weekname = $req->input('name');
                $week->save();

                if (Session::get('auserId')) {
                    return redirect('admin/editModule')->with('success','Module Updated Successfully');
                } else if (Session::get('fuserId')) {
                    return redirect('faculty/editModule')->with('success','Module Updated Successfully');
                }
                
            }else{

                if (Session::get('auserId')) {
                    return redirect('admin/editModule')->with('errors','Please Select a Module First!');
                } else if (Session::get('fuserId')) {
                    return redirect('faculty/editModule')->with('errors','Please Select a Module First!');
                } 
            }
        }else{

            if (Session::get('auserId')) {
                return redirect('admin/editModule')->with('errors','Please Select a Course First!');
            } else if (Session::get('fuserId')) {
                return redirect('faculty/editModule')->with('errors','Please Select a Course First!');
            }
        }
    }

    public function lectures($id){
        $lectures = Lecture::where('weekId', $id)->get();

        $modules = Week::where('weekId', $id)->first();

        if (Session::get('auserId')) {
            return view('Admin/courses/lectures', ['lectures'=>$lectures, 'modules'=> $modules]);
        } else if (Session::get('fuserId')) {
            return view('Faculty/courses/lectures', ['lectures'=>$lectures, 'modules'=> $modules]);
        }
    }

    public function newLecture($id){
        $modules = Week::where('weekId', $id)->first();

        if (Session::get('auserId')) {
            return view('Admin/courses/addLecture', ['modules'=>$modules]);
        } else if (Session::get('fuserId')) {
            return view('Faculty/courses/addLecture', ['modules'=>$modules]);
        }
    }

    function addLecture(Request $req){
        $lecture = new Lecture();
        $lecture->courseId = $req->courseId;
        $lecture->weekId = $req->moduleId;
        $lecture->lectureTitle = $req->input('name');
        $lecture->lectureType = $req->type;
        if($req->type == 0){
            $lecture->lectureVideo = $req->input('video');
            $lecture->lectureContent = $req->input('description');
        }
        $lecture->save();

        if (Session::get('auserId')) {
            return redirect('admin/courses/lectures/'.$req->moduleId)->with('success','Lecture Created Successfully');
        } else if (Session::get('fuserId')) {
            return redirect('faculty/courses/lectures/'.$req->moduleId)->with('success','Lecture Created Successfully');
        }
    }

    function editLecture(){
        $course = Course::get();

        if (Session::get('auserId')) {
            return view('Admin/editLecture',['courses'=>$course]);
        } else if (Session::get('fuserId')) {
            return view('Faculty/editLecture',['courses'=>$course]);
        }
    }

    function editLecture2(Request $req){
        $lectureId = $req->input('lecture');
        $lecture = Lecture::where('lectureId',$lectureId)->get();

        if (Session::get('auserId')) {
            return view('Admin/editLectureContent',['courses'=>$lecture]);
        } else if (Session::get('fuserId')) {
            return view('Faculty/editLectureContent',['courses'=>$lecture]);
        }
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
        $success =  'Lecture Is Updated Successfully!';

        if (Session::get('auserId')) {
            return redirect('admin/dashboard')->with('success', $success);
        } else if (Session::get('fuserId')) {
            return redirect('faculty/dashboard')->with('success', $success);
        }
    }

    public function lecqns($id){
        $qns = Lecturequestion::join('questionbanks', 'questionbanks.qwId', '=', 'lecturequestions.qId')
        ->select('lecturequestions.*','questionbanks.qwTitle','questionbanks.qwType','questionbanks.qwCorrectAnswer','questionbanks.paragraphId')->where('lId', $id)->get();
        $lecs = Lecture::where('lectureId', $id)->first();

        if (Session::get('auserId')) {
            return view('Admin/courses/lecQns', ['lecs'=>$lecs, 'qns'=>$qns]);
        } else if (Session::get('fuserId')) {
            return view('Faculty/courses/lecQns', ['lecs'=>$lecs, 'qns'=>$qns]);
        }
    }

    public function newlecqns($id){
        $lecs = Lecture::where('lectureId', $id)->first();

        if (Session::get('auserId')) {
            return view('Admin/courses/addLecQns',['lecs'=>$lecs]);
        } else if (Session::get('fuserId')) {
            return view('Faculty/courses/addLecQns',['lecs'=>$lecs]);
        } 
    }

    public function removeLecQns($id) {
        $qns = Lecturequestion::where('lId', $id)->first();

        if (!empty($qns)) {
            Lecturequestion::where('lId', $id)->delete();
            return back()->with('success', "Question Deleted Successfully!!");
        } else {
            return back()->with('errors', "Invalid Question Id!!");
        }
    }

    function getLectureQuestions(Request $req){
        
        $tques = Lecturequestion::select('qId')->where('lId', $req->lecId)->get();
        //dd('questions '.$tques);
        $qsid = [];
        $count = 0;
        foreach($tques as $qid){
            $qsid[$count++] = $qid->qId;
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
    public function addLecQns(Request $req){
        $alqws = Lecturequestion::where('lId', $req->lecId)->where('qId', $req->qid)->first();

        if(empty($alqws)){

            $tqs = Questionbank::where('qwId', $req->qid)->first();
            //dd($tqs->qwMarks);
           

            $tq = new Lecturequestion;
            $tq->lId = $req->lecId;
            $tq->qId = $req->qid;
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
    
    function removeSectionQuestion($qid,$lecId){
        
        $qw = Lecturequestion::where('qId',$qid)->where('lecId',$lecId)->delete();

        if (Session::get('auserId')) {
            return redirect('admin/lession/qns/'.$lecId)->with('errors','question removed from Practice Set');
        } else if (Session::get('fuserId')) {
            return redirect('faculty/lession/qns/'.$lecId)->with('errors','question removed from Practice Set');
        }
    }

    public function purchaseCourse(Request $req){
        $course = Course::join('users', 'courses.courseInstructor1', '=', 'users.id')->select('courses.*', 'users.name as userName')->where('courseId', $req->courseId)->first();

        if(!empty($course) && $course->coursePrice != null && $course->coursePrice > 0){
            $buyc = Purchasecourse::where('courseId', $req->courseId)->where('userId', Session::get('userId'))->where('paymentStatus', 0)->first();
            
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

                    if ($coupon->cpFor == 1 || $coupon->cpFor == 2) {

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
                    if ($buyc->couponCode != null && $buyc->couponCode == $req->couponCode && $buyc->created_at > $course->updated_at) {

                        // if the coupon code was applied erlier and now are same  

                        $data = [
                            'orderId'=>$buyc->orderId,
                            'amount' => $buyc->amount,
                            'name'=>$course->courseTitle,
                            'key'=>config("razor.razor_key"),
                        ];
                    } else{

                        // if the coupon code was applied erlier and now are not same 

                        $amount = $course->coursePrice - floor(($course->coursePrice * $coupon->cpDiscount) / 100);
                        
                        $api = new Api(config('razor.razor_key'), config('razor.razor_secret'));
                        $order  = $api->order->create(array('receipt' => '123', 'amount' => $amount * 100 , 'currency' => 'INR')); // Creates order
                        $orderId = $order['id'];

                        $pur = new Purchasecourse();
                        $pur->userId = Session::get('userId');
                        $pur->courseId = $req->courseId;
                        $pur->couponCode = $req->couponCode;
                        $pur->amount = $amount;
                        $pur->orderId = $orderId;
                        $pur->save();
                        $data = [
                            'orderId'=>$orderId,
                            'amount' => $amount,
                            'name'=>$course->courseTitle,
                            'key'=>config("razor.razor_key"),
                        ];
                    }
                } else {
                    // dd('invalid coupon');
                    // if the coupon code was in not valid

                    if ($buyc->couponId == null && $buyc->created_at > $course->updated_at) {

                        // if the coupon code is & was not applied

                        $data = [
                            'orderId'=>$buyc->orderId,
                            'amount' => $buyc->amount,
                            'name'=>$course->courseTitle,
                            'key'=>config("razor.razor_key"),
                        ];
                    } else{
                        $amount = $course->coursePrice;
                        
                        $api = new Api(config('razor.razor_key'), config('razor.razor_secret'));
                        $order  = $api->order->create(array('receipt' => '123', 'amount' => $amount * 100 , 'currency' => 'INR')); // Creates order
                        $orderId = $order['id'];

                        $pur = new Purchasecourse();
                        $pur->userId = Session::get('userId');
                        $pur->courseId = $req->courseId;
                        $pur->amount = $amount;
                        $pur->orderId = $orderId;
                        $pur->save();
                        $data = [
                            'orderId'=>$orderId,
                            'amount' => $amount,
                            'name'=>$course->courseName,
                            'key'=>config("razor.razor_key"),
                        ];
                    }
                }
                
            }else{
                
                // dd($pck);
                 $amount = $course->coursePrice;
                
                 if($isValidCoupon){
                    $amount = $course->coursePrice - floor(($course->coursePrice * $coupon->cpDiscount) / 100);
                }
                
                $api = new Api(config('razor.razor_key'), config('razor.razor_secret'));
                $order  = $api->order->create(array('receipt' => '123', 'amount' => $amount * 100 , 'currency' => 'INR')); // Creates order
                $orderId = $order['id'];

                $pur = new Purchasecourse();
                $pur->userId = Session::get('userId');
                $pur->courseId = $req->courseId;

                if ($isValidCoupon) {
                    $pur->couponCode = $req->couponCode;
                }

                $pur->amount = $amount;
                $pur->orderId = $orderId;
                $pur->save();
                $data = [
                    'orderId'=>$orderId,
                    'amount' => $amount,
                    'name'=>$course->courseTitle,
                    'key'=>config("razor.razor_key"),
                ];
            }

            // dd($course);

            // dd($data);
            return view('buyCourse',['courses'=>$course, 'datas'=>$data]);
        }
    }
    public function payCourse(Request $req){
        $data = $req->all();
        $coursePurchase = Purchasecourse::where('orderId', $data['razorpay_order_id'])->first();
        $coursePurchase->paymentStatus = 1;
        $coursePurchase->paymentId = $data['razorpay_payment_id'];

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

        $courseId = $coursePurchase->courseId;
        if($success){
            $c = Course::where('courseId', $courseId)->first();
            $coursePurchase->expires_at = carbon::now()->addMonths($c->courseValidity);

            $coursePurchase->save();

            if ($coursePurchase->couponCode != null) {
                $coupon = Coupon::where('cpCode', $coursePurchase->couponCode)->first();

                if (!empty($coupon)) {
                    $coupon->cpUsed += 1;
                    $coupon->save();
                }

                $cpe = new Couponenroll();
                $cpe->cpId  = $coupon->cpId;
                $cpe->userId = Session::get('userId');
                $cpe->usedFor = 1;
                $cpe->save();
            }

            $ce = new Courseenroll;
            $ce->courseId = $courseId;
            $ce->userId = Session::get('userId');
            $ce->expires_at = carbon::now()->addMonths($c->courseValidity);
            $ce->save();
            
            return redirect('course/'.$courseId.'/'.$c->courseURI);
        }else{
            return redirect('paymentFailed');
        }
    }

    public function coursePayments($id ) {
        $course = Course::where('courseId', $id)->first();
        if (!empty($course)) {
            $pcs = Purchasecourse::join('users', 'users.id', '=', 'purchasecourses.userId')
            ->select('purchasecourses.*', 'users.name as userName', 'users.contact as userContact')
            ->where('courseId', $id)
            ->where('paymentStatus', 1)
            ->orderBy('pcId', 'desc')
            ->get();

            if (Session::get('fuserId')) {
                return view('Faculty/payments/coursePayments', ['course'=>$course, 'pcs'=>$pcs]);
            }

            return view('Admin/payments/coursePayments', ['course'=>$course, 'pcs'=>$pcs]);
        }
        return back()->with('errors', 'Invalid Course Id..');
    }



}
