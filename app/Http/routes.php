<?php

Route::get('/clear', ['as'=>'clear','uses'=>'IndexController@clear']);

Route::get('/', ['as'=>'index','uses'=>'IndexController@index']);

Route::auth();

Route::group(['middleware' => ['auth']], function() {
	Route::get('dashboard', ['as'=>'dashboard','uses'=>'DashboardController@index']);

	Route::resource('users','UserController');
	Route::resource('schools','SchoolController');

	Route::get('admissiontoggle/on/{id}',['as'=>'admissions.toggleon','uses'=>'AdmissionController@admissionToggleOn']);
	Route::get('admissiontoggle/off/{id}',['as'=>'admissions.toggleoff','uses'=>'AdmissionController@admissionToggleOff']);
	Route::get('admission/form/payment/manual/{id}',['as'=>'admissions.updatepayment','uses'=>'AdmissionController@updatePaymentManual']);
	Route::post('admission/form/payment/bulk/',['as'=>'admissions.bulkpayment','uses'=>'AdmissionController@payBulk']);
	Route::post('admission/form/submit/mark/',['as'=>'admissions.submitmark','uses'=>'AdmissionController@submitMarks']);
	Route::post('admission/form/final/selection/',['as'=>'admissions.finalselection','uses'=>'AdmissionController@finalSelection']);
	Route::get('admission/applicants/list/pdf',['as'=>'admissions.applicantslist','uses'=>'AdmissionController@pdfApplicantslist']);

	Route::get('roles',['as'=>'roles.index','uses'=>'RoleController@index']);
	Route::get('roles/create',['as'=>'roles.create','uses'=>'RoleController@create']);
	Route::post('roles/create',['as'=>'roles.store','uses'=>'RoleController@store']);
	Route::get('roles/{id}',['as'=>'roles.show','uses'=>'RoleController@show']);
	Route::get('roles/{id}/edit',['as'=>'roles.edit','uses'=>'RoleController@edit']);
	Route::patch('roles/{id}',['as'=>'roles.update','uses'=>'RoleController@update']);
	Route::delete('roles/{id}',['as'=>'roles.destroy','uses'=>'RoleController@destroy']);

	Route::get('settings/',['as'=>'settings.edit','uses'=>'SettingController@edit']);
	Route::put('settings/{id}',['as'=>'settings.update','uses'=>'SettingController@update']);

	Route::get('students',['as'=>'students.index','uses'=>'StudentController@index']);
	Route::get('students/{session}/{class}/{section}',['as'=>'students.getstudents','uses'=>'StudentController@getStudents']);
	Route::get('students/class/{class}',['as'=>'students.class','uses'=>'StudentController@classwise']);
	Route::get('students/create',['as'=>'students.create','uses'=>'StudentController@create']);
	Route::post('students/create',['as'=>'students.store','uses'=>'StudentController@store']);
	Route::get('students/{id}',['as'=>'students.show','uses'=>'StudentController@show']);
	Route::get('students/{id}/edit',['as'=>'students.edit','uses'=>'StudentController@edit']);
	Route::patch('students/{id}',['as'=>'students.update','uses'=>'StudentController@update']);
	Route::delete('students/{id}',['as'=>'students.destroy','uses'=>'StudentController@destroy']);
	Route::post('students/promote/bulk',['as'=>'students.promotebulk','uses'=>'StudentController@promoteBulk']);

	Route::get('sms',['as'=>'sms.index','uses'=>'StudentController@sendsms']);

});

// public gets, posts and so on
Route::resource('admissions','AdmissionController');
Route::get('admission/form/apply/{id}',['as'=>'admissions.apply','uses'=>'AdmissionController@apply']);
Route::get('admission/form/search',['as'=>'admissions.searchpayment','uses'=>'AdmissionController@searchPaymentPage']);
Route::get('admission/form/payment/{application_id}',['as'=>'admissions.getpayment','uses'=>'AdmissionController@getPaymentPage']);
Route::get('admission/form/retrieve',['as'=>'admissions.retrieveid','uses'=>'AdmissionController@retrieveApplicationId']);
Route::get('school/{token}',['as'=>'schools.getschool','uses'=>'SchoolController@getSchool']);

// public APIs
Route::get('getadmissionstatus/{id}',['as'=>'admissions.getstatus','uses'=>'AdmissionController@getAdmissionStatusAPI']);
Route::get('admission/form/retrieve/{dob}/{contact}',['as'=>'admissions.retrieveidapi','uses'=>'AdmissionController@retrieveApplicationIdAPI']);
Route::get('schools/getdistricts/api',['as'=>'schools.getdistricts','uses'=>'SchoolController@getDistrictsAPI']);
Route::get('schools/getupazillas/api/{district}',['as'=>'schools.getupazillas','uses'=>'SchoolController@getUpazillasAPI']);
Route::get('schools/getschools/api/{district}/{upazilla}',['as'=>'schools.getschools','uses'=>'SchoolController@getSchoolsAPI']);



// pdf generators
Route::get('admission/form/copy/pdf/{application_id}',['as'=>'admissions.pdfapplicantscopy','uses'=>'AdmissionController@pdfApplicantsCopy']);
Route::get('admission/applications/pdf',['as'=>'admissions.pdfallapplication','uses'=>'AdmissionController@pdfAllApplications']);
Route::get('admission/seatplan/pdf',['as'=>'admissions.pdfadmissionseatplan','uses'=>'AdmissionController@pdfAdmissionSeatPlan']);
Route::get('admission/form/admitcard/pdf/{application_id}',['as'=>'admissions.pdfadmitcard','uses'=>'AdmissionController@pdfAdmitCard']);

