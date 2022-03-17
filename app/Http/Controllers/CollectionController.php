<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Student;
use App\User;

use Auth, Session, DB, File;
use Image;
use PDF;

class CollectionController extends Controller
{
    public function __construct() {
        $this->middleware('role:headmaster', ['except' => ['getSubmissionPage']]);
        //$this->middleware('permission:theSpecificPermission', ['only' => ['create', 'store', 'edit', 'delete']]);
    }
    
    public function index()
    {
        return view('collection.index');
    }
    
    public function inputForm()
    {
        $students = Student::where('school_id', Auth::user()->school_id)
                           ->where('session', Auth::user()->school->currentsession)
                           ->orderBy('created_at','DESC')->get();

        return view('collection.inputform')
                    ->withSessionsearch(null)
                    ->withClasssearch(null)
                    ->withSectionsearch(null)
                    ->withStudents(null)
                    ->withTeachers(null);
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

        $teachers = User::where('school_id', Auth::user()->school_id)->get();
        
        foreach ($teachers as $teacher) {
            $rolesarray = [];
            foreach($teacher->roles as $role) {
                $rolesarray[] = $role->name;
            }
            if(in_array('superadmin', $rolesarray)) {
                $remove_id = $teacher->id;
                $teachers = $teachers->reject(function ($value, $key) use($remove_id) {
                    return $value->id == $remove_id;
                });
            }
        }
        // dd($teachers);

        return view('collection.inputform')
                    ->withSessionsearch($session)
                    ->withClasssearch($class)
                    ->withSectionsearch($section)
                    ->withStudents($students)
                    ->withTeachers($teachers);
    }
    
    public function storeCollection(Request $request, $session, $class, $section)
    {
        $this->validate($request, [
            'school_id'     => 'collection_date',
            'exam_id'       => 'collector',
        ]);

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

        foreach($students as $student) {
            if($request['admissio_session_fee'.$student->student_id]) {
                dd($request['admissio_session_fee'.$student->student_id]);
            }
        }

        dd($request->all());
        date('Y-m-d', strtotime($request->collection_date));
    }

    // $table->string('admissio_session_fee');
    // $table->string('annual_sports_cultural');
    // $table->string('last_year_due');
    // $table->string('exam_fee');
    // $table->string('full_half_free_form');
    // $table->string('3_6_8_12_fee');
    // $table->string('jsc_ssc_form_fee');
    // $table->string('certificate_fee');
    // $table->string('scout_fee');
    // $table->string('develoment_donation');
    // $table->string('other_fee');
}
