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


class PromotionController extends Controller
{
    public function __construct(){
        $this->middleware('role:headmaster');
        //$this->middleware('permission:theSpecificPermission', ['only' => ['create', 'store', 'edit', 'delete']]);
    }

    public function index()
    {
        return view('promotion.index')
                    ->withSessionsearch(null)
                    ->withClasssearch(null)
                    ->withSectionsearch(null)
                    ->withStudents(null);
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

        return view('promotion.index')
                    ->withSessionsearch($session)
                    ->withClasssearch($class)
                    ->withSectionsearch($section)
                    ->withStudents($students);
    }

    public function promoteBulk(Request $request)
    {
    	$this->validate($request, [
    	    'promotion_class'    => 'required',
    	    'promotion_section'  => 'required',
    	    'promotion_session'  => 'required',
    	    'student_ids'        => 'required'
    	]);

        $ids_array = [];
        $rolls_array = [];
        $student_ids = explode(',', $request->student_ids);
        foreach ($student_ids as $student_id_data) {
          $student_array = explode(':', $student_id_data);
          $ids_array[] = $student_array[0];
          $rolls_array[] = $student_array[1];
        }
        $newidrolls_array = array_combine($ids_array,$rolls_array);
        // dd($newidrolls_array);

        foreach ($newidrolls_array as $key => $value) {
          try {
            $student = Student::where('student_id', $key)->first();
            $student->roll = $value;
            $student->class = $request->promotion_class;
            $student->section = $request->promotion_section;
            $student->session = $request->promotion_session;
            $student->save();
          }
          catch (\Exception $e) {
          	Session::flash('warning', 'সমস্যা হচ্ছে! আবার চেষ্টা করুন।');
            return redirect()->back();
          }
        }

        return redirect()->back()->with('success','সফলভাবে উন্নীত করা হয়েছে!');
    }
}