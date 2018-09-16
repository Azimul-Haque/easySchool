<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Services\PayUService\Exception;

use App\Admission;
use App\School;

use Image;
use Validator, Input, Redirect, Session;
use Auth;

class AdmissionController extends Controller
{
    public function __construct(){
        $this->middleware('role:headmaster', ['except' => ['create', 'apply', 'store', 'getAdmissionStatusAPI', 'searchPaymentPage', 'getPaymentPage', 'retrieveApplicationId', 'retrieveApplicationIdAPI']]);
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
        $this->validate($request, [
            'school_id' => 'required',
            'name_bangla' => 'required|max:255',
            'name' => 'required|max:255',
            'father' => 'required|max:255',
            'mother' => 'required|max:255',
            'nationality' => 'required|max:255',
            'gender' => 'required|max:255',
            'dob' => 'required|max:255',
            'address' => 'required|max:500',
            'contact' => 'required|max:255',
            'class' => 'required',
            'image' => 'required|image|max:100'
        ]);

        if($request->school_id == 'manual') {
            $request->school_id = Auth::User()->school->id;
        }

        $school = School::find($request->school_id);
        $length = 5;
        $pool = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $random_string = substr(str_shuffle(str_repeat($pool, 5)), 0, $length);
        $application_id = $school->eiin.$request->class.$random_string;

        $admission = new Admission;
        $admission->school_id = $request->school_id;
        $admission->application_id = $application_id;
        $admission->name_bangla = $request->name_bangla;
        $admission->name = $request->name;
        $admission->father = $request->father;
        $admission->mother = $request->mother;
        $admission->nationality = $request->nationality;
        $admission->gender = $request->gender;
        $admission->dob = \Carbon\Carbon::parse($request->dob);
        $admission->address = $request->address;
        $admission->contact = $request->contact;
        $admission->session = $school->currentsession;
        $admission->class = $request->class;
        $admission->payment = 0;

        // image upload
        if($request->hasFile('image')) {
            $image      = $request->file('image');
            $filename   = str_replace(' ','', $request->name).$application_id.'.' . $image->getClientOriginalExtension();
            $location   = public_path('images/admission-images/'. $filename);

            Image::make($image)->resize(200, 200)->save($location);
            /*Image::make($image)->resize(300, 300, function ($constraint) {
            $constraint->aspectRatio();
            })->save($location);*/

            $admission->image = $filename;
        }

        $admission->save();
        
        Session::flash('success', 'আবেদনটি সফলভাবে সম্পন্ন হয়েছে!');
        return redirect()->route('admissions.getpayment', $application_id);

    }

    public function searchPaymentPage()
    {
        return view('admissions.admissionpaymentsearch');
    }

    public function getPaymentPage($application_id)
    {
        try {
          $application = Admission::where('application_id', $application_id)->first();
          //dd($application);
          return view('admissions.payment')
                    ->withApplication($application);
        }
        catch (\Exception $e) {
          return $e->getMessage();
        }
    }

    public function retrieveApplicationId()
    {
        return view('admissions.retrieveapplicationid');
    }

    public function retrieveApplicationIdAPI($dob, $contact)
    {
        try {
          $dob = \Carbon\Carbon::parse($dob);
          $application = Admission::where('dob', $dob)
                                     ->where('contact', $contact)
                                     ->first();
          return $application->application_id;
        }
        catch (\Exception $e) {
          return 'তথ্য দিতে ভুল হচ্ছে, আবার চেষ্টা করুন!';
        }

    }

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
