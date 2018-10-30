<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\School;

use Validator, Input, Redirect, Session;
use Auth;
use DB;
use Image;
use File;

class SettingController extends Controller
{
    public function __construct(){
        $this->middleware('role:headmaster');
    }

    public function edit()
    {
        $school = School::where('id', Auth::user()->school_id)->first();
        return view('settings.edit')->withSchool($school);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required',
            'established' => 'required|integer',
            'eiin' => 'required|integer|unique:schools,eiin,'.$id,
            'address' => 'required',
            'currentsession' => 'required',
            'classes' => 'required',
            'isadmissionon' => 'required',
            'payment_method' => 'required',
            'admission_form_fee' => 'required',
            'isresultpublished' => 'required',
            'currentexam' => 'sometimes',
            'monogram' => 'sometimes|image|max:100'
        ]);


        $school = School::find($id);
        $school->name = $request->name;
        $school->established = $request->established;
        $school->eiin = $request->eiin;
        $school->address = $request->address;
        $school->currentsession = $request->currentsession;
        $school->classes = implode (", ", $request->classes);
        $school->isadmissionon = $request->isadmissionon;
        $school->payment_method = $request->payment_method;
        $school->admission_form_fee = $request->admission_form_fee;
        $school->isresultpublished = $request->isresultpublished;
        $school->currentexam = $request->currentexam;

        // monogram upload
        if(!$school->monogram == NULL || !$school->monogram == ''){
            if($request->hasFile('monogram')) {
                $monogram      = $request->file('monogram');
                $filename   = $school->monogram;
                $location   = public_path('/images/schools/'. $filename);
                Image::make($monogram)->resize(100, 100)->save($location);
                $school->monogram = $filename;
            }
        } else {
            if($request->hasFile('monogram')) {
                $monogram      = $request->file('monogram');
                $filename   = str_replace(' ','',$request->eiin).time() .'.' . $monogram->getClientOriginalExtension();
                $location   = public_path('images/schools/'. $filename);
                Image::make($monogram)->resize(100, 100)->save($location);
                $school->monogram = $filename;
            }
        }
        
        $school->save();

        return redirect()->route('settings.edit')
                        ->with('success','School updated successfully');
    }
}
