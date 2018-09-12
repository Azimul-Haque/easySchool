<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Services\PayUService\Exception;

use App\Admission;
use App\School;

use Validator, Input, Redirect, Session;
use Auth;

class AdmissionController extends Controller
{
    public function __construct(){
        $this->middleware('role:headmaster', ['except' => ['create', 'apply', 'getAdmissionStatusAPI']]);
        //$this->middleware('permission:theSpecificPermission', ['only' => ['create', 'store', 'edit', 'delete']]);
    }

    public function index()
    {
        $admissions = Admission::where('school_id', Auth::User()->school_id)
                            ->where('session', Auth::User()->school->currentsession)
                            ->orderBy('id', 'ASC')->get();
        return view('admissions.index')
                    ->withAdmissions($admissions);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admissions.create');
    }
    public function apply($id)
    {
        $school = School::find($id);
        return view('admissions.create')
                    ->withSchool($school);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        dd($request->all());
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
        //
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

    public function getAdmissionStatusAPI($id)
    {
        try {
          $school = School::find($id);
          return $school->isadmissionon;
        }
        catch (\Exception $e) {
            return $e->getMessage();
        }
        
    }
    public function admissionToggleOn($id)
    {
        $school = School::find($id);
        $school->isadmissionon = 1;
        $school->save();

        return 'success';
    }
    public function admissionToggleOff($id)
    {
        $school = School::find($id);
        $school->isadmissionon = 0;
        $school->save();

        return 'success';
    }


}
