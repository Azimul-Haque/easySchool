<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Role;
use App\School;
use DB;
use Hash;

class UserController extends Controller
{

    public function __construct(){
        $this->middleware('role:superadmin');
        //$this->middleware('permission:theSpecificPermission', ['only' => ['create', 'store', 'edit', 'delete']]);
    }
    

    public function index(Request $request)
    {
        $superadmins = Role::with('users')->where('name', 'superadmin')->get();
        $headmasters = Role::with('users')->where('name', 'headmaster')->get();
        $teachers = Role::with('users')->where('name', 'teacher')->get();
        //dd($role);

        $roles = Role::lists('display_name','id');
        $schools = School::lists('name','id');
        
        return view('users.index')
            ->withSuperadmins($superadmins)
            ->withHeadmasters($headmasters)
            ->withTeachers($teachers)
            ->withRoles($roles)
            ->withSchools($schools);
    }

    
    public function create()
    {
        $roles = Role::lists('display_name','id');
        $schools = School::lists('name','id');
        return view('users.create')
                    ->withRoles($roles)
                    ->withSchools($schools);
    }

    
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|same:confirm-password',
            'roles' => 'required',
            'school_id' => 'required'
        ]);
        $input = $request->all();
        $input['password'] = Hash::make($input['password']);

        $user = User::create($input);
        foreach ($request->input('roles') as $key => $value) {
            $user->attachRole($value);
        }
        //$user->roles()->sync($request->roles, false);

        return redirect()->route('users.index')
                        ->with('success','User created successfully');
    }

    
    public function show($id)
    {
        $user = User::find($id);
        return view('users.show')->withUser($user);
    }

   
    public function edit($id)
    {
        // Done with modals
    }

    
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email,'.$id,
            'password' => 'same:confirm-password',
            'roles' => 'required'
        ]);

        $input = $request->all();
        if(!empty($input['password'])){ 
            $input['password'] = Hash::make($input['password']);
        }else{
            $input = array_except($input,array('password'));    
        }

        $user = User::find($id);
        $user->update($input);
        DB::table('role_user')->where('user_id',$id)->delete();

        
        foreach ($request->input('roles') as $key => $value) {
            $user->attachRole($value);
        }
        //$user->roles()->sync($request->roles, false);

        return redirect()->route('users.index')
                        ->with('success','User updated successfully');
    }

   
    public function destroy($id)
    {
        $user = User::find($id);
        if ($user->roles()->where('name', 'superadmin')->exists()) {
            return redirect()->route('users.index')
                        ->with('info', $user->name.' cannot be deleted!');
        } else {
            User::find($id)->delete();
        }
        return redirect()->route('users.index')
                        ->with('success','User deleted successfully');
    }
}