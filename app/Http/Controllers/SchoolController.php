<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\School;
use App\Upazilla;

use Validator, Input, Redirect, Session, DB;
use Auth;

class SchoolController extends Controller
{
    public function __construct(){
        $this->middleware('role:superadmin', ['except' => ['getDistrictsAPI', 'getUpazillasAPI', 'getSchoolsAPI', 'getSchool']]);
        //$this->middleware('permission:theSpecificPermission', ['only' => ['create', 'store', 'edit', 'delete']]);
    }


    public function index()
    {
        $districts = Upazilla::orderBy('id', 'asc')->groupBy('district')->get()->pluck('district');
        $schools = School::orderBy('id', 'ASC')->get();
        return view('schools.index')
                    ->withSchools($schools)
                    ->withDistricts($districts);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $districts = Upazilla::orderBy('id', 'asc')->groupBy('district')->get()->pluck('district');
        return view('schools.create')->withDistricts($districts);
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
            'name_bangla' => 'required',
            'established' => 'required|integer',
            'eiin' => 'required|integer|unique:schools,eiin',
            'sections' => 'required',
            'address' => 'required',
            'district' => 'required',
            'upazilla' => 'required',
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

        // generate unique_key
        $token_length = 100;
        $pool = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $token = substr(str_shuffle(str_repeat($pool, 100)), 0, $token_length);

        $school->token = $token;
        $school->name = $request->name;
        $school->name_bangla = $request->name_bangla;
        $school->established = $request->established;
        $school->eiin = $request->eiin;
        $school->sections = $request->sections;
        $school->address = $request->address;
        $school->district = $request->district;
        $school->upazilla = $request->upazilla;
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
            'name_bangla' => 'required',
            'established' => 'required|integer',
            'eiin' => 'required|integer|unique:schools,eiin,'.$id,
            'sections' => 'required',
            'address' => 'required',
            'district' => 'required',
            'upazilla' => 'required',
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
        $school->name_bangla = $request->name_bangla;
        $school->established = $request->established;
        $school->eiin = $request->eiin;
        $school->sections = $request->sections;
        $school->address = $request->address;
        $school->district = $request->district;
        $school->upazilla = $request->upazilla;
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

    public function getDistrictsAPI()
    {
        try {
          $districts = Upazilla::orderBy('id', 'asc')->groupBy('district')->get()->pluck('district');
          dd($districts);
        }
        catch (\Exception $e) {
          return $e->getMessage();
        }
    }

    public function getUpazillasAPI($district)
    {
        try {
          $upazillas = Upazilla::where('district', $district)->get()->pluck('upazilla');
          return $upazillas;
        }
        catch (\Exception $e) {
          return $e->getMessage();
        }
    }

    public function getSchoolsAPI($district, $upazilla)
    {
        try {
          $searched_schools = DB::table('schools')
                                    ->select(['token', 'name'])
                                    ->where('district', $district)
                                    ->where('upazilla', $upazilla)
                                    ->get();
          return $searched_schools;
        }
        catch (\Exception $e) {
          return $e->getMessage();
        }
    }

    public function getSchool($token) {
        
        try {
          $school = School::where('token', $token)->first();
          if($school != null) {
            return view('index.school')
                      ->withSchool($school);
          } else {
            return redirect()->route('index');
          }

        }
        catch (\Exception $e) {
          return redirect()->route('index');
        }
    }
}
