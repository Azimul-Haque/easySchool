<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\User;
use App\Role;
use App\School;
use DB;
use Hash;
use Auth;

class TeacherController extends Controller
{
    public function __construct(){
        $this->middleware('role:headmaster');
        //$this->middleware('permission:theSpecificPermission', ['only' => ['create', 'store', 'edit', 'delete']]);
    }

    public function index()
    {
        $teachers = $users = User::where('school_id', Auth::user()->school_id)->whereHas('roles', function ($query) {
                $query->where('name', '=', 'teacher');
            })->get();
        $roles = Role::lists('display_name','id');
        $schools = School::lists('name','id');
        
        return view('teachers.index')
            ->withTeachers($teachers)
            ->withRoles($roles)
            ->withSchools($schools);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('teachers.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|same:confirm-password'
        ]);
        $input = $request->all();
        $input['school_id'] = Auth::user()->school_id;
        $input['password'] = Hash::make($input['password']);

        $user = User::create($input);

        $user_role = Role::where('name', 'teacher')->first();
        $user->roles()->sync([$user_role->id], false);

        return redirect()->route('teachers.index')
                        ->with('success','সফলভাবে শিক্ষক তৈরি করা হয়েছে!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $teacher = User::find($id);
        return view('teachers.edit')->withTeacher($teacher);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email,'.$id,
            'password' => 'same:confirm-password'
        ]);

        $input = $request->all();
        if(!empty($input['password'])){ 
            $input['password'] = Hash::make($input['password']);
        }else{
            $input = array_except($input,array('password'));
        }

        $teacher = User::find($id);
        $teacher->update($input);

        return redirect()->route('teachers.index')
                        ->with('success','সফলভাবে শিক্ষকের তথ্য হালনাগাদ করা হয়েছে!');
    }

    public function resetPassword(Request $request, $id)
    {
        $this->validate($request, [
            'password' => 'same:confirm-password'
        ]);

        $input = $request->all();
        if(!empty($input['password'])){ 
            $input['password'] = Hash::make($input['password']);
        }else{
            $input = array_except($input,array('password'));
        }

        $teacher = User::find($id);
        $teacher->update($input);

        return redirect()->route('teachers.index')
                        ->with('success','সফলভাবে পাশওয়ার্ড হালনাগাদ করা হয়েছে!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
