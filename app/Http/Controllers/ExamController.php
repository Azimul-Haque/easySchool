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

class ExamController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $subjects = Subject::all();
        return view('exams.index')->withSubjects($subjects);
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
            return redirect()->route('exams.index');
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



        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
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
