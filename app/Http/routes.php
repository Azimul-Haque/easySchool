<?php

Route::get('/clear', ['as'=>'clear','uses'=>'IndexController@clear']);

Route::get('/', ['as'=>'index','uses'=>'IndexController@index']);
Route::post('email/contact/form', ['as'=>'index.emailcontactform','uses'=>'IndexController@emailContactForm']);

Route::auth();

Route::group(['middleware' => ['auth']], function() {
	Route::get('dashboard', ['as'=>'dashboard','uses'=>'DashboardController@index']);

	Route::resource('users','UserController');
	Route::resource('schools','SchoolController');
	Route::resource('subjects','SubjectController');
	Route::resource('exams','ExamController');

	Route::resource('teachers','TeacherController');
	Route::put('teachers/resetpassword/{id}',['as'=>'teachers.resetpassword','uses'=>'TeacherController@resetPassword']);

	Route::get('admissiontoggle/on/{id}',['as'=>'admissions.toggleon','uses'=>'AdmissionController@admissionToggleOn']);
	Route::get('admissiontoggle/off/{id}',['as'=>'admissions.toggleoff','uses'=>'AdmissionController@admissionToggleOff']);
	Route::get('admission/classwise/{class}',['as'=>'admissions.getclasswise','uses'=>'AdmissionController@getClassWise']);
	Route::get('admission/form/payment/manual/{id}',['as'=>'admissions.updatepayment','uses'=>'AdmissionController@updatePaymentManual']);
	Route::post('admission/form/payment/bulk/',['as'=>'admissions.bulkpayment','uses'=>'AdmissionController@payBulk']);
	Route::post('admission/form/submit/mark/',['as'=>'admissions.submitmark','uses'=>'AdmissionController@submitMarks']);
	Route::post('admission/form/final/selection/',['as'=>'admissions.finalselection','uses'=>'AdmissionController@finalSelection']);
	Route::get('admission/applicants/list/pdf/{class}',['as'=>'admissions.applicantslist','uses'=>'AdmissionController@pdfApplicantslist']);
	Route::get('admission/result/list/pdf/{class}',['as'=>'admissions.admissionresult','uses'=>'AdmissionController@pdfAdmissionResult']);
	Route::get('admission/applications/pdf/{class}',['as'=>'admissions.pdfallapplications','uses'=>'AdmissionController@pdfAllApplications']);
	Route::get('admission/admitcards/pdf/{class}',['as'=>'admissions.pdfalladmitcards','uses'=>'AdmissionController@pdfAllAdmitCards']);
	Route::get('admission/seatplan/pdf/{class}',['as'=>'admissions.pdfadmissionseatplan','uses'=>'AdmissionController@pdfAdmissionSeatPlan']);

	Route::get('roles',['as'=>'roles.index','uses'=>'RoleController@index']);
	Route::get('roles/create',['as'=>'roles.create','uses'=>'RoleController@create']);
	Route::post('roles/create',['as'=>'roles.store','uses'=>'RoleController@store']);
	Route::get('roles/{id}',['as'=>'roles.show','uses'=>'RoleController@show']);
	Route::get('roles/{id}/edit',['as'=>'roles.edit','uses'=>'RoleController@edit']);
	Route::patch('roles/{id}',['as'=>'roles.update','uses'=>'RoleController@update']);
	Route::delete('roles/{id}',['as'=>'roles.destroy','uses'=>'RoleController@destroy']);

	Route::get('settings/',['as'=>'settings.edit','uses'=>'SettingController@edit']);
	Route::put('settings/{id}',['as'=>'settings.update','uses'=>'SettingController@update']);
	Route::put('settings/admission/{id}',['as'=>'settings.updateadmission','uses'=>'SettingController@updateAdmission']);

	Route::get('students',['as'=>'students.index','uses'=>'StudentController@index']);
	Route::get('students/{session}/{class}/{section}',['as'=>'students.getstudents','uses'=>'StudentController@getStudents']);
	Route::get('students/create',['as'=>'students.create','uses'=>'StudentController@create']);
	Route::post('students/create',['as'=>'students.store','uses'=>'StudentController@store']);
	Route::get('students/{id}',['as'=>'students.show','uses'=>'StudentController@show']);
	Route::get('students/{id}/edit',['as'=>'students.edit','uses'=>'StudentController@edit']);
	Route::patch('students/{id}',['as'=>'students.update','uses'=>'StudentController@update']);
	Route::delete('students/{id}',['as'=>'students.destroy','uses'=>'StudentController@destroy']);
	
	Route::get('students/getlist/pdf/{session}/{class}/{section}',['as'=>'students.getstudentlistpdf','uses'=>'StudentController@getStudentListPDF']);
	Route::get('students/infolist/pdf/{session}/{class}/{section}',['as'=>'students.getinfolistpdf','uses'=>'StudentController@getInfoListPDF']);
	Route::get('students/book/distribution/list/pdf/{session}/{class}/{section}',['as'=>'students.getbookdistrolistpdf','uses'=>'StudentController@getBoookDistroListPDF']);
	Route::get('students/tutionfee/list/pdf/{session}/{class}/{section}',['as'=>'students.gettutionfeelistpdf','uses'=>'StudentController@getTutionFeeListPDF']);
	Route::get('students/cardregister/list/pdf/{session}/{class}/{section}',['as'=>'students.getcardregisterlistpdf','uses'=>'StudentController@getCardRegisterListPDF']);
	Route::get('students/attendance/sheet/pdf/{session}/{class}/{section}',['as'=>'students.getattendancesheetpdf','uses'=>'StudentController@getAttendanceSheetPDF']);
	Route::get('students/students/album/pdf/{session}/{class}/{section}',['as'=>'students.getstudentsalbumpdf','uses'=>'StudentController@getStudentsAlbumPDF']);
	Route::get('students/tot/list/8/pdf/{session}/{class}/{section}',['as'=>'students.gettotlist8pdf','uses'=>'StudentController@getTotList8PDF']);
	Route::get('students/tot/list/9/pdf/{session}/{class}/{section}',['as'=>'students.gettotlist9pdf','uses'=>'StudentController@getTotList9PDF']);
	Route::get('students/admit/cards/pdf/{session}/{class}/{section}',['as'=>'students.getadmitcardpdf','uses'=>'StudentController@getAdmitCardPDF']);
	Route::get('students/seat/plan/pdf/{session}/{class}/{section}',['as'=>'students.getseatplanpdf','uses'=>'StudentController@getSeatPlanPDF']);
	Route::get('students/all/testimonials/pdf/{session}/{class}/{section}',['as'=>'students.gettestimonialsall','uses'=>'StudentController@getTestimonialAllPDF']);
	Route::get('students/all/info/pdf/{session}/{class}/{section}',['as'=>'students.getinfoall','uses'=>'StudentController@getInfoAllPDF']);
	Route::get('students/admission/info/pdf/{session}/{class}/{section}',['as'=>'students.getadmissioninfo','uses'=>'StudentController@getInfoAdmissionPDF']);
	Route::get('students/id/cards/pdf/{session}/{class}/{section}',['as'=>'students.getidcards','uses'=>'StudentController@getIDCardsPDF']);
	Route::get('students/single/testimonial/pdf/{student_id}',['as'=>'students.gettestimonialsingle','uses'=>'StudentController@getTestimonialSinglePDF']);
	Route::get('students/single/info/pdf/{student_id}',['as'=>'students.getinfosingle','uses'=>'StudentController@getInfoSinglePDF']);
	Route::get('students/single/idcard/pdf/{student_id}',['as'=>'students.getidcardsingle','uses'=>'StudentController@getIDCardSinglePDF']);
	Route::get('search/student',['as'=>'students.getsearch','uses'=>'StudentController@getSearchStudent']);
	Route::get('search/student/result',['as'=>'students.search','uses'=>'StudentController@searchStudent']);


	Route::patch('exam/make/current/{id}',['as'=>'exam.makecurrent','uses'=>'ExamController@makeCurrent']);
	// Route::patch('exam/remove/current/{id}',['as'=>'exam.removecurrent','uses'=>'ExamController@removeCurrent']);
	Route::get('exam/subject/allocation',['as'=>'exam.getsubjectallocation','uses'=>'ExamController@getSubjectallocation']);
	Route::post('exam/subject/allocation',['as'=>'exam.postsubjectallocation','uses'=>'ExamController@storeSubjectallocation']);
	Route::get('exam/mark/submission/{user_id}/{school_id}/{exam_id}/{subject_id}/{class}/{section}',['as'=>'exam.getsubmissionpage','uses'=>'ExamController@getSubmissionPage']);
	Route::post('exam/marks/submit',['as'=>'exam.storemakrs','uses'=>'ExamController@storeMakrs']);
	Route::get('exam/marks/pdf/{school_id}/{exam_id}/{subject_id}/{class}/{section}',['as'=>'exam.pdfmarks','uses'=>'ExamController@pdfMarksforTeacher']);

	Route::get('exam/mark/submission/page/headmaster',['as'=>'exam.allclassmarksubmissionpage','uses'=>'ExamController@allClassMarkSubmissionPage']);
	Route::get('exam/result/generation/page',['as'=>'exam.getresultgenpage','uses'=>'ExamController@getResultGenPage']);
	Route::get('exam/result/list/generate/pdf/',['as'=>'exam.getresultlistpdf','uses'=>'ExamController@getResultListPDF']);
	Route::get('exam/tabulation/sheet/generate/pdf/',['as'=>'exam.gettabulationsheetpdf','uses'=>'ExamController@getTabulationSheetPDF']);
	Route::get('exam/marksheets/generate/pdf/',['as'=>'exam.getmarksheetspdf','uses'=>'ExamController@getMarkSheetsPdf']);
	Route::get('exam/sms/send/result/',['as'=>'exam.sendsmsresult','uses'=>'ExamController@getSendSMSResult']);
	Route::get('exam/excel/generate/',['as'=>'exam.getresultexcelforsms','uses'=>'ExamController@getExcelForSMS']);

	// Route::post('exam/delete/{id}',['as'=>'exam.delete','uses'=>'ExamController@makeCurrent']);

	// Route::get('sms',['as'=>'sms.index','uses'=>'StudentController@sendsms']);
	// Route::get('sms/test',['as'=>'sms.trest','uses'=>'StudentController@testSMS']);
	Route::get('sms/admin',['as'=>'sms.admin','uses'=>'SmsController@getAdmin']);
	Route::post('sms/admin/add',['as'=>'sms.rechargeschoolsms','uses'=>'SmsController@rechargeSchoolSMS']);

	Route::get('sms',['as'=>'sms.index','uses'=>'SmsController@getIndex']);
	Route::get('sms/client/recharge/{smscount}/{token}/{tk}',['as'=>'sms.clientrecharge','uses'=>'SmsController@getClientRecharge']);
	Route::post('sms/recharge/request',['as'=>'sms.rechargerequest','uses'=>'SmsController@storeRechargeRequest']);

	// SMS Sending
	Route::post('sms/send/classwise',['as'=>'sms.sendclasswise','uses'=>'SmsController@sendSMSClassWise']);

	Route::delete('sms/recharge/request/delete/{id}',['as'=>'sms.destroy.history','uses'=>'SmsController@destroyRechargeReqHistory']);
	Route::patch('sms/recharge/request/update/{id}',['as'=>'sms.update.history','uses'=>'SmsController@updateRechargeReqHistory']);

	// Class Promotion
	Route::get('promotion/',['as'=>'promotion.index','uses'=>'PromotionController@index']);
	Route::get('promotion/{session}/{class}/{section}',['as'=>'promotion.getstudents','uses'=>'PromotionController@getStudents']);
	Route::post('promotion/students/promote/bulk',['as'=>'students.promotebulk','uses'=>'PromotionController@promoteBulk']);

	// Collection Management
	// Collection Management
	Route::get('collection/',['as'=>'collection.index','uses'=>'CollectionController@index']);
	Route::get('collection/input/form',['as'=>'collection.input.form','uses'=>'CollectionController@inputForm']);
	Route::get('collection/input/form/{session}/{class}/{section}',['as'=>'collection.getstudents','uses'=>'CollectionController@getStudents']);
	Route::post('collection/input/form/{session}/{class}/{section}',['as'=>'collection.storecollection','uses'=>'CollectionController@storeCollection']);
	Route::get('collection/list',['as'=>'collection.list','uses'=>'CollectionController@collectionList']);
	Route::get('collection/list/{session}/{class}/{section}/{from}/{to}',['as'=>'collection.list.data','uses'=>'CollectionController@collectionListData']);
	// Collection Management
	// Collection Management
});
// just to avoid the Auth Middleware
Route::get('exam/marksheets/generate/single/pdf/',['as'=>'exam.getsinglemarksheetpdf','uses'=>'ExamController@getSingleMarkSheetPdf']);

// public gets, posts and so on
Route::resource('admissions','AdmissionController');
Route::get('admission/form/apply/{id}',['as'=>'admissions.apply','uses'=>'AdmissionController@apply']);
Route::get('admission/form/search',['as'=>'admissions.searchpayment','uses'=>'AdmissionController@searchPaymentPage']);
Route::get('admission/form/payment/{application_id}',['as'=>'admissions.getpayment','uses'=>'AdmissionController@getPaymentPage']);
Route::get('admission/form/retrieve',['as'=>'admissions.retrieveid','uses'=>'AdmissionController@retrieveApplicationId']);
Route::get('school/{token}',['as'=>'schools.getschool','uses'=>'SchoolController@getSchool']);
Route::get('school/{token}/resultpage',['as'=>'schools.getschool.resultpage','uses'=>'SchoolController@getSchoolResultPage']);

// public APIs
Route::get('getadmissionstatus/{id}',['as'=>'admissions.getstatus','uses'=>'AdmissionController@getAdmissionStatusAPI']);
Route::get('admission/form/retrieve/{dob}/{contact}',['as'=>'admissions.retrieveidapi','uses'=>'AdmissionController@retrieveApplicationIdAPI']);
Route::get('schools/getdistricts/api',['as'=>'schools.getdistricts','uses'=>'SchoolController@getDistrictsAPI']);
Route::get('schools/getupazillas/api/{district}',['as'=>'schools.getupazillas','uses'=>'SchoolController@getUpazillasAPI']);
Route::get('schools/getschools/api/{district}/{upazilla}',['as'=>'schools.getschools','uses'=>'SchoolController@getSchoolsAPI']);



// pdf generators
Route::get('admission/form/copy/pdf/{application_id}',['as'=>'admissions.pdfapplicantscopy','uses'=>'AdmissionController@pdfApplicantsCopy']);
Route::get('admission/form/admitcard/pdf/{application_id}',['as'=>'admissions.pdfadmitcard','uses'=>'AdmissionController@pdfAdmitCard']);

// Map Test
Route::get('map/test',['as'=>'map.test','uses'=>'MapController@test']);

