<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// use Illuminate\Support\Facades\Mail;
// use App\Mail\ExamResultMail;

Route::get('/', 'SucessController@index');


// Route::get('/emails', function(){

//     $data= [
//         'name'=>'Praphul',
//         'test'=>'test 1',
//         'ymarks'=>10,
//         'tmarks' => 100,
//         'time'=>Carbon\Carbon::now(),
//         'resultUrl'=>'https://www.successcurve.in/result/testReport/69',
//     ];
//     // Mail::to(Session::get('userEmail'))->send();
//     return new ExamResultMail($data);
// });

// User Login & Registration Routes
Route::View('forget', 'forgetPassword')->middleware('preventLogin');
Route::Post('forgetPassword', 'SucessController@forgetPassword');

Route::view('register', 'register')->middleware('preventLogin');
Route::post('register', 'SucessController@register');

Route::get('google', 'GoogleController@redirectToGoogle');
Route::get('google/callback', 'GoogleController@handleGoogleCallback');

Route::view('login', 'login')->middleware('preventLogin');
Route::post('login', 'SucessController@login');
Route::get('logout', 'SucessController@logout');

// About US Routes

Route::get('about-us', 'PageController@aboutUs');

// Contact Us Routes
Route::View('contact', 'contact');
Route::Post('contact', 'PageController@contact');

// SiteMAP Routes
Route::Get('sitemap', 'PageController@sitemap');

// Data Accessors Routes
Route::POST('getSubjects', 'SucessController@getSubjects');
Route::Post('getClasses', 'SucessController@getClasses');
Route::Post('getInstructor', 'SucessController@getInstructor');
Route::Post('getCourses', 'SucessController@getCourses');
Route::Post('getWeek', 'SucessController@getWeek');
Route::Post('getLecs', 'SucessController@getLecs');

// Explore By Class & Subjects Routes
Route::Get('exploreByClass/{id}/{name}', 'SucessController@exploreByClass');
Route::Get('explore/cls/testSeries/{id}', 'SucessController@exploreTestSeriesByClass');
Route::Get('explore/cls/tests/{id}', 'SucessController@exploreTestsByClass');
Route::Get('explore/cls/courses/{id}', 'SucessController@exploreCoursesByClass');


Route::Get('exploreBySubject/{id}/{name}', 'SucessController@exploreBySubject');
Route::Get('explore/sub/tests/{id}', 'SucessController@exploreTestsBySubject');
Route::Get('explore/sub/courses/{id}', 'SucessController@exploreCoursesBySubject');


// Courses Routes
Route::Get('courses', 'SucessController@showAllCourses');
Route::Get('course/{id}/{name}', 'SucessController@courseDetails');
Route::view('courseDetails', 'courseDetails');

Route::Post('search', 'SucessController@search');

// MockTest Routes
Route::Get('mock-test/', 'TestController@mockTests');
Route::get('mockTest/', 'TestController@mockTestFilter');
Route::get("mocktest/{id}", "TestController@mockTestByClass");

Route::get('exam/test/{id}/{name}', 'ExamController@getExam');

// Test Series Routes
Route::get('testSeries/', 'TestSeriesController@testSeries');
Route::get('testSeries/{id}', 'TestSeriesController@allTestSeriesByClass');
Route::Get('testSeriesDetails/{id}', 'TestSeriesController@testSeriesDetails');


/*  
    --------------------------------------------------------
    ----------- Students Authenticated Routes --------------
    --------------------------------------------------------
*/
Route::middleware(['customAuth'])->group(function () {
    Route::get('student/dashboard', 'SucessController@stuDashboard');

    Route::Post('changeUserClass', 'SucessController@changeUserClass');
    
    //Student Profile
    Route::View('student/profile', 'Student/profile');
    Route::View('student/uploadImage', 'Student/uploadImage');
    
    Route::post('student/uploadImage', 'SucessController@uploadProfileImage');
    
    Route::post('student/editProfile', 'SucessController@editProfile');

    Route::post('student/changePassword', 'SucessController@changePassword');
    
    // Courses 
    Route::get('enrollCourse', 'SucessController@enrollCourse');
    Route::get('purchaseCourse', 'CourseController@purchaseCourse');
    Route::post('payCourse/', 'CourseController@payCourse');
    Route::get('goToCourse', 'SucessController@goToCourse');
    Route::View('lectures', 'lectures');
    Route::get('getLecture', 'SucessController@getLecture');
    
    //Student Enrolled Courses & Tests
    Route::get('student/myCourses', 'SucessController@getMyCourse');
    Route::get('student/testSeries', 'SucessController@getMyTestSeries');
    
    //Student Tests
    Route::Get('student/tests', 'SucessController@mytests');
    Route::Get('student/testResults', 'SucessController@testResults');
    Route::Get('student/testAnswers/{id}', 'ExamController@testAnswers');
    
    //Student Doubt
    Route::Get('student/doubts', 'DoubtController@doubts');
    Route::Post('student/askDoubt', 'DoubtController@askDoubt');
    Route::Get('student/singleDoubt/{id}', 'DoubtController@singleDoubt');

    //Test Routes
    Route::get('exam/enrollTest/{id}', 'ExamController@enrollTest');
    Route::get('purchaseTest', 'TestController@purchaseTest');
    Route::post('payTest/', 'TestController@payTest');
    Route::get('exam/testInstruction/{id}', 'ExamController@testInstruction');
    Route::get('exam/startTest/{id}', 'ExamController@startTest');
    Route::POST('result/submitReport','ExamController@reportQuestion');

    // Test Series Payment 
    Route::get('enroll/testseries/{id}', 'TestSeriesController@enrollTestSeries');
    Route::get('purchaseTestSeries', 'TestSeriesController@purchaseTS');
    Route::post('payTestSeries/', 'TestSeriesController@payTS');
    

    //Result Routes
    Route::POST('result/saveAnswer', 'ResultController@saveAnswer');
    Route::POST('result/finalSubmit', 'ResultController@finalSubmit');
    Route::Get('result/testReport/{id}', 'ResultController@testReport');

    // Payment History
    Route::get('students/payemnts/courses', 'SucessController@coursePayments');
    Route::get('students/payemnts/tests', 'SucessController@testPayments');
    Route::get('students/payemnts/testseries', 'SucessController@testseriesPayments');
    
});

/*  
    --------------------------------------------------------
    -------------------- Admin Routes ----------------------
    --------------------------------------------------------
*/

Route::middleware(['adminAuth'])->group(function () {

    Route::Get('admin/dashboard', 'AdminController@dashboard');

    // Instructor Routes
    Route::View('admin/addInstructor', 'Admin/addInstructor');
    Route::Post('admin/addInstructor', 'AdminController@addInstructor');

    // Profile Routes
    Route::View('admin/profile', 'Admin/profile');

    Route::View('admin/uploadImage', 'Admin/uploadImage');

    Route::post('admin/uploadImage', 'AdminController@uploadProfileImage');

    Route::post('admin/editProfile', 'AdminController@editProfile');

    Route::post('admin/changePassword', 'AdminController@changePassword');

    // Contact Response Routes
    Route::get('admin/contacts', 'AdminController@contacts');
    Route::get('admin/contactDetails/{id}', 'AdminController@contactDetails');
    Route::get('admin/deleteContact/{id}', 'AdminController@deleteContact');

    // Slider Routes
    Route::Get('admin/sliders', 'AdminController@sliders');
    Route::Get('admin/sliders/new', 'AdminController@newSlider');
    Route::Post('admin/sliders/add', 'AdminController@addSlider');
    Route::get('admin/sliders/deactivate/{id}', 'AdminController@deactivateSlider');
    Route::get('admin/sliders/activate/{id}', 'AdminController@activateSlider');
    Route::get('admin/sliders/remove/{id}', 'AdminController@removeSlider');
    Route::get('admin/sliders/edit/{id}', 'AdminController@editSlider');

    // Classes Routes 
    Route::Get('admin/classes', 'TestController@classes');
    Route::Post('admin/addClass', 'TestController@addClass');
    Route::Post('admin/updateClass', 'TestController@updateClass');
    Route::Get('admin/deleteClass/{id}', 'TestController@deleteClass');

    // Class Users
    Route::get('admin/cls/users/{id}', 'AdminController@classUsers');
    Route::get('admin/cls/users/export/{id}', 'AdminController@exportClassUsers');

    // Subjects Routes
    Route::Get('admin/subjectMaster', 'TestController@subjectMaster');
    Route::Post('admin/addSM', 'TestController@addSM');
    Route::Post('admin/updateSM', 'TestController@updateSM');

    // Subject Topics
    Route::get('admin/subjectTopic', 'TestController@subjectTopic');
    Route::Post('admin/addST', 'TestController@addST');
    Route::Post('admin/updateST', 'TestController@updateST');

    // Course Routes
    Route::get('admin/courses', 'CourseController@courses');
    Route::get('admin/courses/generateURI', 'CourseController@generateURI');
    Route::get('admin/course/filter', 'CourseController@filterCourse');

    Route::view('admin/courses/new', 'Admin/courses/createCourse');
    Route::Post('admin/courses/add', 'CourseController@createCourse');
    Route::Get('admin/courses/edit/{id}', 'CourseController@editCourse');
    Route::Post('admin/courses/update', 'CourseController@editCourseContent');

    //Remove Course
    Route::get('admin/courses/trash', 'CourseController@coursesTrash');
    Route::Get('admin/courses/remove/{id}', 'CourseController@removeCourse');
    Route::Get('admin/courses/restore/{id}', 'CourseController@restoreCourse');
    Route::Get('admin/courses/delete/{id}', 'CourseController@deleteCourse');

    Route::get('admin/removeCourse', 'AdminController@removeCourse');

    // COurse Users
    Route::get('admin/courses/users/{id}', 'CourseController@courseUsers');
    Route::get('admin/courses/users/export/{id}', 'CourseController@exportCourseUsers');

    //pending Course
    Route::Post('admin/getPendingCourses', 'AdminController@getPendingCourses');
    //published Course
    Route::Post('admin/getPublishedCourses', 'AdminController@getPublishedCourses');
    //All Course
    Route::Post('admin/getAllCourses', 'AdminController@getAllCourses');
    //removed Course
    Route::Post('admin/getRemovedCourses', 'AdminController@getRemovedCourses');


    //Add Module
    Route::get('admin/courses/modules/{id}', 'CourseController@modules');
    Route::Post('admin/addModule', 'CourseController@addModule');
    Route::Get('admin/editModule', 'AdminController@editModule');
    Route::Post('admin/editModuleContent', 'AdminController@editModuleContent');

    // Course Lectures
    Route::get('admin/courses/lectures/{id}', 'CourseController@lectures');
    Route::Get('admin/lectures/new/{id}', 'CourseController@newLecture');
    Route::Post('admin/addLecture', 'CourseController@addLecture');

    //Edit Lecture
    Route::get('admin/editLecture', 'AdminController@editLecture');
    Route::Post('admin/editLecture2', 'AdminController@editLecture2');
    Route::Post('admin/updateLecture', 'AdminController@updateLecture');

    // Course Lecture Practice Test Routes
    Route::get('admin/lecture/qns/{id}', 'CourseController@lecqns');
    Route::get('admin/lession/qns/add/{id}', 'CourseController@newlecqns');
    Route::get('admin/lession/qns/remove/{id}', 'CourseController@removeLecQns');
    Route::Post('admin/getLectureQuestions', 'CourseController@getLectureQuestions');
    Route::post('admin/addLessionQuestion', 'CourseController@addLecQns');

    // Course Filters Routes
    Route::get('admin/myCourses', 'AdminController@getMyCourses');
    Route::get('admin/publishedCourses', 'AdminController@publishedCourses');
    Route::get('admin/pendingCourses', 'AdminController@pendingCourses');
    Route::get('admin/removedCourses', 'AdminController@removedCourses');

    // Get Top Courses and Tests
    Route::get('admin/getTopCourse', 'AdminController@getTopCourses');
    Route::get('admin/getTopTests', 'AdminController@getTopTests');
    
    // Course Payment History
    Route::get('admin/courses/payments/{id}', 'CourseController@coursePayments');

    // Question Formating Routes
    Route::get('admin/qbs', 'QuestionController@qbs');
    Route::get('admin/qbs/trash', 'QuestionController@qbsTrash');
    Route::post('admin/qbs/add', 'QuestionController@addQbs');
    Route::post('admin/qbs/update', 'QuestionController@updateQbs');
    Route::get('admin/qbs/remove/{id}', 'QuestionController@removeQbs');
    Route::get('admin/qbs/restore/{id}', 'QuestionController@restoreQbs');
    Route::get('admin/qbs/delete/{id}', 'QuestionController@deleteQbs');
    
    // Sub Question Banks
    Route::get('admin/sqbs/{id}', 'QuestionController@sqbs');
    Route::get('admin/sqbs/trash/{id}', 'QuestionController@sqbsTrash');
    Route::post('admin/sqbs/add', 'QuestionController@addSqbs');
    Route::post('admin/sqbs/update', 'QuestionController@updateSqbs');
    Route::get('admin/sqbs/remove/{id}', 'QuestionController@removeSqbs');
    Route::get('admin/sqbs/restore/{id}', 'QuestionController@restoreSqbs');
    Route::get('admin/sqbs/delete/{id}', 'QuestionController@deleteSqbs');

    // Question Topics
    Route::get('admin/qts/{id}', 'QuestionController@qts');
    Route::get('admin/qts/trash/{id}', 'QuestionController@qtsTrash');
    Route::post('admin/qts/add', 'QuestionController@addQts');
    Route::post('admin/qts/update', 'QuestionController@updateQts');
    Route::get('admin/qts/remove/{id}', 'QuestionController@removeQts');
    Route::get('admin/qts/restore/{id}', 'QuestionController@restoreQts');
    Route::get('admin/qts/delete/{id}', 'QuestionController@deleteQts');

    // Sub Question Topics
    Route::get('admin/sqts/{id}', 'QuestionController@sqts');
    Route::get('admin/sqts/trash/{id}', 'QuestionController@sqtsTrash');
    Route::post('admin/sqts/add', 'QuestionController@addSqts');
    Route::post('admin/sqts/update', 'QuestionController@updateSqts');
    Route::get('admin/sqts/remove/{id}', 'QuestionController@removeSqts');
    Route::get('admin/sqts/restore/{id}', 'QuestionController@restoreSqts');
    Route::get('admin/sqts/delete/{id}', 'QuestionController@deleteSqts');

    // Question Lessions
    Route::get('admin/qls/{id}','QuestionController@qls');
    Route::get('admin/qls/trash/{id}','QuestionController@qlsTrash');
    Route::post('admin/qls/add', 'QuestionController@addQls');
    Route::post('admin/qls/update', 'QuestionController@updateQls');
    Route::get('admin/qls/remove/{id}', 'QuestionController@removeQls');
    Route::get('admin/qls/restore/{id}', 'QuestionController@restoreQls');
    Route::get('admin/qls/delete/{id}', 'QuestionController@deleteQls');

    // Questions
    Route::get('admin/qns/{id}', 'QuestionController@qns');

    // New Question Form
    Route::get('admin/qns/new/{id}', 'QuestionController@newQns');
    Route::get('admin/qns/mcq/new/{id}', 'QuestionController@newMCQns');
    Route::get('admin/qns/msq/new/{id}', 'QuestionController@newMSQns');
    Route::get('admin/qns/nat/new/{id}', 'QuestionController@newNATQns');
    Route::get('admin/qns/pr/new/{id}', 'QuestionController@newPRQns');


    // Add New Questions
    Route::post('admin/qns/addQns', 'QuestionController@addQns');
    Route::post('admin/qns/mcq/addQns', 'QuestionController@addMCQns');
    Route::post('admin/qns/msq/addQns', 'QuestionController@addMSQns');
    Route::post('admin/qns/nat/addQns', 'QuestionController@addNATQns');

    // Add New Paragraph 
    Route::get('admin/qns/newPara/{id}', 'QuestionController@newPara');
    Route::post('admin/qns/addPara', 'QuestionController@addPara');

    // List Questions
    Route::get('admin/para/list/{id}', 'QuestionController@listPara');
    Route::get('admin/qns/mcq/list/{id}', 'QuestionController@listMCQ');
    Route::get('admin/qns/msq/list/{id}', 'QuestionController@listMSQ');
    Route::get('admin/qns/nat/list/{id}', 'QuestionController@listNAT');
    Route::get('admin/qns/pr/list/{id}', 'QuestionController@listPRQ');

    // Preview Question
    Route::get("admin/qns/preview/{id}", "QuestionController@previewQuestion");

    // Edit Questions
    Route::get('admin/qns/mcq/edit/{id}', 'QuestionController@editMCQ');
    Route::get('admin/qns/msq/edit/{id}', 'QuestionController@editMSQ');
    Route::get('admin/qns/nat/edit/{id}', 'QuestionController@editNAT');
    Route::get('admin/qns/pr/edit/{id}', 'QuestionController@editPRQ');
    Route::post('admin/qns/updateQns', 'QuestionController@updateQns');
    Route::post('admin/qns/mcq/updateQns', 'QuestionController@updateMCQns');
    Route::post('admin/qns/msq/updateQns', 'QuestionController@updateMSQns');
    Route::post('admin/qns/nat/updateQns', 'QuestionController@updateNATQns');

    // Delete Question
    Route::get("admin/qns/trash/{id}", "QuestionController@trashQns");
    Route::get("admin/qns/remove/{id}", "QuestionController@removeQns");
    Route::get("admin/qns/restore/{id}", "QuestionController@restoreQns");
    Route::get("admin/qns/delete/{id}", "QuestionController@deleteQns");

    // Question EXCEL Format
    Route::get('admin/qns/mcq/format', 'QuestionController@downloadFormat');
    Route::get('admin/qns/mcq/up/new/{id}', 'QuestionController@newUploadMCQ');
    Route::post('admin/qns/mcq/up/add', 'QuestionController@uploadMCQ');

    // Question Filters Routes
    Route::post('getquestionbanks', 'QuestionController@fetchqbs');
    Route::post('admin/getsubbanks', 'QuestionController@fetchsqbs');
    Route::post('admin/getqtopics', 'QuestionController@fetchqts');
    Route::post('admin/getsqtopics', 'QuestionController@fetchsqts');
    Route::post('admin/getqlessions', 'QuestionController@fetchqls');

    // Questions Previous Routes
    Route::Get('admin/questions', 'TestController@questions');

    Route::View('admin/newQuestion', 'Admin/newQuestion');

    Route::Get('downloadMCQFormat', 'TestController@downloadMCQFormat');
    Route::View('admin/uploadMCQ', 'Admin/uploadMCQ');

    Route::Post('importMCQs', 'TestController@importMCQs');

    Route::View('admin/addQuestion', 'Admin/addQuestion');
    Route::Post('admin/addQuestion', 'TestController@addQuestion');
    Route::get('admin/editQuestion/{id}', 'TestController@editQuestion');
    Route::Post('admin/updateQuestion', 'TestController@updateQuestion');

    // Question Tags Routes
    Route::get('admin/questionTags','TestController@questionTags');
    Route::Post('admin/addQuestionTag', 'TestController@addQuestionTag');
    Route::Post('admin/updateQuestionTag', 'TestController@updateQuestionTag');
    Route::Get('admin/deleteQuestionTag/{id}', 'TestController@deleteQuestionTag');

    // Test Section Question Routes
    Route::Get('admin/sectionQuestion/{id}', 'TestController@sectionQuestion');
    Route::Get('admin/addQuestionToSection/{id}', 'TestController@addQuestionToSection');

    Route::Post('admin/getTopicQuestions', 'TestController@getTopicQuestions');
    Route::Post('admin/getTopicQuestionsByTag', 'TestController@getTopicQuestionsByTag');
    Route::Post('admin/addSectionQuestion', 'TestController@addSectionQuestion');
    Route::Get('admin/removeSectionQuestion/{qid}/{tsecid}', 'TestController@removeSectionQuestion');

    // Test Series
    Route::Get('admin/createTC', 'TestController@createTc');
    Route::Get('admin/ts/filter', "TestController@filterTestSeries");
    Route::view('admin/ts/add', 'Admin/tests/addTS');
    Route::get('admin/ts/edit/{id}', 'TestSeriesController@editTS');
    Route::Post('admin/addTc', 'TestController@addTc');
    Route::Post('admin/tests/updateTc', 'TestController@updateTc');

    Route::get('admin/ts/activate/{id}', 'TestController@activateTS');
    Route::get('admin/ts/deactivate/{id}', 'TestController@deactivateTS');
    Route::get('admin/ts/remove/{id}', 'TestController@removeTS');

    // Add Tests to Test Series
    Route::get('admin/testSeriesTests/{id}', 'TestSeriesController@testSeriesTests');
    Route::Post('admin/getTestsLists', 'TestSeriesController@getTestsLists');
    Route::get('admin/addTestToSeries/{id}', 'TestSeriesController@addTestToSeries');
    Route::Post('admin/addTestList', 'TestSeriesController@addTestList');
    Route::get('admin/removeTestFromSeries/{tstId}/{tId}', 'TestSeriesController@removeTestFromSeries');

    // Test Series Users
    Route::get('admin/ts/users/{id}', 'TestController@tsUsers');
    Route::get('admin/ts/users/export/{id}', 'TestController@exportTestSeriesUsers');

    // Test Series Payments
    Route::get('admin/tss/payments/{id}', 'TestseriesController@testseriesPayments');

    // Test Instructions
    Route::get('admin/instructions', 'TestController@instructions');
    Route::View('admin/addIns', 'Admin/addInstructions');
    Route::Post('admin/addIns', 'TestController@addIns');
    Route::Get('admin/updateIns', 'TestController@updateIns');
    Route::Post('admin/updateInstruction', 'TestController@updateInstruction');

    // Tests Routes
    Route::Get('admin/tests', 'TestController@tests');
    Route::get('admin/tests/filter', 'TestController@filterTests');
    Route::get('admin/tests/generateURI', 'TestController@generateTestURI');
    Route::View('admin/addTest', 'Admin/addTest');
    Route::Post('admin/addTest', 'TestController@addTest');
    Route::get('admin/updateTest/{id}', 'TestController@updateTest');
    Route::Post('admin/updateTestContent', 'TestController@updateTestContent');

    // Test Show/Hide Control
    Route::get('admin/tests/activate/{id}', 'TestController@activateTest');
    Route::get('admin/tests/deactivate/{id}', 'TestController@deactivateTest');
    Route::get('admin/tests/remove/{id}', 'TestController@removeTest');

    // Test Users 
    Route::get('admin/tests/users/{id}', 'TestController@testUsers');
    Route::get('admin/tests/users/export/{id}', 'TestController@exportTestUsers');

    // Test Questions
    Route::get('admin/tests/qns/{id}', 'TestController@testQuestions');
    Route::get('admin/tests/qns/export/{id}', 'TestController@exportTestQuestions');

    // Test Payments
    Route::get('admin/tests/payments/{id}', 'TestController@testPayments');

    // Test Sections Routes
    Route::get('admin/testSection/{id}', 'TestController@testSection');
    Route::Post('admin/addTestSection', 'TestController@addTestSection');
    Route::Post('admin/updateTestSection', 'TestController@updateTestSection');

    // Question Reports
    Route::get('admin/questionReports', 'TestController@questionReports');
    Route::get('admin/deleteReport/{id}', 'TestController@deleteReport');

    // Users Routes
    Route::get('admin/users/admins', 'AdminController@admins');
    Route::get('admin/users/instructors', 'AdminController@instructors');
    Route::get('admin/users/users', 'AdminController@users');
    Route::get('admin/users/qas', 'AdminController@qas');
    Route::get('admin/user/ban/{id}', 'AdminController@banUser');
    Route::get('admin/user/unban/{id}', 'AdminController@unbanUser');
    Route::get('admin/users/newUser', 'AdminController@newUser');
    Route::post('admin/users/addUser', 'AdminController@addUser');

    // Admin Protected Data Accessors points
    Route::Post('admin/getInstructions', 'TestController@getInstructions');
    Route::Post('admin/getTopics', 'TestController@getTopics');
    Route::Post('admin/getTests', 'TestController@getTests');
    Route::Post('admin/getQuestionTags', 'TestController@getQuestionTags');


    // Coupons Routes
    Route::get('admin/coupons', 'CouponController@getCoupons');
    Route::get('admin/coupons/new/', 'CouponController@newCoupon');
    Route::post('admin/coupons/add', 'CouponController@addCoupon');
    Route::get('admin/coupons/edit/{id}', 'CouponController@editCoupon');
    Route::post('admin/coupons/update', 'CouponController@updateCoupon');

});


/*  
    --------------------------------------------------------
    ------------------- Faculty Routes ---------------------
    --------------------------------------------------------
*/

Route::middleware(['customFacAuth'])->group(function () {
    Route::Get('faculty/dashboard', 'FacultyController@dashboard');

    //Faculty Profile
    Route::Post('faculty/getCourses', 'FacultyController@getCourses');
    
    Route::View('faculty/profile', 'Faculty/profile');
    Route::View('faculty/uploadImage', 'Faculty/uploadImage');
    Route::post('faculty/uploadImage', 'FacultyController@uploadProfileImage');
    
    Route::post('faculty/editProfile', 'FacultyController@editProfile');
    
    // Get Top Courses and Tests
    Route::get('faculty/getTopCourse', 'FacultyController@getTopCourses');
    Route::get('faculty/getTopTests', 'FacultyController@getTopTests');

    // Course Routes
    Route::get('faculty/courses', 'CourseController@courses');
    Route::get('faculty/courses/generateURI', 'CourseController@generateURI');
    Route::get('faculty/course/filter', 'CourseController@filterCourse');

    Route::view('faculty/courses/new', 'Faculty/courses/createCourse');
    Route::Post('faculty/courses/add', 'CourseController@createCourse');
    Route::Get('faculty/courses/edit/{id}', 'CourseController@editCourse');
    Route::Post('faculty/courses/update', 'CourseController@editCourseContent');

    //Remove Course
    Route::get('faculty/removeCourse', 'AdminController@removeCourse');

    //pending Course
    Route::Post('faculty/getPendingCourses', 'AdminController@getPendingCourses');
    //published Course
    Route::Post('faculty/getPublishedCourses', 'AdminController@getPublishedCourses');
    //All Course
    Route::Post('faculty/getAllCourses', 'AdminController@getAllCourses');
    //removed Course
    Route::Post('faculty/getRemovedCourses', 'AdminController@getRemovedCourses');


    //Add Module
    Route::get('faculty/courses/modules/{id}', 'CourseController@modules');
    Route::Post('faculty/addModule', 'CourseController@addModule');
    Route::Get('faculty/editModule', 'AdminController@editModule');
    Route::Post('faculty/editModuleContent', 'AdminController@editModuleContent');

    // Course Lectures
    Route::get('faculty/courses/lectures/{id}', 'CourseController@lectures');
    Route::Get('faculty/lectures/new/{id}', 'CourseController@newLecture');
    Route::get('faculty/lession/qns/remove/{id}', 'CourseController@removeLecQns');
    Route::Post('faculty/addLecture', 'CourseController@addLecture');

    //Edit Lecture
    Route::get('faculty/editLecture', 'AdminController@editLecture');
    Route::Post('faculty/editLecture2', 'AdminController@editLecture2');
    Route::Post('faculty/updateLecture', 'AdminController@updateLecture');

    // Course Lecture Practice Test Routes
    Route::get('faculty/lecture/qns/{id}', 'CourseController@lecqns');
    Route::get('faculty/lession/qns/add/{id}', 'CourseController@newlecqns');
    Route::Post('faculty/getLectureQuestions', 'CourseController@getLectureQuestions');
    Route::post('faculty/addLessionQuestion', 'CourseController@addLecQns');

    // Course Payment History
    Route::get('faculty/courses/payments/{id}', 'CourseController@coursePayments');

    // Course Filters Routes
    Route::get('faculty/myCourses', 'AdminController@getMyCourses');
    Route::get('faculty/publishedCourses', 'AdminController@publishedCourses');
    Route::get('faculty/pendingCourses', 'AdminController@pendingCourses');
    Route::get('faculty/removedCourses', 'AdminController@removedCourses');

    // Question FIlters
    Route::post('faculty/getquestionbanks', 'QuestionController@fetchqbs');
    Route::post('faculty/getsubbanks', 'QuestionController@fetchsqbs');
    Route::post('faculty/getqtopics', 'QuestionController@fetchqts');
    Route::post('faculty/getsqtopics', 'QuestionController@fetchsqts');
    Route::post('faculty/getqlessions', 'QuestionController@fetchqls');

    // Test Section Question Routes
    Route::Get('faculty/sectionQuestion/{id}', 'TestController@sectionQuestion');
    Route::Get('faculty/addQuestionToSection/{id}', 'TestController@addQuestionToSection');

    Route::Post('faculty/getTopicQuestions', 'TestController@getTopicQuestions');
    Route::Post('faculty/getTopicQuestionsByTag', 'TestController@getTopicQuestionsByTag');
    Route::Post('faculty/addSectionQuestion', 'TestController@addSectionQuestion');
    Route::Get('faculty/removeSectionQuestion/{qid}/{tsecid}', 'TestController@removeSectionQuestion');

    // Test Series
    // Route::Get('faculty/createTC', 'TestController@createTc');
    // Route::Get('faculty/ts/filter', "TestController@filterTestSeries");
    // Route::view('faculty/ts/add', 'Faculty/tests/addTS');
    // Route::get('faculty/ts/edit/{id}', 'TestSeriesController@editTS');
    // Route::Post('faculty/addTc', 'TestController@addTc');
    // Route::Post('faculty/tests/updateTc', 'TestController@updateTc');

    // Route::get('faculty/ts/activate/{id}', 'TestController@activateTS');
    // Route::get('faculty/ts/deactivate/{id}', 'TestController@deactivateTS');
    // Route::get('faculty/ts/remove/{id}', 'TestController@removeTS');

    // Add Tests to Test Series
    // Route::get('faculty/testSeriesTests/{id}', 'TestSeriesController@testSeriesTests');
    // Route::Post('faculty/getTestsLists', 'TestSeriesController@getTestsLists');
    // Route::get('faculty/addTestToSeries/{id}', 'TestSeriesController@addTestToSeries');
    // Route::Post('faculty/addTestList', 'TestSeriesController@addTestList');
    // Route::get('faculty/removeTestFromSeries/{tstId}/{tId}', 'TestSeriesController@removeTestFromSeries');

    // Test Series Users
    // Route::get('faculty/ts/users/{id}', 'TestController@tsUsers');
    // Route::get('faculty/ts/users/export/{id}', 'TestController@exportTestSeriesUsers');

    // Test Instructions
    // Route::get('faculty/instructions', 'TestController@instructions');
    // Route::View('faculty/addIns', 'Admin/addInstructions');
    // Route::Post('faculty/addIns', 'TestController@addIns');
    // Route::Get('faculty/updateIns', 'TestController@updateIns');
    // Route::Post('faculty/updateInstruction', 'TestController@updateInstruction');

    Route::Post('faculty/getInstructions', 'TestController@getInstructions');

    // Tests Routes
    Route::Get('faculty/tests', 'TestController@tests');
    Route::get('faculty/tests/filter', 'TestController@filterTests');
    
    Route::View('faculty/addTest', 'Faculty/tests/addTest');
    Route::Post('faculty/addTest', 'TestController@addTest');
    Route::get('faculty/updateTest/{id}', 'TestController@updateTest');
    Route::Post('faculty/updateTestContent', 'TestController@updateTestContent');

    // Test Show/Hide Control
    Route::get('faculty/tests/activate/{id}', 'TestController@activateTest');
    Route::get('faculty/tests/deactivate/{id}', 'TestController@deactivateTest');
    Route::get('faculty/tests/remove/{id}', 'TestController@removeTest');

    // Test Users 
    Route::get('faculty/tests/users/{id}', 'TestController@testUsers');
    Route::get('faculty/tests/users/export/{id}', 'TestController@exportTestUsers');

    // Test Payments
    Route::get('faculty/tests/payments/{id}', 'TestController@testPayments');

    // Test Sections Routes
    Route::get('faculty/testSection/{id}', 'TestController@testSection');
    Route::Post('faculty/addTestSection', 'TestController@addTestSection');
    Route::Post('faculty/updateTestSection', 'TestController@updateTestSection');

    // Question Reports
    Route::get('faculty/questionReports', 'TestController@questionReports');
    Route::get('faculty/deleteReport/{id}', 'TestController@deleteReport');

    
    Route::get('faculty/editQuestion/{id}', 'TestController@editQuestion');
});




/*  
    --------------------------------------------------------
    --------------------- QAS Routes -----------------------
    --------------------------------------------------------
*/

Route::middleware(['qasAuth'])->group(function () {

    Route::Get('qas/dashboard', 'QasController@dashboard');

    // Profile Routes
    Route::View('qas/profile', 'qas/profile');

    Route::View('qas/uploadImage', 'qas/uploadImage');

    Route::post('qas/uploadImage', 'QasController@uploadProfileImage');

    Route::post('qas/editProfile', 'QasController@editProfile');

    Route::post('qas/changePassword', 'QasController@changePassword');

    // Question Formating Routes
    Route::get('qas/qbs', 'QuestionController@qbs');
    // Route::get('qas/qbs/trash', 'QuestionController@qbsTrash');
    Route::post('qas/qbs/add', 'QuestionController@addQbs');
    Route::post('qas/qbs/update', 'QuestionController@updateQbs');
    Route::get('qas/qbs/remove/{id}', 'QuestionController@removeQbs');
    // Route::get('qas/qbs/restore/{id}', 'QuestionController@restoreQbs');
    // Route::get('qas/qbs/delete/{id}', 'QuestionController@deleteQbs');
    
    // Sub Question Banks
    Route::get('qas/sqbs/{id}', 'QuestionController@sqbs');
    // Route::get('qas/sqbs/trash/{id}', 'QuestionController@sqbsTrash');
    Route::post('qas/sqbs/add', 'QuestionController@addSqbs');
    Route::post('qas/sqbs/update', 'QuestionController@updateSqbs');
    Route::get('qas/sqbs/remove/{id}', 'QuestionController@removeSqbs');
    // Route::get('qas/sqbs/restore/{id}', 'QuestionController@restoreSqbs');
    // Route::get('qas/sqbs/delete/{id}', 'QuestionController@deleteSqbs');

    // Question Topics
    Route::get('qas/qts/{id}', 'QuestionController@qts');
    // Route::get('qas/qts/trash/{id}', 'QuestionController@qtsTrash');
    Route::post('qas/qts/add', 'QuestionController@addQts');
    Route::post('qas/qts/update', 'QuestionController@updateQts');
    Route::get('qas/qts/remove/{id}', 'QuestionController@removeQts');
    // Route::get('qas/qts/restore/{id}', 'QuestionController@restoreQts');
    // Route::get('qas/qts/delete/{id}', 'QuestionController@deleteQts');

    // Sub Question Topics
    Route::get('qas/sqts/{id}', 'QuestionController@sqts');
    // Route::get('qas/sqts/trash/{id}', 'QuestionController@sqtsTrash');
    Route::post('qas/sqts/add', 'QuestionController@addSqts');
    Route::post('qas/sqts/update', 'QuestionController@updateSqts');
    Route::get('qas/sqts/remove/{id}', 'QuestionController@removeSqts');
    // Route::get('qas/sqts/restore/{id}', 'QuestionController@restoreSqts');
    // Route::get('qas/sqts/delete/{id}', 'QuestionController@deleteSqts');

    // Question Lessions
    Route::get('qas/qls/{id}','QuestionController@qls');
    // Route::get('qas/qls/trash/{id}','QuestionController@qlsTrash');
    Route::post('qas/qls/add', 'QuestionController@addQls');
    Route::post('qas/qls/update', 'QuestionController@updateQls');
    Route::get('qas/qls/remove/{id}', 'QuestionController@removeQls');
    // Route::get('qas/qls/restore/{id}', 'QuestionController@restoreQls');
    // Route::get('qas/qls/delete/{id}', 'QuestionController@deleteQls');

    // Questions
    Route::get('qas/qns/{id}', 'QuestionController@qns');

    // New Question Form
    Route::get('qas/qns/new/{id}', 'QuestionController@newQns');
    Route::get('qas/qns/mcq/new/{id}', 'QuestionController@newMCQns');
    Route::get('qas/qns/msq/new/{id}', 'QuestionController@newMSQns');
    Route::get('qas/qns/nat/new/{id}', 'QuestionController@newNATQns');
    Route::get('qas/qns/pr/new/{id}', 'QuestionController@newPRQns');


    // Add New Questions
    Route::post('qas/qns/addQns', 'QuestionController@addQns');
    Route::post('qas/qns/mcq/addQns', 'QuestionController@addMCQns');
    Route::post('qas/qns/msq/addQns', 'QuestionController@addMSQns');
    Route::post('qas/qns/nat/addQns', 'QuestionController@addNATQns');

    // Add New Paragraph 
    Route::get('qas/qns/newPara/{id}', 'QuestionController@newPara');
    Route::post('qas/qns/addPara', 'QuestionController@addPara');

    // List Questions
    Route::get('qas/para/list/{id}', 'QuestionController@listPara');
    Route::get('qas/qns/mcq/list/{id}', 'QuestionController@listMCQ');
    Route::get('qas/qns/msq/list/{id}', 'QuestionController@listMSQ');
    Route::get('qas/qns/nat/list/{id}', 'QuestionController@listNAT');
    Route::get('qas/qns/pr/list/{id}', 'QuestionController@listPRQ');

    // Preview Question
    Route::get("qas/qns/preview/{id}", "QuestionController@previewQuestion");

    // Edit Questions
    Route::get('qas/qns/mcq/edit/{id}', 'QuestionController@editMCQ');
    Route::get('qas/qns/msq/edit/{id}', 'QuestionController@editMSQ');
    Route::get('qas/qns/nat/edit/{id}', 'QuestionController@editNAT');
    Route::get('qas/qns/pr/edit/{id}', 'QuestionController@editPRQ');
    Route::post('qas/qns/updateQns', 'QuestionController@updateQns');
    Route::post('qas/qns/mcq/updateQns', 'QuestionController@updateMCQns');
    Route::post('qas/qns/msq/updateQns', 'QuestionController@updateMSQns');
    Route::post('qas/qns/nat/updateQns', 'QuestionController@updateNATQns');

    // Question EXCEL Format
    Route::get('qas/qns/mcq/format', 'QuestionController@downloadFormat');
    Route::get('qas/qns/mcq/up/new/{id}', 'QuestionController@newUploadMCQ');
    Route::post('qas/qns/mcq/up/add', 'QuestionController@uploadMCQ');


    // Question Filters Routes
    Route::post('qas/getquestionbanks', 'QuestionController@fetchqbs');
    Route::post('qas/getsubbanks', 'QuestionController@fetchsqbs');
    Route::post('qas/getqtopics', 'QuestionController@fetchqts');
    Route::post('qas/getsqtopics', 'QuestionController@fetchsqts');
    Route::post('qas/getqlessions', 'QuestionController@fetchqls');

    // Questions Previous Routes
    Route::Get('qas/questions', 'TestController@questions');

    Route::View('qas/newQuestion', 'Admin/newQuestion');

    Route::Get('downloadMCQFormat', 'TestController@downloadMCQFormat');
    Route::View('qas/uploadMCQ', 'Admin/uploadMCQ');

    Route::Post('importMCQs', 'TestController@importMCQs');

    Route::View('qas/addQuestion', 'Admin/addQuestion');
    Route::Post('qas/addQuestion', 'TestController@addQuestion');
    Route::get('qas/editQuestion/{id}', 'TestController@editQuestion');
    Route::Post('qas/updateQuestion', 'TestController@updateQuestion');

    // Question Tags Routes
    Route::get('qas/questionTags','TestController@questionTags');
    Route::Post('qas/addQuestionTag', 'TestController@addQuestionTag');
    Route::Post('qas/updateQuestionTag', 'TestController@updateQuestionTag');
    Route::Get('qas/deleteQuestionTag/{id}', 'TestController@deleteQuestionTag');
   
    // Question Reports
    Route::get('qas/questionReports', 'TestController@questionReports');
    Route::get('qas/deleteReport/{id}', 'TestController@deleteReport');

});
