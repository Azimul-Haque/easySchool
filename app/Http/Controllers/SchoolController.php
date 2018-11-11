<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\School;

use Validator, Input, Redirect, Session;
use Auth;

class SchoolController extends Controller
{
    public function __construct(){
        $this->middleware('role:superadmin');
        //$this->middleware('permission:theSpecificPermission', ['only' => ['create', 'store', 'edit', 'delete']]);
    }


    public function index()
    {
        $schools = School::orderBy('id', 'ASC')->get();
        return view('schools.index')
                    ->withSchools($schools);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('schools.create');
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
            'established' => 'required|integer',
            'eiin' => 'required|integer|unique:schools,eiin',
            'sections' => 'required',
            'address' => 'required',
            'currentsession' => 'required',
            'admission_session' => 'required',
            'classes' => 'required',
            'isadmissionon' => 'required',
            'payment_method' => 'required',
            'isresultpublished' => 'required',
            'currentexam' => 'sometimes',
            'monogram' => 'sometimes'
        ]);

        $school = new School();
        $school->name = $request->name;
        $school->established = $request->established;
        $school->eiin = $request->eiin;
        $school->sections = $request->sections;
        $school->address = $request->address;
        $school->currentsession = $request->currentsession;
        $school->admission_session = $request->admission_session;
        $school->classes = implode (", ", $request->classes);
        $school->isadmissionon = $request->isadmissionon;
        $school->payment_method = $request->payment_method;
        $school->isresultpublished = $request->isresultpublished;
        $school->currentexam = $request->currentexam;
        //$school->monogram = $request->monogram;
        
        
        $school->save();
        // foreach ($request->input('roles') as $key => $value) {
        //     $user->attachRole($value);
        // }
        //$user->roles()->sync($request->roles, false);

        return redirect()->route('schools.index')
                        ->with('success','School created successfully');
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
        //
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
            'established' => 'required|integer',
            'eiin' => 'required|integer|unique:schools,eiin,'.$id,
            'sections' => 'required',
            'address' => 'required',
            'currentsession' => 'required',
            'admission_session' => 'required',
            'classes' => 'required',
            'isadmissionon' => 'required',
            'payment_method' => 'required',
            'isresultpublished' => 'required',
            'currentexam' => 'sometimes',
            'monogram' => 'sometimes'
        ]);


        $school = School::find($id);
        $school->name = $request->name;
        $school->established = $request->established;
        $school->eiin = $request->eiin;
        $school->sections = $request->sections;
        $school->address = $request->address;
        $school->currentsession = $request->currentsession;
        $school->admission_session = $request->admission_session;
        $school->classes = implode (", ", $request->classes);
        $school->isadmissionon = $request->isadmissionon;
        $school->payment_method = $request->payment_method;
        $school->isresultpublished = $request->isresultpublished;
        $school->currentexam = $request->currentexam;
        //$school->monogram = $request->monogram;
        
        
        $school->save();
        // foreach ($request->input('roles') as $key => $value) {
        //     $user->attachRole($value);
        // }
        //$user->roles()->sync($request->roles, false);

        return redirect()->route('schools.index')
                        ->with('success','School updated successfully');
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
