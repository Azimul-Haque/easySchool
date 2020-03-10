<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\School;
use App\Upazilla;

use Image;
use Validator, Input, Redirect, Session, DB;
use Auth;
use Carbon\Carbon;

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
            'section_type' => 'required',
            'address' => 'required',
            'district' => 'required',
            'upazilla' => 'required',
            'address' => 'required',
            'currentsession' => 'required',
            'admission_session' => 'sometimes',
            'classes' => 'required',
            'isadmissionon' => 'required',
            'payment_method' => 'required',
            'isresultpublished' => 'required',
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
        $school->section_type = $request->section_type;
        $school->address = $request->address;
        $school->district = $request->district;
        $school->upazilla = $request->upazilla;
        $school->currentsession = $request->currentsession;
        $school->admission_session = $request->admission_session ? $request->admission_session : $request->currentsession;;
        $school->classes = implode (",", $request->classes);
        $school->isadmissionon = $request->isadmissionon;
        $school->payment_method = $request->payment_method;
        $school->isresultpublished = $request->isresultpublished;
        // $school->currentexam = $request->currentexam; // ommited

        // image upload
        if($request->hasFile('monogram')) {
            $image      = $request->file('monogram');
            if($school->monogram == null || $school->monogram == '') {
              $filename   = 'monogram_'. time() .'_'.$school->eiin.'.' . $image->getClientOriginalExtension();
            } else {
              $filename = $school->monogram;
            }
            $location   = public_path('images/schools/monograms/'. $filename);
            Image::make($image)->resize(200, 200)->save($location);
            $school->monogram = $filename;
        }
        
        
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
            'section_type' => 'required',
            'address' => 'required',
            'district' => 'required',
            'upazilla' => 'required',
            'currentsession' => 'required',
            'admission_session' => 'required',
            'classes' => 'required',
            'payment_method' => 'required',
            'isresultpublished' => 'required',

            'admission_form_fee' => 'sometimes',
            'admission_total_marks' => 'sometimes',
            'admission_bangla_mark' => 'sometimes',
            'admission_english_mark' => 'sometimes',
            'admission_math_mark' => 'sometimes',
            'admission_gk_mark' => 'sometimes',
            'isadmissionon' => 'required',
            'admission_pass_mark' => 'sometimes',
            'admission_start_date' => 'sometimes',
            'admission_end_date' => 'sometimes',
            'admission_test_datetime' => 'sometimes',
            'headmaster_sign' => 'sometimes',
            'monogram' => 'sometimes'
        ]);


        $school = School::find($id);
        $school->name = $request->name;
        $school->name_bangla = $request->name_bangla;
        $school->established = $request->established;
        $school->eiin = $request->eiin;
        $school->sections = $request->sections;
        $school->section_type = $request->section_type;
        $school->address = $request->address;
        $school->district = $request->district;
        $school->upazilla = $request->upazilla;
        $school->currentsession = $request->currentsession;
        $school->classes = implode (",", $request->classes);
        $school->payment_method = $request->payment_method;
        $school->isresultpublished = $request->isresultpublished;
        // $school->currentexam = $request->currentexam; // ommited
        
        $school->admission_session = $request->admission_session;
        $school->admission_form_fee = $request->admission_form_fee;
        $school->admission_total_marks = $request->admission_total_marks;
        $school->admission_bangla_mark = $request->admission_bangla_mark;
        $school->admission_english_mark = $request->admission_english_mark;
        $school->admission_math_mark = $request->admission_math_mark;
        $school->admission_gk_mark = $request->admission_gk_mark;
        $school->isadmissionon = $request->isadmissionon;
        $school->admission_pass_mark = $request->admission_pass_mark;
        $school->admission_start_date = new Carbon($request->admission_start_date);
        $school->admission_end_date = new Carbon($request->admission_end_date);
        $school->admission_test_datetime = new Carbon($request->admission_test_datetime);

        // sign upload
        if($request->hasFile('headmaster_sign')) {
            $image      = $request->file('headmaster_sign');
            if($school->headmaster_sign == null || $school->headmaster_sign == '') {
              $filename   = 'sign_'.str_replace(' ', '_', $school->name).'_'.$school->eiin.'.' . $image->getClientOriginalExtension();
            } else {
              $filename = $school->headmaster_sign;
            }
            $location   = public_path('/images/schools/signs/'. $filename);
            Image::make($image)->resize(300, 80)->save($location);
            $school->headmaster_sign = $filename;
        }
        // monogram upload
        if($request->hasFile('monogram')) {
            $image      = $request->file('monogram');
            if($school->monogram == null || $school->monogram == '') {
              $filename   = 'monogram_'. time() .'_'.$school->eiin.'.' . $image->getClientOriginalExtension();
            } else {
              $filename = $school->monogram;
            }
            $location   = public_path('/images/schools/monograms/'. $filename);
            Image::make($image)->resize(200, 200)->save($location);
            $school->monogram = $filename;
        }
        
        
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
