<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Services\PayUService\Exception;

use App\Admission;
use App\School;
use App\Student;
use App\Upazilla;

use Image;
use Validator, Input, Redirect, Session, File;
use Auth;
use Illuminate\Support\Facades\DB;
use PDF;

class AdmissionController extends Controller
{
    public function __construct(){
        $this->middleware('role:headmaster', ['except' => ['apply', 'store', 'getAdmissionStatusAPI', 'searchPaymentPage', 'getPaymentPage', 'retrieveApplicationId', 'retrieveApplicationIdAPI', 'pdfApplicantsCopy', 'pdfAdmitCard']]);
        //$this->middleware('permission:theSpecificPermission', ['only' => ['create', 'store', 'edit', 'delete']]);
    }

    public function index()
    {
        $admissions = Admission::where('school_id', Auth::User()->school_id)
                            ->where('session', Auth::User()->school->admission_session)
                            ->orderBy('id', 'ASC')->get();
        return view('admissions.index')
                    ->withAdmissions($admissions);
    }

    public function getClassWise($class)
    {
        $admissions = Admission::where('school_id', Auth::User()->school_id)
                            ->where('session', Auth::User()->school->admission_session)
                            ->where('class', $class)
                            ->orderBy('id', 'ASC')->get();
        return view('admissions.index')
                    ->withAdmissions($admissions)
                    ->withClass($class);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $school = School::find(Auth::user()->school->id);
        $districts = Upazilla::orderBy('id', 'asc')->groupBy('district')->get()->pluck('district');
        return view('admissions.create')
                  ->withSchool($school)
                  ->withDistricts($districts);
    }

    public function apply($id)
    {
        try {
          $school = School::find($id);
          $districts = Upazilla::orderBy('id', 'asc')->groupBy('district')->get()->pluck('district');
          if($school != null) {
            return view('admissions.create')
                        ->withSchool($school)
                        ->withDistricts($districts);
          } else {
            Session::flash('warning', 'আপনার কোথাও ভুল হচ্ছে! পুনরায় আরম্ভ করুন।');
            return redirect()->route('index');
          }
          
        }
        catch (\Exception $e) {
          Session::flash('warning', 'আপনার কোথাও ভুল হচ্ছে! পুনরায় আরম্ভ করুন।');
          return redirect()->route('index');
        }
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
            'class' => 'required',
            'section' => 'sometimes',
            'name' => 'required|max:255',
            'father' => 'required|max:255',
            'mother' => 'required|max:255',
            'fathers_occupation' => 'required|max:255',
            'yearly_income' => 'required|numeric',
            'religion' => 'required',
            'nationality' => 'required|max:255',
            'blood_group' => 'required',
            'dob' => 'required|max:255',
            'gender' => 'required|max:255',
            'cocurricular' => 'required',
            'village' => 'required|max:500',
            'post_office' => 'required|max:500',
            'upazilla' => 'required|max:500',
            'district' => 'required|max:500',
            'contact' => 'required',
            'contact_2' => 'required',
            'previous_school' => 'required|max:255',
            'pec_result' => 'required|max:255',
            'image' => 'sometimes|image|max:200' // sometimes for now...
        ]);
        $school = School::find($request->school_id);
        // $length = 5;
        // $pool = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        // $random_string = substr(str_shuffle(str_repeat($pool, 5)), 0, $length);
        $last_application = Admission::where('school_id', $school->id)
                                     ->where('session', $school->admission_session)
                                     ->orderBy('application_id', 'desc')
                                     ->first();
        //dd($last_application);
        if($last_application != null) {
            $application_id = $last_application->application_id + 1;
        } else {
            $first_id_for_application = str_pad(1, 3, '0', STR_PAD_LEFT);
            $application_id = (int)($school->eiin.(date('y', strtotime($school->admission_session))).$first_id_for_application);
        }
        //dd($application_id);

        $last_application_for_roll = Admission::where('school_id', $school->id)
                                     ->where('class', $request->class)
                                     ->where('session', $school->admission_session)
                                     ->orderBy('application_id', 'desc')
                                     ->first();
        if($last_application_for_roll != null) {
            $application_roll = $last_application_for_roll->application_roll + 1;
        } else {
            $first_roll_for_application = str_pad(1, 2, '0', STR_PAD_LEFT);
            $application_roll = $first_roll_for_application;
        }
        //dd($application_roll);

        $admission = new Admission;
        $admission->school_id = $request->school_id;
        $admission->application_id = $application_id;
        $admission->application_roll = $application_roll;

        $admission->class = $request->class;
        $admission->name = $request->name;
        $admission->father = $request->father;
        $admission->mother = $request->mother;
        $admission->fathers_occupation = $request->fathers_occupation;
        $admission->yearly_income = $request->yearly_income;
        $admission->religion = $request->religion;
        $admission->nationality = $request->nationality;
        $admission->blood_group = $request->blood_group;
        $admission->dob = \Carbon\Carbon::parse($request->dob);
        $admission->gender = $request->gender;
        $admission->cocurricular = implode(',', $request->cocurricular);
        $admission->village = $request->village;
        $admission->post_office = $request->post_office;
        $admission->upazilla = $request->upazilla;
        $admission->district = $request->district;
        $admission->contact = $request->contact;
        $admission->contact_2 = $request->contact_2;
        $admission->previous_school = $request->previous_school;
        $admission->pec_result = $request->pec_result;
        
        // image upload
        if($request->hasFile('image')) {
            $image      = $request->file('image');
            $filename   = $application_id.'.' . $image->getClientOriginalExtension();
            $location   = public_path('images/admission-images/'. $filename);

            Image::make($image)->resize(200, 200)->save($location);
            /*Image::make($image)->resize(300, 300, function ($constraint) {
            $constraint->aspectRatio();
            })->save($location);*/

            $admission->image = $filename;
        }

        $admission->session = $school->admission_session;
        $admission->payment = 0;
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
          if($application != null) {
            return view('admissions.payment')
                      ->withApplication($application);
          } else {
            Session::flash('warning', 'আইডি দিতে ভুল হয়েছে, আবার চেষ্টা করুন!');
            return redirect()->route('admissions.searchpayment');
          }
        }
        catch (\Exception $e) {
          Session::flash('warning', 'আইডি দিতে ভুল হয়েছে, আবার চেষ্টা করুন!');
          return redirect()->route('admissions.searchpayment');
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

    public function pdfApplicantsCopy($application_id)
    {
        $application = Admission::where('application_id', $application_id)->first();
        
        $pdf = PDF::loadView('admissions.pdf.applicantscopy', ['application' => $application]);
        $fileName = $application_id . '_Applicants_Cooy' . '.pdf';
        return $pdf->stream($fileName);
    }

    public function pdfAllApplications($class)
    {
        $applications = Admission::where('school_id', Auth::user()->school_id)
                                 ->where('session', Auth::user()->school->admission_session)
                                 ->where('class', $class)
                                 ->get();
        $pdf = PDF::loadView('admissions.pdf.applicantscopies', ['applications' => $applications], ['data' => $class]);
        $fileName = 'Class_'.$class.'_All_Applications' . '.pdf';
        return $pdf->stream($fileName);
    }

    public function pdfAllAdmitCards($class)
    {
        $applications = Admission::where('school_id', Auth::user()->school_id)
                                 ->where('session', Auth::user()->school->admission_session)
                                 ->where('class', $class)
                                 ->get();
        $pdf = PDF::loadView('admissions.pdf.admitcards', ['applications' => $applications], ['data' => $class]); // ['mode' => 'utf-8', 'format' => 'A4-L']
        $fileName = 'Class_'.$class.'_All_Admit_Cards' . '.pdf';
        return $pdf->stream($fileName);
    }

    public function pdfAdmissionSeatPlan($class)
    {
        $applications = Admission::where('school_id', Auth::user()->school_id)
                                 ->where('session', Auth::user()->school->admission_session)
                                 ->where('class',$class)
                                 ->get();
        $pdf = PDF::loadView('admissions.pdf.admissionseatplan', ['applications' => $applications], ['data' => $class]);
        $fileName = 'Class_'.$class.'_Seatplan' . '.pdf';
        return $pdf->stream($fileName);
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
        return redirect()->route('admissions.getclasswise', $application->class);
    }

    public function submitMarks(Request $request)
    {
        $this->validate($request, [
            'application_ids_with_marks' => 'required',
            'class'                      => 'required',
        ]);
        //dd($request->application_ids_with_marks);
        $ids_array = [];
        $marks_array = [];
        $application_ids_with_marks_array = explode(',', $request->application_ids_with_marks);
        foreach ($application_ids_with_marks_array as $application_id_with_marks) {
          $application_array = explode(':', $application_id_with_marks);
          $ids_array[] = $application_array[0];
          $marks_array[] = $application_array[1];
          
        }
        $newidmarks_array = array_combine($ids_array,$marks_array);
        // sort in descending array...
        arsort($newidmarks_array);
        //dd($newidmarks_array);
        $merit_position = 1;
        foreach ($newidmarks_array as $key => $value) {
          try {
            $application = Admission::where('application_id', $key)
                                    ->where('class', $request->class)
                                    ->first();
            $application->mark_obtained = $value;
            if(Auth::user()->school->admission_pass_mark > $value) {
              $application->merit_position = -1;
            } else {
              $application->merit_position = $merit_position;
            }
            $application->save();

            $merit_position++;
          }
          catch (\Exception $e) {
            // do nothing
          }
        }
        
        Session::flash('success', 'আবেদনকারীদের প্রাপ্ত নম্বর দাখিল করা হয়েছে!');
        return redirect()->route('admissions.getclasswise', $request->class);
    }

    public function finalSelection(Request $request)
    {
        $this->validate($request, [
            'application_ids_to_admit' => 'required',
            'class' => 'required',
            'section_to_final_admit' => 'required',
        ]);
        $application_ids = explode(',', $request->application_ids_to_admit);
        $ids_array = [];
        $merit_position_array = [];
        $application_ids_with_merit_position_array = explode(',', $request->application_ids_to_admit);
        foreach ($application_ids_with_merit_position_array as $application_id_with_merit_position) {
          $application_array = explode(':', $application_id_with_merit_position);
          $ids_array[] = $application_array[0];
          $merit_position_array[] = $application_array[1];
          
        }
        $newidmeritposition_array = array_combine($ids_array,$merit_position_array);
        // sort in descending array...
        asort($newidmeritposition_array);
        //dd($newidmeritposition_array);
        $rollandserial = 1;
        foreach ($newidmeritposition_array as $key => $value) {
          $application = Admission::where('application_id', $key)->first();

          $last_student_id = Student::where('school_id', $application->school_id)
                                    ->where('session', $application->session)
                                    ->where('class', $request->class)
                                    ->where('section', $request->section_to_final_admit)
                                    ->orderBy('student_id', 'desc')
                                    ->first();
          if($last_student_id != null) {
            $student_id = $last_student_id->student_id + 1;
            $roll = $last_student_id->roll + 1;
          } else {
            $student_id = $request->class.date('y', strtotime(Auth::user()->school->admission_session)).$application->school_id.$request->section_to_final_admit.str_pad($rollandserial, 3, '0', STR_PAD_LEFT);
            $roll = $rollandserial;
          }
          //dd($student_id);

          try {
            $student = new Student;
            $student->school_id = $application->school_id;
            $student->student_id = $student_id;

            $student->roll = $roll;

            $student->class = $application->class;
            $student->section = $request->section_to_final_admit;
            $student->name_bangla = $application->name_bangla;
            $student->name = $application->name;
            $student->father = $application->father;
            $student->mother = $application->mother;
            $student->fathers_occupation = $application->fathers_occupation;
            $student->mothers_occupation   = $application->mothers_occupation ;
            $student->yearly_income   = $application->yearly_income ;
            $student->religion   = $application->religion ;
            $student->nationality = $application->nationality;
            $student->blood_group = $application->blood_group;
            $student->dob = $application->dob;
            $student->gender = $application->gender;
            $student->cocurricular = $application->cocurricular;
            $student->village = $application->village;
            $student->post_office = $application->post_office;
            $student->upazilla = $application->upazilla;
            $student->district = $application->district;
            $student->contact = $application->contact;
            $student->contact_2 = $application->contact_2;
            $student->previous_school = $application->previous_school;
            $student->pec_result = $application->pec_result;
            $student->pec_result = $application->pec_result;
            $student->image = $application->image;
            $student->session = $application->session;
            //$student->payment = $application->payment;

            $student->save();
            Session::flash('success', 'আবেদনকারীদের শিক্ষার্থীতালিকায় অন্তর্ভুক্ত করা হয়েছে!');
          }
          catch (\Exception $e) {
            Session::flash('warning', $student->name_bangla.' ইতোমধ্যে আমাদের শিক্ষার্থীতালিকায় অন্তর্ভুক্ত রয়েছে!');
            // do nothing
          }
          $application->application_status = 'done';
          $application->save();

          $rollandserial++;
        }
      
        return redirect()->route('admissions.getclasswise', $request->class);
    }

    public function payBulk(Request $request)
    {
        $this->validate($request, [
            'application_ids'  => 'required',
            'class'            => 'required'
        ]);
        $application_ids_array = explode(',', $request->application_ids);
        foreach ($application_ids_array as $application_id) {
          $application = Admission::where('application_id', $application_id)->first();
          try {
            $application->payment = 1;
            $application->save();
          }
          catch (\Exception $e) {
            Session::flash('warning', $application->name_bangla.' এর পেমেন্ট ইতোমধ্যে দাখিল হয়েছে!');
            // do nothing
          }
        }
        
        Session::flash('success', 'আবেদনকারীদের পেমেন্ট সম্পন্ন করা হয়েছে!');
        return redirect()->route('admissions.getclasswise', $request->class);
    }

    public function pdfApplicantslist($class) {
        $applications = Admission::where('school_id', Auth::user()->school_id)
                                 ->where('session', Auth::user()->school->admission_session)
                                 ->where('class', $class)
                                 ->orderBy('mark_obtained', 'desc')
                                 ->get();

        $appeared = Admission::where('school_id', Auth::user()->school_id)
                                 ->where('session', Auth::user()->school->admission_session)
                                 ->where('class', $class)
                                 ->having('mark_obtained', '>=', 0)
                                 ->get();
        $passed = Admission::where('school_id', Auth::user()->school_id)
                                 ->where('session', Auth::user()->school->admission_session)
                                 ->where('class', $class)
                                 ->having('merit_position', '>', 0)
                                 ->get();
        $pdf = PDF::loadView('admissions.pdf.applicantslist', ['applications' => $applications], ['data' => [$class, $applications->count(), $appeared->count(), $passed->count()]]);
        $fileName = 'Class_'.$class.'_Applicants_List' . '.pdf';
        return $pdf->stream($fileName);
    }
}
