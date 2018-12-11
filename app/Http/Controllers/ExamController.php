<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Validator, Input, Redirect, Session, File;

use Auth;
use Illuminate\Support\Facades\DB;

use App\Subject;
use App\Exam;
use App\Examsubject;
use App\User;
use App\Role;
use App\Subjectallocation;
use App\Student;

class ExamController extends Controller
{
    public function __construct(){
        $this->middleware('role:headmaster', ['except' => ['getSubmissionPage']]);
        //$this->middleware('permission:theSpecificPermission', ['only' => ['create', 'store', 'edit', 'delete']]);
    }

    public function index()
    {
        $subjects = Subject::all();
        $exams = Exam::where('school_id', Auth::user()->school_id)
                     ->orderBy('id', 'desc')
                     ->get();
        $currentexam = Exam::where('currentexam', 1)->first();
        return view('exams.index')
                    ->withExams($exams)
                    ->withSubjects($subjects)
                    ->withCurrentexam($currentexam);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $subjects = Subject::all();
        return view('exams.create')->withSubjects($subjects);
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
            'exam_session'    => 'required',
            'exam_start_date' => 'required',
            'exam_start_date' => 'required',
            'exam_end_date'   => 'required',
        ]);

        $exam = Exam::where('school_id', Auth::user()->school_id)
                    ->where('name', $request->name)
                    ->where('exam_session', $request->exam_session)
                    ->first();
        if($exam != null) {
            Session::flash('warning', 'এই পরীক্ষাটি ইতোমধ্যে তৈরি করা আছে!');
            return redirect()->route('exams.create');
        } else {
            $exam = new Exam;
        }

        $exam->school_id = Auth::user()->school_id;
        $exam->name = $request->name;
        $exam->exam_code = random_string(5);
        $exam->exam_session = $request->exam_session;
        $exam->exam_start_date  = \Carbon\Carbon::parse($request->exam_start_date);
        $exam->exam_end_date  = \Carbon\Carbon::parse($request->exam_end_date);

        // deals with the total subjects
        $total_subjects_array = [];
        $classes = explode(',', Auth::user()->school->classes);
        foreach ($classes as $class) {
            $request_name = 'total_subjects_'.$class;
            if ($request->has($request_name)) {
                array_push($total_subjects_array, $class.':'.$request[$request_name]);
            }
        }
        $total_subjects = implode(',', $total_subjects_array);
        $exam->total_subjects = $total_subjects;
        // deals with the total subjects

        // save the exam data and get the id;
        $exam->save();

        // subject data insertion process starts here...
        $subjects = Subject::all();

        //dd($exam->id);
        foreach ($classes as $class) {
            foreach ($subjects as $subject) {
                // find the requested subject id
                if ($request->has('subject_id_'.$class.'_'.$subject->id)) {
                    //dd($request['subject_id_'.$class.'_'.$subject->id]);
                    $examsubject = new Examsubject;
                    $examsubject->exam_id = $exam->id;
                    $examsubject->class = $class;
                    $examsubject->subject_id = $request['subject_id_'.$class.'_'.$subject->id];

                    // if the value is present and is not empty it will be inserted
                    if ($request->has('written_'.$class.'_'.$subject->id)) {
                        $examsubject->written = $request['written_'.$class.'_'.$subject->id];
                    }
                    if ($request->has('written_pass_mark_'.$class.'_'.$subject->id)) {
                        $examsubject->written_pass_mark = $request['written_pass_mark_'.$class.'_'.$subject->id];
                    }
                    if ($request->has('mcq_'.$class.'_'.$subject->id)) {
                        $examsubject->mcq = $request['mcq_'.$class.'_'.$subject->id];
                    }
                    if ($request->has('mcq_pass_mark_'.$class.'_'.$subject->id)) {
                        $examsubject->mcq_pass_mark = $request['mcq_pass_mark_'.$class.'_'.$subject->id];
                    }
                    if ($request->has('practical_'.$class.'_'.$subject->id)) {
                        $examsubject->practical = $request['practical_'.$class.'_'.$subject->id];
                    }
                    if ($request->has('practical_pass_mark_'.$class.'_'.$subject->id)) {
                        $examsubject->practical_pass_mark = $request['practical_pass_mark_'.$class.'_'.$subject->id];
                    }
                    if ($request->has('total_percentage_'.$class.'_'.$subject->id)) {
                        $examsubject->total_percentage = $request['total_percentage_'.$class.'_'.$subject->id];
                    }
                    if ($request->has('ca_'.$class.'_'.$subject->id)) {
                        $examsubject->ca = $request['ca_'.$class.'_'.$subject->id];
                    }
                    if ($request->has('total_'.$class.'_'.$subject->id)) {
                        $examsubject->total = $request['total_'.$class.'_'.$subject->id];
                    }
                    if ($request->has('pass_mark_'.$class.'_'.$subject->id)) {
                        $examsubject->pass_mark = $request['pass_mark_'.$class.'_'.$subject->id];
                    }
                    $examsubject->save();
                }
            }
        }

        Session::flash('success', 'পরীক্ষাটি সংযুক্ত করা হয়েছে!');
        return redirect()->route('exams.index');

        
    }

    public function makeCurrent(Request $request, $id)
    {
        $oldExam = Exam::where('currentexam', 1)->first();
        if(($oldExam != null) && ($oldExam->count() > 0)) {
            $oldExam->currentexam = 0;
            $oldExam->save();
        }
        $exam = Exam::find($id);
        $exam->currentexam = 1;
        $exam->save();

        // update all teachers current exam
        $users = DB::table('users')->where('school_id', Auth::user()->school_id)->update(array('exam_id' => $id));

        Session::flash('success', 'পরীক্ষাটিকে চলতি পরীক্ষা হিসাবে নির্ধারণ করা হয়েছে!');
        return redirect()->route('exams.index');
    }

    public function getSubjectallocation()
    {
        $superadmins = User::whereHas('roles', function($query) {
                            $query->where('name', '=', 'superadmin');
                          })
                        ->where('school_id', Auth::user()->school_id)
                        ->get();
        $teachers = User::whereHas('roles', function($query) {
                            $query->where('name', '=', 'teacher');
                          })
                        ->where('school_id', Auth::user()->school_id)
                        ->orderBy('id', 'asc')
                        ->get();

        foreach ($superadmins as $superadmin) {
            $remove_id = $superadmin->id;
            $teachers = $teachers->reject(function ($value, $key) use($remove_id) {
                return $value->id == $remove_id;
            });
        }

        return view('exams.subjectallocation')->withTeachers($teachers);
    }

    public function storeSubjectallocation( Request $request)
    {
        $this->validate($request, [
            'user_id'    => 'required',
            'school_id'  => 'required',
            'exam_id'    => 'required',
            'subjects'   => 'required'
        ]);

        $oldallocations = Subjectallocation::where('user_id', $request->user_id)
                                           ->where('school_id', $request->school_id)
                                           ->get();
        if($oldallocations->count() > 0) {
            foreach ($oldallocations as $oldallocation) {
                DB::table('subjectallocations')
                        ->where('user_id', $oldallocation->user_id)
                        ->where('school_id', $oldallocation->school_id)
                        ->delete();
            }
        }
        foreach ($request->subjects as $subject) {
            $allocation = new Subjectallocation;
            $allocation->user_id = $request->user_id;
            $allocation->school_id = $request->school_id;
            $allocation->exam_id = $request->exam_id;

            $subject_data = explode(':', $subject);

            $allocation->subject_id = $subject_data[0];
            $allocation->class = $subject_data[1];
            if(count($subject_data) > 2) {
                $allocation->section = $subject_data[2];
            } else {
                $allocation->section = 0;
            }
            $allocation->save();
        }
        Session::flash('success', 'বিষয় বণ্টন সফলভাবে সম্পন্ন হয়েছে!');
        return redirect()->route('exam.getsubjectallocation');
    }

    public function getSubmissionPage(Request $request)
    {
        $this->validate($request, [
            'user_id'      => 'required',
            'school_id'    => 'required',
            'exam_id'      => 'required',
            'subject_id'   => 'required',
            'class'        => 'required',
            'section'      => 'required'
        ]);


        $students = Student::where('school_id', $request->school_id)
                           ->where('class', $request->class)
                           ->where('section', $request->section)
                           ->where('session', Auth::user()->exam->exam_session)
                           ->get();
        $examsubject = Examsubject::where('exam_id', $request->exam_id)
                                  ->where('subject_id', $request->subject_id)
                                  ->where('subject_id', $request->subject_id)
                                  ->where('class', $request->class)
                                  ->first();
        return view('exams.marksubmissionpage')
                        ->withStudents($students)
                        ->withExamsubject($examsubject)
                        ->withSubjectdata($request);
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
}
