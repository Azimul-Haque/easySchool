<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Student;
use SoapClient;


class StudentController extends Controller
{
    public function index(Request $request)
    {
        $students = Student::orderBy('id','DESC')->paginate(5);
        return view('students.index',compact('students'))
            ->with('i', ($request->input('page', 1) - 1) * 5);
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
        $student = Student::find($id);
        return view('students.show',compact('student'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $student = Student::find($id);
        return view('students.edit',compact('student'));
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
            'class' => 'required',
            'roll' => 'required',
        ]);

        Student::find($id)->update($request->all());

        return redirect()->route('students.index')
                        ->with('success','Student updated successfully');
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