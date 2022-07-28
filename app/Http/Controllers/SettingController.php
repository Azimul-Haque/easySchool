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
use Carbon\Carbon;

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
            'name_bangla' => 'required',
            'established' => 'required|integer',
            'eiin' => 'required|integer|unique:schools,eiin,'.$id,
            'school_code' => 'required',
            'contact' => 'required',
            'sections' => 'required',
            'address' => 'required',
            'currentsession' => 'required',
            'classes' => 'required',
            'payment_method' => 'required',
            'isresultpublished' => 'required',
            'monogram' => 'sometimes|image|max:100',
            'website' => 'sometimes'
        ]);


        $school = School::find($id);
        $school->name = $request->name;
        $school->name_bangla = $request->name_bangla;
        $school->established = $request->established;
        $school->eiin = $request->eiin;
        $school->school_code = $request->school_code;
        $school->contact = $request->contact;
        $school->sections = $request->sections;
        $school->address = $request->address;
        $school->currentsession = $request->currentsession;
        $school->classes = implode (",", $request->classes);
        $school->payment_method = $request->payment_method;
        $school->isresultpublished = $request->isresultpublished;
        // $school->currentexam = $request->currentexam; // ommited

        // sign upload
        if($request->hasFile('headmaster_sign')) {
            $image = $request->file('headmaster_sign');
            if(file_exists(public_path('/images/schools/signs/' . $school->headmaster_sign)) && $school->headmaster_sign != '') {
                unlink(public_path('/images/schools/signs/' . $school->headmaster_sign));
            }
            $filename   = 'sign_'. time() .'_'.$school->eiin.'.' . $image->getClientOriginalExtension();
            $location   = public_path('/images/schools/signs/'. $filename);
            Image::make($image)->resize(300, 80)->save($location);
            $school->headmaster_sign = $filename;
        }

        // monogram upload
        if($request->hasFile('monogram')) {
            $image = $request->file('monogram');
            if(file_exists(public_path('/images/schools/monograms/' . $school->monogram))) {
                unlink(public_path('/images/schools/monograms/' . $school->monogram));
            }
            $filename   = 'monogram_'. time() .'_'.$school->eiin.'.' . $image->getClientOriginalExtension();
            $location   = public_path('/images/schools/monograms/'. $filename);
            Image::make($image)->resize(200, 200)->save($location); // ->opacity(50) diye arekta save korte hobe background er jonno...
            $school->monogram = $filename;
        }
        
        // website update
        if(!empty($request->website)) {
            $school->website = $request->website;
        }
        
        $school->save();

        return redirect()->route('settings.edit')
                        ->with('success','School updated successfully');
    }

    public function updateAdmission(Request $request, $id) {
        $this->validate($request, [
            'admission_session' => 'sometimes',
            'admission_total_marks' => 'sometimes',
            'admission_bangla_mark' => 'sometimes',
            'admission_english_mark' => 'sometimes',
            'admission_math_mark' => 'sometimes',
            'admission_gk_mark' => 'sometimes',
            'isadmissionon' => 'required',
            'admission_form_fee' => 'sometimes',
            'admission_pass_mark' => 'sometimes',
            'admission_start_date' => 'sometimes',
            'admission_end_date' => 'sometimes',
            'admission_test_datetime' => 'sometimes',
            'admission_test_result' => 'sometimes',
            'admission_final_start' => 'sometimes',
            'admission_final_end' => 'sometimes',
            'admit_card_texts' => 'sometimes'
        ]);

        $school = School::find($id);
        $school->admission_session = $request->admission_session;
        $school->admission_total_marks = $request->admission_total_marks;
        $school->admission_bangla_mark = $request->admission_bangla_mark;
        $school->admission_english_mark = $request->admission_english_mark;
        $school->admission_math_mark = $request->admission_math_mark;
        $school->admission_gk_mark = $request->admission_gk_mark;
        $school->isadmissionon = $request->isadmissionon;
        $school->admission_form_fee = $request->admission_form_fee;
        $school->admission_pass_mark = $request->admission_pass_mark;
        $school->admission_start_date = new Carbon($request->admission_start_date);
        $school->admission_end_date = new Carbon($request->admission_end_date);
        $school->admission_test_datetime = new Carbon($request->admission_test_datetime);
        $school->admission_test_result = new Carbon($request->admission_test_result);
        $school->admission_final_start = new Carbon($request->admission_final_start);
        $school->admission_final_end = new Carbon($request->admission_final_end);
        $school->admit_card_texts = nl2br($request->admit_card_texts);
        $school->save();

        return redirect()->route('settings.edit')
                        ->with('success','ভর্তি প্রক্রিয়ার সেটিংস সফলভাবে সংরক্ষিত হয়েছে!');
    }
}
