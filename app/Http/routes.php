<?php


Route::get('/', function () {
    return view('welcome');
});

Route::auth();

Route::group(['middleware' => ['auth']], function() {

	Route::get('/dashboard', 'DashboardController@index');

	Route::resource('users','UserController');

	Route::get('roles',['as'=>'roles.index','uses'=>'RoleController@index']);
	Route::get('roles/create',['as'=>'roles.create','uses'=>'RoleController@create']);
	Route::post('roles/create',['as'=>'roles.store','uses'=>'RoleController@store']);
	Route::get('roles/{id}',['as'=>'roles.show','uses'=>'RoleController@show']);
	Route::get('roles/{id}/edit',['as'=>'roles.edit','uses'=>'RoleController@edit']);
	Route::patch('roles/{id}',['as'=>'roles.update','uses'=>'RoleController@update']);
	Route::delete('roles/{id}',['as'=>'roles.destroy','uses'=>'RoleController@destroy']);

	Route::get('students',['as'=>'students.index','uses'=>'StudentController@index']);
	Route::get('students/create',['as'=>'students.create','uses'=>'StudentController@create']);
	Route::post('students/create',['as'=>'students.store','uses'=>'StudentController@store']);
	Route::get('students/{id}',['as'=>'students.show','uses'=>'StudentController@show']);
	Route::get('students/{id}/edit',['as'=>'students.edit','uses'=>'StudentController@edit']);
	Route::patch('students/{id}',['as'=>'students.update','uses'=>'StudentController@update']);
	Route::delete('students/{id}',['as'=>'students.destroy','uses'=>'StudentController@destroy']);
});
