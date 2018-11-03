<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Student;
use SoapClient;
use Auth, Session, DB, File;
use Image;


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
        $students = Student::where('school_id', Auth::user()->school_id)
                           ->where('session',$session)
                           ->where('class',$class)
                           ->where('section',$section)
                           ->orderBy('id','DESC')->get();

        return view('students.index')
                    ->withSessionsearch($session)
                    ->withClasssearch($class)
                    ->withSectionsearch($section)
                    ->withStudents($students);
    }


    public function classwise(Request $request, $class)
    {
        $students = Student::where('class', $class)->orderBy('id','DESC')->paginate(5);
        return view('students.index',compact('students'))
            ->with('i', ($request->input('page', 1) - 1) * 5);
    }

    public function create()
    {
        return view('students.create');
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
            'class' => 'required',
            'roll' => 'required',
        ]);

        Student::create($request->all());

        return redirect()->route('students.index')
                        ->with('success','Student created successfully');
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
          $student = Student::where('id', $id)
                            ->where('school_id', Auth::user()->school_id)->first();
          if($student == null) {
            return redirect()->route('students.index');
          }
          return view('students.edit',compact('student'));
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
            'name_bangla' => 'required|max:255',
            'name' => 'required|max:255',
            'father' => 'required|max:255',
            'mother' => 'required|max:255',
            'dob' => 'required|max:255',
            'address' => 'required|max:500',
            'contact' => 'required|numeric',
            'class' => 'required',
            'section' => 'required',
            'roll' => 'required|numeric',
            'session' => 'required|numeric',
            'image' => 'sometimes|image|max:200'
        ]);

        $student = Student::find($id);
        $student->name_bangla = $request->name_bangla;
        $student->name = $request->name;
        $student->father = $request->father;
        $student->mother = $request->mother;
        $student->dob = \Carbon\Carbon::parse($request->dob);
        $student->address = $request->address;
        $student->contact = $request->contact;
        $student->class = $request->class;
        $student->section = $request->section;
        $student->roll = $request->roll;
        $student->session = $request->session;

        // image upload
        if($request->hasFile('image')) {
            $image      = $request->file('image');
            $filename   = $student->image;
            $location   = public_path('images/admission-images/'. $filename);
            Image::make($image)->resize(200, 200)->save($location);
            $student->image = $filename;
        }

        $student->save();

        Session::flash('success', 'সফলভাবে হালনাগাদ করা হয়েছে!');
        return redirect()->route('students.getstudents', [$student->session, $student->class, $student->section]);
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
}