<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Student;
use App\School;
use App\Upazilla;

use SoapClient;
use Auth, Session, DB, File;
use Image;
use PDF;


class StudentController extends Controller
{
    public function index()
    {
        $students = Student::where('school_id', Auth::user()->school_id)
                           ->where('session', Auth::user()->school->currentsession)
                           ->orderBy('created_at','DESC')->get();
        return view('students.index')
                    ->withSessionsearch(null)
                    ->withClasssearch(null)
                    ->withSectionsearch(null)
                    ->withStudents($students);
    }

    public function getStudents($session, $class, $section)
    {
        if($section != 'No_Section') {
            $students = Student::where('school_id', Auth::user()->school_id)
                           ->where('session',$session)
                           ->where('class',$class)
                           ->where('section',$section)
                           ->orderBy('id','DESC')->get();

        } else {
        $students = Student::where('school_id', Auth::user()->school_id)
                           ->where('session',$session)
                           ->where('class',$class)
                           ->orderBy('id','DESC')->get();
        } 

        return view('students.index')
                    ->withSessionsearch($session)
                    ->withClasssearch($class)
                    ->withSectionsearch($section)
                    ->withStudents($students);
    }

    public function create()
    {
        $districts = Upazilla::orderBy('id', 'asc')->groupBy('district')->get()->pluck('district');
        $school = School::where('id', Auth::user()->school_id)->first();
        return view('students.create')
                    ->withDistricts($districts)
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
            'class' => 'required',
            'section' => 'required',
            'roll' => 'required',
            'session' => 'required',
            //'name_bangla' => 'required|max:255',
            'name' => 'required|max:255',
            'father' => 'required|max:255',
            'mother' => 'required|max:255',
            'fathers_occupation' => 'required|max:255',
            //'mothers_occupation' => 'required|max:255',
            'yearly_income' => 'required|numeric',
            'religion' => 'required',
            'nationality' => 'required|max:255',
            'blood_group' => 'required',
            'dob' => 'required|max:255',
            'gender' => 'required|max:255',
            'cocurricular' => 'required',
            'facility' => 'required',
            'village' => 'required|max:500',
            'post_office' => 'required|max:500',
            'upazilla' => 'required|max:500',
            'district' => 'required|max:500',
            'contact' => 'required',
            'contact_2' => 'required',
            'previous_school' => 'required|max:255',
            'pec_result' => 'required|max:255',
            'image' => 'sometimes|image|max:200',

            'jsc_registration_no' => 'sometimes',
            'jsc_roll' => 'sometimes',
            'jsc_session' => 'sometimes',
            'jsc_result' => 'sometimes',
            'jsc_subject_codes' => 'sometimes',
            'ssc_registration_no' => 'sometimes',
            'ssc_roll' => 'sometimes',
            'ssc_session' => 'sometimes',
            'ssc_result' => 'sometimes',
            'ssc_subject_codes' => 'sometimes',

            'remarks' => 'sometimes'
        ]);

        $school = School::where('id', Auth::user()->school_id)->first();
        //dd($application_id);
        if($school->sections > 0) {
          $last_student = Student::where('school_id', $school->id)
                                       ->where('class', $request->class)
                                       ->where('session', $school->currentsession)
                                       ->where('section', $request->section)
                                       ->orderBy('student_id', 'desc')
                                       ->first();
        } else {
          $last_student = Student::where('school_id', $school->id)
                                       ->where('class', $request->class)
                                       ->where('session', $school->currentsession)
                                       ->where('section', 0)
                                       ->orderBy('student_id', 'desc')
                                       ->first();
        }
        //dd($last_student);
        if($last_student != null) {
            $student_id = $last_student->student_id + 1;
        } else {
            $first_id_for_student = str_pad(1, 3, '0', STR_PAD_LEFT);
            if(date('m') > 10) {
                $admission_year = date('y') + 1;
            } else {
                $admission_year = date('y');
            }
            $student_id = $request->class.$admission_year.$school->id.$request->section.$first_id_for_student;
        }
        // dd($student_id);

        $student = new Student;
        $student->school_id = Auth::user()->school_id;
        $student->student_id = $student_id;

        $student->roll = $request->roll;
        $student->class = $request->class;
        $student->section = $request->section;
        //$student->name_bangla = $request->name_bangla;
        $student->name = $request->name;
        $student->father = $request->father;
        $student->mother = $request->mother;
        $student->fathers_occupation = $request->fathers_occupation;
        //$student->mothers_occupation   = $request->mothers_occupation ;
        $student->yearly_income   = $request->yearly_income ;
        $student->religion   = $request->religion ;
        $student->nationality = $request->nationality;
        $student->blood_group = $request->blood_group;
        $student->dob = \Carbon\Carbon::parse($request->dob);
        $student->gender = $request->gender;
        $student->cocurricular = implode(',', $request->cocurricular);
        $student->facility = $request->facility;
        $student->village = $request->village;
        $student->post_office = $request->post_office;
        $student->upazilla = $request->upazilla;
        $student->district = $request->district;
        $student->contact = $request->contact;
        $student->contact_2 = $request->contact_2;
        $student->previous_school = $request->previous_school;
        $student->pec_result = $request->pec_result;
        $student->pec_result = $request->pec_result;
        
        // image upload
        if($request->hasFile('image')) {
            $image      = $request->file('image');
            $filename   = $student_id. '.' . $image->getClientOriginalExtension();
            $location   = public_path('images/admission-images/'. $filename);
            Image::make($image)->resize(200, 200)->save($location);
            $student->image = $filename;
        }

        $student->jsc_registration_no = $request->jsc_registration_no;
        $student->jsc_roll = $request->jsc_roll;
        $student->jsc_session = $request->jsc_session;
        $student->jsc_result = $request->jsc_result;
        $student->jsc_subject_codes = $request->jsc_subject_codes;
        $student->jsc_fourth_subject_code = $request->jsc_fourth_subject_code;
        
        $student->ssc_registration_no = $request->ssc_registration_no;
        $student->ssc_roll = $request->ssc_roll;
        $student->ssc_session = $request->ssc_session;
        $student->ssc_result = $request->ssc_result;
        $student->ssc_subject_codes = $request->ssc_subject_codes;
        $student->ssc_fourth_subject_code = $request->ssc_fourth_subject_code;

        $student->session = $request->session;
        $student->remarks = $request->remarks;
        $student->save();

        Session::flash('success', 'সফলভাবে শিক্ষার্থী ভর্তি করা হয়েছে!');
        return redirect()->route('students.getstudents', [$request->session, $request->class, $request->section]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        try {
          $districts = Upazilla::orderBy('id', 'asc')->groupBy('district')->get()->pluck('district');
          $student = Student::where('id', $id)
                            ->where('school_id', Auth::user()->school_id)->first();
          if($student == null) {
            return redirect()->route('students.index');
          }
          return view('students.edit')
                    ->withDistricts($districts)
                    ->withStudent($student);
        }
        catch (\Exception $e) {
          return redirect()->route('students.index');
        }
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
            'class' => 'required',
            'section' => 'required',
            'roll' => 'required',
            'session' => 'required',
            //'name_bangla' => 'required|max:255',
            'name' => 'required|max:255',
            'father' => 'required|max:255',
            'mother' => 'required|max:255',
            'fathers_occupation' => 'required|max:255',
            //'mothers_occupation' => 'required|max:255',
            'yearly_income' => 'required|numeric',
            'religion' => 'required',
            'nationality' => 'required|max:255',
            'blood_group' => 'required',
            'dob' => 'required|max:255',
            'gender' => 'required|max:255',
            'cocurricular' => 'required',
            'facility' => 'required',
            'village' => 'required|max:500',
            'post_office' => 'required|max:500',
            'upazilla' => 'required|max:500',
            'district' => 'required|max:500',
            'contact' => 'required',
            'contact_2' => 'required',
            'previous_school' => 'required|max:255',
            'pec_result' => 'required|max:255',
            'image' => 'sometimes|image|max:200',

            'jsc_registration_no' => 'sometimes',
            'jsc_roll' => 'sometimes',
            'jsc_session' => 'sometimes',
            'jsc_result' => 'sometimes',
            'jsc_subject_codes' => 'sometimes',
            'ssc_registration_no' => 'sometimes',
            'ssc_roll' => 'sometimes',
            'ssc_session' => 'sometimes',
            'ssc_result' => 'sometimes',
            'ssc_subject_codes' => 'sometimes',
            'remarks' => 'sometimes'
        ]);

        $student = Student::find($id);
        $student->class = $request->class;
        $student->section = $request->section;
        $student->roll = $request->roll;
        $student->session = $request->session;
        //$student->name_bangla = $request->name_bangla;
        $student->name = $request->name;
        $student->father = $request->father;
        $student->mother = $request->mother;
        $student->fathers_occupation = $request->fathers_occupation;
        //$student->mothers_occupation   = $request->mothers_occupation ;
        $student->yearly_income   = $request->yearly_income ;
        $student->religion   = $request->religion ;
        $student->nationality = $request->nationality;
        $student->blood_group = $request->blood_group;
        $student->dob = \Carbon\Carbon::parse($request->dob);
        $student->gender = $request->gender;
        $student->cocurricular = implode(',', $request->cocurricular);
        $student->facility = $request->facility;
        $student->village = $request->village;
        $student->post_office = $request->post_office;
        $student->upazilla = $request->upazilla;
        $student->district = $request->district;
        $student->contact = $request->contact;
        $student->contact_2 = $request->contact_2;
        $student->previous_school = $request->previous_school;
        $student->pec_result = $request->pec_result;
        $student->pec_result = $request->pec_result;
        
        // image upload
        if($student->image != null || $student->image != '') {
            if($request->hasFile('image')) {
                $image      = $request->file('image');
                $filename   = $student->image;
                $location   = public_path('images/admission-images/'. $filename);
                Image::make($image)->resize(200, 200)->save($location);
                $student->image = $filename;
            }
        } else {
            if($request->hasFile('image')) {
                $image      = $request->file('image');
                $filename   = $student->student_id. '.' . $image->getClientOriginalExtension();
                $location   = public_path('images/admission-images/'. $filename);
                Image::make($image)->resize(200, 200)->save($location);
                $student->image = $filename;
            }
        }

        if($student->class > 7) {
          $student->jsc_registration_no = $request->jsc_registration_no;
          $student->jsc_roll = $request->jsc_roll;
          $student->jsc_session = $request->jsc_session;
          $student->jsc_result = $request->jsc_result;
          $student->jsc_subject_codes = $request->jsc_subject_codes;
          $student->jsc_fourth_subject_code = $request->jsc_fourth_subject_code;
        }
        if($student->class > 8) {
          $student->ssc_registration_no = $request->ssc_registration_no;
          $student->ssc_roll = $request->ssc_roll;
          $student->ssc_session = $request->ssc_session;
          $student->ssc_result = $request->ssc_result;
          $student->ssc_subject_codes = $request->ssc_subject_codes;
          $student->ssc_fourth_subject_code = $request->ssc_fourth_subject_code;
        }

        $student->session = $request->session;
        $student->remarks = $request->remarks;
        $student->save();

        Session::flash('success', 'সফলভাবে হালনাগাদ করা হয়েছে!');
        return redirect()->route('students.getstudents', [$request->session, $request->class, $request->section]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Student::find($id)->delete();
        return redirect()->route('students.index')
                        ->with('success','Student deleted successfully');
    }

    public function promoteBulk(Request $request)
    {
        $student_ids = explode(',', $request->student_ids);
        foreach ($student_ids as $student_id) {
            $student = Student::find($student_id);
            $student->class = $request->promotion_class;
            $student->session = $request->promotion_session;
            $student->save();
        }
        return redirect()->route('students.index')
                     ->with('success','সফলভাবে উন্নীত করা হয়েছে!');
    }

    public function sendsms()
    {
        try{
            $soapClient = new SoapClient("https://api2.onnorokomSMS.com/sendSMS.asmx?wsdl");
            $paramArray = array(
                'userName' => "01751398392",
                'userPassword' => "OnnoRokomRocks.1992",
            );
            $value = $soapClient->__call("GetBalance", array($paramArray));
            $netBalance = floor($value->GetBalanceResult/0.60);
            echo 'Balance: '.$netBalance.'<br/>';
        } catch (Exception $e) {
            echo $e->getMessage();
        }

        try{
            $soapClient = new SoapClient("https://api2.onnorokomSMS.com/sendSMS.asmx?wsdl");
            $paramArray = array(
            'userName' => "",
            'userPassword' => "",
            'mobileNumber' => "01751398392",
            'smsText' => "This is a SMS. ইহা একটি পরীক্ষামূলক বার্তা।",
            'type' => "TEXT",
            'maskName' => '',
            'campaignName' => '',
            );
            $value = $soapClient->__call("OneToOne", array($paramArray));
            echo $value->OneToOneResult;
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public function getStudentListPDF($session, $class, $section)
    {
        $students = Student::where('school_id', Auth::user()->school_id)
                           ->where('session', $session)
                           ->where('class', $class)
                           ->where('section', $section)
                           ->get();
        $pdf = PDF::loadView('students.pdf.studentslist', ['students' => $students], ['data' => [$session, $class, $section]], ['mode' => 'utf-8', 'format' => 'A4-L']);
        $fileName = $session.'_'.$class.'_'.$section.'.pdf';
        return $pdf->stream($fileName);
    }
}