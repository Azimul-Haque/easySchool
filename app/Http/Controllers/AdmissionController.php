<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Services\PayUService\Exception;

use App\Admission;
use App\School;
use App\Student;

use Image;
use Validator, Input, Redirect, Session, File;
use Auth;
use Illuminate\Support\Facades\DB;
use PDF;

class AdmissionController extends Controller
{
    public function __construct(){
        $this->middleware('role:headmaster', ['except' => ['create', 'apply', 'store', 'getAdmissionStatusAPI', 'searchPaymentPage', 'getPaymentPage', 'retrieveApplicationId', 'retrieveApplicationIdAPI', 'pdfAdmitCard']]);
        //$this->middleware('permission:theSpecificPermission', ['only' => ['create', 'store', 'edit', 'delete']]);
    }

    public function index()
    {
        $admissions = Admission::where('school_id', Auth::User()->school_id)
                            ->where('session', Auth::User()->school->currentsession)
                            ->where('application_status', null)
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
            'image' => 'required|image|max:200'
        ]);

        if($request->school_id == 'manual') {
            $request->school_id = Auth::User()->school->id;
        }

        $school = School::find($request->school_id);
        // $length = 5;
        // $pool = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        // $random_string = substr(str_shuffle(str_repeat($pool, 5)), 0, $length);
        
        //dd($application_id);
        $last_application = Admission::where('school_id', $school->id)
                                     ->where('class', $request->class)
                                     ->where('session', $school->currentsession)
                                     ->orderBy('application_id', 'desc')
                                     ->first();
        if($last_application != null) {
            $application_id = $last_application->application_id + 1;
            //dd($application_id);
        } else {
            $first_id_for_application = str_pad(1, 3, '0', STR_PAD_LEFT);
            if(date('m') > 10) {
                $admission_year = date('y') + 1;
            } else {
                $admission_year = date('Y');
            }
            $application_id = $request->class.$admission_year.$school->id.$first_id_for_application;
            //dd($application_id);
        }
        

        $admission = new Admission;
        $admission->school_id = $request->school_id;
        $admission->application_id = $application_id;
        $admission->application_roll = substr($application_id, -3);
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
        $application = Admission::find($id);
        if($application->image != null) {
          $image_path = public_path('images/admission-images/'. $application->image);
          if(File::exists($image_path)) {
              File::delete($image_path);
          }
        }
        $application->delete();
        Session::flash('success', 'আবেদনটি ডিলেট করা হয়েছে!');
        return redirect()->route('admissions.index');
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

    public function pdfAdmitCard($application_id)
    {
        $application = Admission::where('application_id', $application_id)->first();
        
        $pdf = PDF::loadView('admissions.pdf.admitcard', ['application' => $application], ['data' => $application_id]);
        $fileName = $application_id . '_Admit_Card' . '.pdf';
        return $pdf->stream($fileName);
    }

    public function updatePaymentManual($id)
    {
        $application = Admission::find($id);
        $application->payment = 1;
        $application->save();
        
        Session::flash('success', 'পেমেন্ট সফল হয়েছে!');
        return redirect()->route('admissions.index');
    }

    public function finalSelection(Request $request)
    {
        $this->validate($request, [
            'application_ids' => 'required',
        ]);
        $application_ids_array = explode(',', $request->application_ids);
        foreach ($application_ids_array as $application_id) {
          $application = Admission::where('application_id', $application_id)->first();
          try {
            $student = new Student;
            $student->school_id = $application->school_id;
            $student->application_id = $application_id;
            $student->name_bangla = $application->name_bangla;
            $student->name = $application->name;
            $student->father = $application->father;
            $student->mother = $application->mother;
            $student->nationality = $application->nationality;
            $student->gender = $application->gender;
            $student->dob = $application->dob;
            $student->address = $application->address;
            $student->contact = $application->contact;
            $student->session = $application->session;
            $student->class = $application->class;
            $student->image = $application->image;
            $student->save();
          }
          catch (\Exception $e) {
            Session::flash('warning', $student->name_bangla.' ইতোমধ্যে আমাদের শিক্ষার্থীতালিকায় অন্তর্ভুক্ত রয়েছে!');
            // do nothing
          }
          $application->application_status = 'done';
          $application->save();
        }
        
        Session::flash('success', 'আবেদনকারীদের শিক্ষার্থীতালিকায় অন্তর্ভুক্ত করা হয়েছে!');
        return redirect()->route('admissions.index');
    }
}
