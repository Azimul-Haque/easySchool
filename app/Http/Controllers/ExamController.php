<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Validator, Input, Redirect, Session, File;

use Auth;
use Illuminate\Support\Facades\DB;

use App\School;
use App\Subject;
use App\Exam;
use App\Examsubject;
use App\User;
use App\Role;
use App\Subjectallocation;
use App\Student;
use App\Mark;

use PDF;
use Excel;

class ExamController extends Controller
{
    public function __construct() {
        $this->middleware('role:headmaster', ['except' => ['getSubmissionPage', 'storeMakrs', 'pdfMarksforTeacher', 'getSingleMarkSheetPdf']]);
        //$this->middleware('permission:theSpecificPermission', ['only' => ['create', 'store', 'edit', 'delete']]);
    }

    public function index()
    {
        $subjects = Subject::all();
        $exams = Exam::where('school_id', Auth::user()->school_id)
                     ->orderBy('id', 'desc')
                     ->get();
        $currentexam = Exam::where('currentexam', 1)
                           ->where('school_id', Auth::user()->school_id)
                           ->first();
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
        $oldExam = Exam::where('school_id', Auth::user()->school_id)
                       ->where('currentexam', 1)
                       ->first();
        if(($oldExam != null) && ($oldExam->count() > 0)) {
            $oldExam->currentexam = 0;
            $oldExam->save();
        }
        $exam = Exam::find($id);
        $exam->currentexam = 1;
        $exam->save();

        // update all teachers current exam
        $users = DB::table('users')->where('school_id', Auth::user()->school_id)->update(array('exam_id' => $id));

        // update school table
        Auth::user()->school->currentexam = $exam->id;
        Auth::user()->school->save();

        Session::flash('success', 'পরীক্ষাটিকে চলতি পরীক্ষা হিসাবে নির্ধারণ করা হয়েছে!');
        return redirect()->route('exams.index');
    }

    // public function removeCurrent(Request $request, $id)
    // {
    //     $oldExam = Exam::where('school_id', Auth::user()->school_id)
    //                    ->where('currentexam', 1)
    //                    ->first();
    //     if(($oldExam != null) && ($oldExam->count() > 0)) {
    //         $oldExam->currentexam = 0;
    //         $oldExam->save();
    //     }

    //     // update all teachers current exam
    //     $users = DB::table('users')->where('school_id', Auth::user()->school_id)->update(array('exam_id' => $id));

    //     Session::flash('success', 'পরীক্ষাটিকে চলতি পরীক্ষা হিসাবে নির্ধারণ করা হয়েছে!');
    //     return redirect()->route('exams.index');
    // }

    public function getSubjectallocation()
    {
        // $allteachers = User::where('school_id', Auth::user()->school_id)->get();

        // $superadmins = $allteachers;
        // foreach ($allteachers as $allteacher) {
        //     $remove_id = $allteacher->id;

        //     // if(in_array('superadmin', $allteacher->roles()['name'])) {

        //     // } else {
        //     //     $superadmins = $superadmins->reject(function ($value, $key) use($remove_id) {
        //     //         return $value->id == $remove_id;
        //     //     });
        //     // }
        //     dd($allteacher->roles());
        // }

        // dd($superadmins);
        
        $superadmins = User::where('school_id', Auth::user()->school_id)
                        ->whereHas('roles', function($query) {
                            $query->where('name', '=', 'superadmin');
                          })
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

        if(Auth::user()->exam != null) {
            return view('exams.subjectallocation')->withTeachers($teachers);
        } else {
            return redirect()->route('exams.index')->with('success', 'কোন পরীক্ষা সংযোজন করা হয়নি; অথবা সংযোজিত পরীক্ষা থেকে চলতি পরীক্ষা নির্ধারণ করা হয়নি!');
        }
        
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

    public function getSubmissionPage($user_id, $school_id, $exam_id, $subject_id, $class, $section)
    {
        $request = new Request;
        $request->user_id = $user_id;
        $request->school_id = $school_id;
        $request->exam_id = $exam_id;
        $request->subject_id = $subject_id;
        $request->class = $class;
        $request->section = $section;

        $students = Student::where('school_id', $school_id)
                           ->where('class', $class)
                           ->where('section', $section)
                           ->where('session', Auth::user()->exam->exam_session)
                           ->orderBy('roll', 'asc')
                           ->get();
        $examsubject = Examsubject::where('exam_id', $exam_id)
                                  ->where('subject_id', $subject_id)
                                  ->where('class', $class)
                                  ->first();

        $allocated = Subjectallocation::where('user_id', $user_id)
                                      ->where('school_id', $school_id)
                                      ->where('exam_id', $exam_id)
                                      ->where('subject_id', $subject_id)
                                      ->where('class', $class)
                                      ->where('section', $section)
                                      ->first();

        $marks = Mark::where('school_id', $school_id)
                     ->where('exam_id', $exam_id)
                     ->where('subject_id', $subject_id)
                     ->where('class', $class)
                     ->where('section', $section)
                     ->get();
        // bangla 1st, 2nd and english 1st, 2nd | now go to storeMakrs method
        $otherpaper_id = null;
        if($subject_id == 1) {
            $otherpaper_id = 2;
        } elseif ($subject_id == 2) {
            $otherpaper_id = 1;
        }  elseif ($subject_id == 3) {
            $otherpaper_id = 4;
        }  elseif ($subject_id == 4) {
            $otherpaper_id = 3;
        }

        $otherpaper_marks = null;
        $othersubject = null;
        if($otherpaper_id != null) {
            $othersubject = Examsubject::where('exam_id', $exam_id)
                                      ->where('subject_id', $otherpaper_id)
                                      ->where('class', $class)
                                      ->first();
            $otherpaper_marks = Mark::where('school_id', $school_id)
                                    ->where('exam_id', $exam_id)
                                    ->where('subject_id', $otherpaper_id)
                                    ->where('class', $class)
                                    ->where('section', $section)
                                    ->get();
        }
        if(($allocated != null) && ($user_id == Auth::user()->id) && ($examsubject->count() > 0)) {
            return view('exams.marksubmissionpage')
                            ->withStudents($students)
                            ->withExamsubject($examsubject)
                            ->withSubjectdata($request)
                            ->withMarks($marks)
                            ->withOthersubject($othersubject)
                            ->withOtherpapermarks($otherpaper_marks);
        } elseif ((Auth::user()->hasRole('headmaster')) && ($school_id == Auth::user()->school_id) && ($examsubject != null && $examsubject->count() > 0)) {
            return view('exams.marksubmissionpage')
                            ->withStudents($students)
                            ->withExamsubject($examsubject)
                            ->withSubjectdata($request)
                            ->withMarks($marks)
                            ->withOthersubject($othersubject)
                            ->withOtherpapermarks($otherpaper_marks);
        } else {
            Session::flash('warning', 'আপনি ভুল পাতায় যাবার চেষ্টা করেছিলেন!');
            return redirect()->route('dashboard');
        }

    }

    public function storeMakrs(Request $request)
    {
        $this->validate($request, [
            'school_id'     => 'required',
            'exam_id'       => 'required',
            'subject_id'    => 'required',
            'class'         => 'required',
            'section'       => 'required'
        ]);

        $students = Student::where('school_id', $request->school_id)
                           ->where('class', $request->class)
                           ->where('section', $request->section)
                           ->where('session', Auth::user()->exam->exam_session)
                           ->get();

        $examsubject = Examsubject::where('exam_id', $request->exam_id)
                                  ->where('subject_id', $request->subject_id)
                                  ->where('class', $request->class)
                                  ->first();

        // bangla 1st, 2nd and english 1st, 2nd | now go to getSubmissionPage method
        $otherpaper_id = null;

        if($request->subject_id == 1) {
            $otherpaper_id = 2;
        } elseif ($request->subject_id == 2) {
            $otherpaper_id = 1;
        }  elseif ($request->subject_id == 3) {
            $otherpaper_id = 4;
        }  elseif ($request->subject_id == 4) {
            $otherpaper_id = 3;
        }

        $othersubject = null;
        if($otherpaper_id != null) {
            $othersubject = Examsubject::where('exam_id', $request->exam_id)
                                       ->where('subject_id', $otherpaper_id)
                                       ->where('class', $request->class)
                                       ->first();
        }

        foreach ($students as $student) {
            $student_marks = Mark::where('school_id', $request->school_id)
                                 ->where('exam_id', $request->exam_id)
                                 ->where('subject_id', $request->subject_id)
                                 ->where('student_id', $student->student_id)
                                 ->where('class', $request->class)
                                 ->where('section', $request->section)
                                 ->where('roll', $student->roll)
                                 ->first();

            $otherpaper_marks = Mark::where('school_id', $request->school_id)
                                 ->where('exam_id', $request->exam_id)
                                 ->where('subject_id', $otherpaper_id)
                                 ->where('student_id', $student->student_id)
                                 ->where('class', $request->class)
                                 ->where('section', $request->section)
                                 ->where('roll', $student->roll)
                                 ->first();
            if($otherpaper_marks != null) {
                $otherpaper_written = $otherpaper_marks->written;
                $otherpaper_mcq = $otherpaper_marks->mcq;
                $otherpaper_practical = $otherpaper_marks->practical;
                $otherpaper_ca = $otherpaper_marks->ca;
            } else {
                $otherpaper_written = 0;
                $otherpaper_mcq = 0;
                $otherpaper_practical = 0;
                $otherpaper_ca = 0;
            }

            if($student_marks != null) {
                $student_marks->roll = $request['roll'.$student->student_id];
                $student_marks->written = $request['written'.$student->student_id] ?: 0;
                $student_marks->mcq = $request['mcq'.$student->student_id] ?: 0;
                $student_marks->practical = $request['practical'.$student->student_id] ?: 0;
                $student_marks->ca = $request['ca'.$student->student_id] ?: 0;

                if($otherpaper_id != null) {
                    $student_marks->total_percentage = round(($student_marks->written+$student_marks->mcq+$student_marks->practical + $otherpaper_written + $otherpaper_mcq + $otherpaper_practical)*(($examsubject->total_percentage ?: 100)/100));
                    $student_marks->total = $student_marks->total_percentage + $student_marks->ca + $otherpaper_ca;
                    $mark_avg_single = (($student_marks->written+$student_marks->mcq+$student_marks->practical + $student_marks->ca)/($examsubject->total)) * 100; // jodi laage paper wise pass er jonno
                    $mark_avg = ($student_marks->total/($examsubject->total + $othersubject->total)) * 100;

                    // correction October, 2019

                    if(($student_marks->written < $examsubject->written_pass_mark || $student_marks->mcq < $examsubject->mcq_pass_mark || $student_marks->practical < $examsubject->practical_pass_mark || $otherpaper_written < $othersubject->written_pass_mark || $otherpaper_mcq < $othersubject->mcq_pass_mark || $otherpaper_practical < $othersubject->practical_pass_mark) && $mark_avg < 33) {
                        $student_marks->grade_point = 0.00;
                        $student_marks->grade = 'F';
                    } else {
                        $student_marks->grade_point = grade_point($mark_avg);
                        $student_marks->grade = grade($mark_avg);
                    }

                    
                } else {
                    $student_marks->total_percentage = round(($student_marks->written+$student_marks->mcq+$student_marks->practical)*(($examsubject->total_percentage ?: 100)/100));
                    $student_marks->total = $student_marks->total_percentage + $student_marks->ca;
                    $mark_avg = ($student_marks->total / $examsubject->total) * 100;
                    
                    // correction October, 2019
                    if($student_marks->written < $examsubject->written_pass_mark || $student_marks->mcq < $examsubject->mcq_pass_mark || $student_marks->practical < $examsubject->practical_pass_mark) {
                        $student_marks->grade_point = 0.00;
                        $student_marks->grade = 'F';
                    } else {
                        $student_marks->grade_point = grade_point($mark_avg);
                        $student_marks->grade = grade($mark_avg);
                    }
                }

                $student_marks->save();
                if($otherpaper_marks != null) {
                    $otherpaper_marks->total_percentage = $student_marks->total_percentage;
                    $otherpaper_marks->total = $student_marks->total;
                    $otherpaper_marks->grade_point = $student_marks->grade_point;
                    $otherpaper_marks->grade = $student_marks->grade;
                    $otherpaper_marks->save();
                }
            } else {
                $new_student_marks = new Mark;
                $new_student_marks->school_id = $request->school_id;
                $new_student_marks->exam_id = $request->exam_id;
                $new_student_marks->subject_id = $request->subject_id;
                $new_student_marks->class = $request->class;
                $new_student_marks->section = $request->section;
                $new_student_marks->student_id = $request['student_id'.$student->student_id];
                $new_student_marks->roll = $request['roll'.$student->student_id];
                $new_student_marks->written = $request['written'.$student->student_id] ?: 0;
                $new_student_marks->mcq = $request['mcq'.$student->student_id] ?: 0;
                $new_student_marks->practical = $request['practical'.$student->student_id] ?: 0;
                $new_student_marks->ca = $request['ca'.$student->student_id] ?: 0;
                if($otherpaper_id != null) {
                    $new_student_marks->total_percentage = round(($new_student_marks->written+$new_student_marks->mcq+$new_student_marks->practical + $otherpaper_written + $otherpaper_mcq + $otherpaper_practical)*(($examsubject->total_percentage ?: 100)/100));
                    $new_student_marks->total = $new_student_marks->total_percentage + $new_student_marks->ca + $otherpaper_ca;
                    $mark_avg_single = (($new_student_marks->written + $new_student_marks->mcq + $new_student_marks->practical + $new_student_marks->ca)/($examsubject->total)) * 100; // jodi laage paper wise pass er jonno
                    $mark_avg = ($new_student_marks->total/($examsubject->total + $othersubject->total)) * 100; 

                    // correction October, 2019
                    if(($new_student_marks->written < $examsubject->written_pass_mark || $new_student_marks->mcq < $examsubject->mcq_pass_mark || $new_student_marks->practical < $examsubject->practical_pass_mark || $otherpaper_written < $othersubject->written_pass_mark || $otherpaper_mcq < $othersubject->mcq_pass_mark || $otherpaper_practical < $othersubject->practical_pass_mark) && $mark_avg < 33) {
                        $new_student_marks->grade_point = 0.00;
                        $new_student_marks->grade = 'F';
                    } else {
                        $new_student_marks->grade_point = grade_point($mark_avg);
                        $new_student_marks->grade = grade($mark_avg);
                    }
                } else {
                    $new_student_marks->total_percentage = round(($new_student_marks->written+$new_student_marks->mcq+$new_student_marks->practical)*(($examsubject->total_percentage ?: 100)/100));
                    $new_student_marks->total = $new_student_marks->total_percentage + $new_student_marks->ca;
                    $mark_avg = ($new_student_marks->total / $examsubject->total) * 100;

                    // correction October, 2019
                    if($new_student_marks->written < $examsubject->written_pass_mark || $new_student_marks->mcq < $examsubject->mcq_pass_mark || $new_student_marks->practical < $examsubject->practical_pass_mark) {
                        $new_student_marks->grade_point = 0.00;
                        $new_student_marks->grade = 'F';
                    } else {
                        $new_student_marks->grade_point = grade_point($mark_avg);
                        $new_student_marks->grade = grade($mark_avg);
                    }
                }
                $new_student_marks->save();

                if($otherpaper_marks != null) {
                    $otherpaper_marks->total_percentage = $new_student_marks->total_percentage;
                    $otherpaper_marks->total = $new_student_marks->total;
                    $otherpaper_marks->grade_point = $new_student_marks->grade_point;
                    $otherpaper_marks->grade = $new_student_marks->grade;
                    $otherpaper_marks->save();
                }
            }
        }

        Session::flash('success', 'মার্ক সফলভাবে দাখিল করা হয়েছে!');
        return back();
    }

    public function pdfMarksforTeacher($school_id, $exam_id, $subject_id, $class, $section)
    {
        $exam = Exam::where('id', $exam_id)->first();

        $marks = Mark::where('school_id', $school_id)
                     ->where('exam_id', $exam_id)
                     ->where('subject_id', $subject_id)
                     ->where('class', $class)
                     ->where('section', $section)
                     ->orderBy('roll', 'asc')
                     ->get();
        $attended = Mark::where('school_id', $school_id)
                     ->where('exam_id', $exam_id)
                     ->where('subject_id', $subject_id)
                     ->where('class', $class)
                     ->where('section', $section)
                     ->where('total', '>', 0)
                     ->count();
        $passed = Mark::where('school_id', $school_id)
                     ->where('exam_id', $exam_id)
                     ->where('subject_id', $subject_id)
                     ->where('class', $class)
                     ->where('section', $section)
                     ->where('grade', '!=', 'F')
                     ->where('grade', '!=', 'N/A')
                     ->count();

        $pdf = PDF::loadView('exams.pdf.marksforteacher', ['marks' => $marks], ['data' => [$class, $section, $attended, $passed, $exam->name, $exam->exam_session]]);
        $fileName = 'Class_'.$class.'_'.$section.'_Mark_List' . '.pdf';
        return $pdf->stream($fileName);
    }

    public function allClassMarkSubmissionPage()
    {
        if(Auth::user()->exam != null) {
            return view('exams.allclassmarksubmissionpage');
        } else {
            return redirect()->route('exams.index')->with('success', 'কোন পরীক্ষা সংযোজন করা হয়নি; অথবা সংযোজিত পরীক্ষা থেকে চলতি পরীক্ষা নির্ধারণ করা হয়নি!');
        }
        
    }

    public function getResultGenPage()
    {
        $exams = Exam::where('school_id', Auth::user()->school_id)
                     ->orderBy('currentexam', 'desc')
                     ->get();
        if(Auth::user()->exam != null) {
            return view('exams.resultgeneration')->withExams($exams);
        } else {
            return redirect()->route('exams.index')->with('success', 'কোন পরীক্ষা সংযোজন করা হয়নি; অথবা সংযোজিত পরীক্ষা থেকে চলতি পরীক্ষা নির্ধারণ করা হয়নি!');
        }
    }

    public function getResultListPDF(Request $request)
    {
        $this->validate($request, [
            'exam_id'         => 'required',
            'class_section'   => 'required',
            'subject_count'   => 'required'
        ]);

        $exam = Exam::where('id', $request->exam_id)->first();

        $class_section_array = explode('_', $request->class_section);
        $class   = $class_section_array[0];
        $section = $class_section_array[1];
        
        $marks = Mark::where('exam_id', $request->exam_id)
                     ->where('class', $class)
                     ->where('section', $section)
                     ->get();
        $students = Student::where('school_id', Auth::user()->school_id)
                           ->where('session', $exam->exam_session)
                           ->where('class', $class)
                           ->where('section', $section)
                           ->orderBy('roll', 'asc')
                           ->get();
        $examsubjects = Examsubject::where('exam_id', $request->exam_id)
                                  ->where('class', $class)
                                  ->get();

        // skip if ban 2 or en 2, because numbers are counted in ban 1 and en 1
        $ban_en_array = [2, 4];
        foreach ($students as $student) {
            $total_marks = 0;
            $total_grade_point = 0;
            $sorting_sub_math = 0;
            $sorting_sub_en = 0;
            $sorting_sub_ban = 0;
            $grade_array = [];
            foreach ($marks as $mark) {
                if($student->student_id == $mark->student_id) {
                    
                    // for class 9 and 10, consider higher math and agriculture
                    // for class 9 and 10, consider higher math and agriculture
                    if($class > 8) {
                        // adhoc somadhan, jehetu bojhar upay nai j student higher naki
                        if(($mark->subject_id == 15 && $mark->total == 0) || ($mark->subject_id == 19 && $mark->total == 0)) { // agriculture
                            // do nothing
                        } else {
                            if(in_array($mark->subject_id, $ban_en_array)) {
                                continue;
                            } else {
                                $total_marks = $total_marks + $mark->total;
                                if($mark->grade_point != 'N/A') {
                                    $total_grade_point = $total_grade_point + $mark->grade_point;
                                } else {
                                    $total_grade_point = $total_grade_point * 0;
                                }
                            }
                            if($mark->subject_id == 1) {
                                $sorting_sub_ban = $mark->total; // bangla
                            } elseif($mark->subject_id == 3) {
                                $sorting_sub_en = $mark->total; // english
                            } elseif($mark->subject_id == 3) {
                                $sorting_sub_math = $mark->total; // math
                            }
                            // grade array...
                            $grade_array[] = $mark->grade;
                        }
                        // adhoc somadhan, jehetu bojhar upay nai j student higher naki
                    } else {
                        if(in_array($mark->subject_id, $ban_en_array)) {
                            continue;
                        } else {
                            $total_marks = $total_marks + $mark->total;
                            if($mark->grade_point != 'N/A') {
                                $total_grade_point = $total_grade_point + $mark->grade_point;
                            } else {
                                $total_grade_point = $total_grade_point * 0;
                            }
                        }
                        if($mark->subject_id == 1) {
                            $sorting_sub_ban = $mark->total; // bangla
                        } elseif($mark->subject_id == 3) {
                            $sorting_sub_en = $mark->total; // english
                        } elseif($mark->subject_id == 3) {
                            $sorting_sub_math = $mark->total; // math
                        }
                        // grade array...
                        $grade_array[] = $mark->grade;
                    }
                }
            }
            if(in_array('F', $grade_array) || in_array('N/A', $grade_array)) {
                $total_grade_point = 0;
            }
            $gpa = $total_grade_point/$request->subject_count;
            if($gpa > 5.00) {
                $gpa = 5.00;
            }
            $gpa = number_format($gpa, 2);
            $grade = avg_grade($gpa);
            if(($grade == 'F') || ($grade == 'N/A')) {
                $gpa = number_format(0, 2);
            }
            $result_sub['gpa'] = (float)$gpa;
            $result_sub['total_marks'] = (int)$total_marks;
            $result_sub['sorting_sub_math'] = (int)$sorting_sub_math;
            $result_sub['sorting_sub_en'] = (int)$sorting_sub_en;
            $result_sub['sorting_sub_ban'] = (int)$sorting_sub_ban;
            $result_sub['roll'] = (int)$student->roll;
            $result_sub['student_id'] = $student->student_id;
            $result_sub['grade'] = $grade;
            $result_sub['f_count'] = count(array_keys($grade_array, 'F'));

            $result_sub['school_id'] = Auth::user()->school_id;
            $result_sub['exam_id'] = $request->exam_id;
            $result_sub['class'] = $class;
            $result_sub['section'] = $section;
            $result_sub['name'] = $student->name;
            
           
            $results[$student->student_id] = $result_sub;
        }
        
        //rsort($results);
        foreach ($results as $key => $row)
        {
            $result_array_gpa[$key] = $row['gpa'];
            $result_array_total_marks[$key] = $row['total_marks'];
            $result_array_sorting_sub_math[$key] = $row['sorting_sub_math'];
            $result_array_sorting_sub_en[$key] = $row['sorting_sub_en'];
            $result_array_sorting_sub_ban[$key] = $row['sorting_sub_ban'];
            $result_array_roll[$key] = $row['roll'];
        }
        array_multisort($result_array_gpa, SORT_DESC, $result_array_total_marks, SORT_DESC, $result_array_sorting_sub_math, SORT_DESC, $result_array_sorting_sub_en, SORT_DESC, $result_array_sorting_sub_ban, SORT_DESC, $result_array_roll, SORT_ASC, $results);
        $results_coll = collect($results);
        // dd($results_coll);

        $pdf = PDF::loadView('exams.pdf.resultlist', ['results' => $results_coll], ['data' => [$exam->name, $exam->exam_session, $class, $section]]);
        $fileName = 'Class_'.$class.'_'.english_section(Auth::user()->school->section_type, $class, $section).'_Result_List' . '.pdf';
        return $pdf->stream($fileName);
        
    }

    public function getTabulationSheetPDF(Request $request)
    {
        $this->validate($request, [
            'exam_id'         => 'required',
            'class_section'   => 'required',
            'subject_count'   => 'required'
        ]);

        $exam = Exam::where('id', $request->exam_id)->first();

        $class_section_array = explode('_', $request->class_section);
        $class   = $class_section_array[0];
        $section = $class_section_array[1];
        
        $marks = Mark::where('exam_id', $request->exam_id)
                     ->where('class', $class)
                     ->where('section', $section)
                     ->get();
        // filter the subject number for science/arts/commerce
        if($class > 8) {
          if($section == 1) {
            $sub_remove_array = [8, 22, 23, 24, 27, 28, 29]; // science
          } elseif ($section == 2) {
            $sub_remove_array = [9, 16, 17, 18, 19, 27, 28, 29]; // arts
          }elseif ($section == 3) {
            $sub_remove_array = [16, 17, 18, 22, 23, 24]; // commerce
          } else {
            $sub_remove_array = []; // other than 9/10
          }
          foreach($sub_remove_array as $sub_id) {
            foreach($marks as $key => $value) {
              if($value->subject_id == $sub_id) {
                $marks->forget($key);
              }
            }
          }
        }
        // filter the subject number for science/arts/commerce

        $students = Student::where('school_id', Auth::user()->school_id)
                           ->where('session', $exam->exam_session)
                           ->where('class', $class)
                           ->where('section', $section)
                           ->orderBy('roll', 'ASC')
                           ->get();
        $examsubjects = Examsubject::where('exam_id', $request->exam_id)
                                  ->where('class', $class)
                                  ->orderBy('subject_id', 'asc')
                                  ->get();

        // skip if ban 2 or en 2, because numbers are already counted in ban 1 and en 1
        $ban_en_array = [2, 4];
        foreach ($students as $student) {
            $total_marks = 0;
            $total_grade_point = 0;
            $sorting_sub_math = 0;
            $sorting_sub_en = 0;
            $sorting_sub_ban = 0;
            $subjects_marks = [];
            $grade_array = [];
            foreach ($marks as $mark) {
                if($student->student_id == $mark->student_id) {
                    $subject_mark['student_id'] = $mark->student_id;
                    $subject_mark['subject_id'] = $mark->subject_id;
                    $subject_mark['written'] = $mark->written;
                    $subject_mark['mcq'] = $mark->mcq;
                    $subject_mark['practical'] = $mark->practical;
                    $subject_mark['ca'] = $mark->ca;
                    $subject_mark['total'] = $mark->total;
                    $subject_mark['grade'] = $mark->grade;
                    $subjects_marks[] = $subject_mark;
                    // for class 9 and 10, consider higher math and agriculture
                    // for class 9 and 10, consider higher math and agriculture
                    if($class > 8) {
                        // adhoc somadhan, jehetu bojhar upay nai j student higher naki
                        if(($mark->subject_id == 15 && $mark->total == 0) || ($mark->subject_id == 19 && $mark->total == 0)) { // agriculture
                            // do nothing
                        } else {
                            $grade_array[] = $subject_mark['grade'];

                            if(in_array($mark->subject_id, $ban_en_array)) {
                                continue;
                            } else {
                                $total_marks = $total_marks + $mark->total;
                                if($mark->grade_point != 'N/A') {
                                    $total_grade_point = $total_grade_point + $mark->grade_point;
                                } else {
                                    $total_grade_point = $total_grade_point * 0;
                                }
                            }
                            if($mark->subject_id == 1) {
                                $sorting_sub_ban = $mark->total; // bangla
                            } elseif($mark->subject_id == 3) {
                                $sorting_sub_en = $mark->total; // english
                            } elseif($mark->subject_id == 3) {
                                $sorting_sub_math = $mark->total; // math
                            }
                        }
                        // adhoc somadhan, jehetu bojhar upay nai j student higher naki
                    } else {
                        $grade_array[] = $subject_mark['grade'];

                        if(in_array($mark->subject_id, $ban_en_array)) {
                            continue;
                        } else {
                            $total_marks = $total_marks + $mark->total;
                            if($mark->grade_point != 'N/A') {
                                $total_grade_point = $total_grade_point + $mark->grade_point;
                            } else {
                                $total_grade_point = $total_grade_point * 0;
                            }
                        }
                        if($mark->subject_id == 1) {
                            $sorting_sub_ban = $mark->total; // bangla
                        } elseif($mark->subject_id == 3) {
                            $sorting_sub_en = $mark->total; // english
                        } elseif($mark->subject_id == 3) {
                            $sorting_sub_math = $mark->total; // math
                        }
                    }
                }
            }

            if(in_array('F', $grade_array) || in_array('N/A', $grade_array)) {
                $total_grade_point = 0;
            }
            $gpa = $total_grade_point/$request->subject_count;
            if($gpa > 5.00) {
                $gpa = 5.00;
            }
            $gpa = number_format($gpa, 2);
            $grade = avg_grade($gpa);
            if(($grade == 'F') || ($grade == 'N/A')) {
                $gpa = number_format(0, 2);
            }
            $result_sub['gpa'] = (float)$gpa;
            $result_sub['total_marks'] = (int)$total_marks;
            $result_sub['sorting_sub_math'] = (int)$sorting_sub_math;
            $result_sub['sorting_sub_en'] = (int)$sorting_sub_en;
            $result_sub['sorting_sub_ban'] = (int)$sorting_sub_ban;
            $result_sub['roll'] = (int)$student->roll;
            $result_sub['student_id'] = $student->student_id;
            $result_sub['grade'] = $grade;
            $result_sub['subjects_marks'] = $subjects_marks;

            $result_sub['school_id'] = Auth::user()->school_id;
            $result_sub['exam_id'] = $request->exam_id;
            $result_sub['class'] = $class;
            $result_sub['section'] = $section;
            $result_sub['name'] = $student->name;
            
            $results[$student->student_id] = $result_sub;
        }
        
        //rsort($results);
        foreach ($results as $key => $row)
        {
            $result_array_gpa[$key] = $row['gpa'];
            $result_array_total_marks[$key] = $row['total_marks'];
            $result_array_sorting_sub_math[$key] = $row['sorting_sub_math'];
            $result_array_sorting_sub_en[$key] = $row['sorting_sub_en'];
            $result_array_sorting_sub_ban[$key] = $row['sorting_sub_ban'];
            $result_array_roll[$key] = $row['roll'];
        }
        array_multisort($result_array_roll, SORT_ASC, $results); // $result_array_gpa, SORT_DESC, $result_array_total_marks, SORT_DESC, $result_array_sorting_sub_math, SORT_DESC, $result_array_sorting_sub_en, SORT_DESC, $result_array_sorting_sub_ban, SORT_DESC, 
        $results_coll = collect($results);
        //dd($results_coll);

        $pdf = PDF::loadView('exams.pdf.tabulationsheet', ['results' => $results_coll], ['data' => [$exam, $class, $section, $examsubjects]], ['mode' => 'utf-8', 'format' => 'A4-L', 'margin_top' => 30]);
        $fileName = 'Class_'.$class.'_'.english_section(Auth::user()->school->section_type, $class, $section).'_Tabulation_Sheet' . '.pdf';
        return $pdf->stream($fileName);
    }

    public function getMarkSheetsPdf(Request $request)
    {
        $this->validate($request, [
            'exam_id'         => 'required',
            'class_section'   => 'required',
            'subject_count'   => 'required'
        ]);

        $exam = Exam::where('id', $request->exam_id)->first();

        $class_section_array = explode('_', $request->class_section);
        $class   = $class_section_array[0];
        $section = $class_section_array[1];
        
        $marks = Mark::where('exam_id', $request->exam_id)
                     ->where('class', $class)
                     ->where('section', $section)
                     ->get();
        $students = Student::where('school_id', Auth::user()->school_id)
                           ->where('session', $exam->exam_session)
                           ->where('class', $class)
                           ->where('section', $section)
                           ->orderBy('roll', 'ASC')
                           ->get();
        $examsubjects = Examsubject::where('exam_id', $request->exam_id)
                                  ->where('class', $class)
                                  ->orderBy('subject_id', 'asc')
                                  ->get();

        // skip if ban 2 or en 2, because numbers are counted in ban 1 and en 1
        $ban_en_array = [2, 4];
        foreach ($students as $student) {
            $total_marks = 0;
            $total_grade_point = 0;
            $sorting_sub_math = 0;
            $sorting_sub_en = 0;
            $sorting_sub_ban = 0;
            $subjects_marks = [];
            $grade_array = [];
            foreach ($marks as $mark) {
                if($student->student_id == $mark->student_id) {
                    $subject_mark['student_id'] = $mark->student_id;
                    $subject_mark['subject_id'] = $mark->subject_id;
                    $subject_mark['written'] = $mark->written;
                    $subject_mark['mcq'] = $mark->mcq;
                    $subject_mark['practical'] = $mark->practical;
                    $subject_mark['ca'] = $mark->ca;
                    $subject_mark['total_percentage'] = $mark->total_percentage;
                    $subject_mark['total'] = $mark->total;
                    $subject_mark['grade_point'] = $mark->grade_point;
                    $subject_mark['grade'] = $mark->grade;
                    $subjects_marks[] = $subject_mark;

                    // for class 9 and 10, consider higher math and agriculture
                    // for class 9 and 10, consider higher math and agriculture
                    if($class > 8) {
                        // adhoc somadhan, jehetu bojhar upay nai j student higher naki
                        if(($mark->subject_id == 15 && $mark->total == 0) || ($mark->subject_id == 19 && $mark->total == 0)) { // agriculture
                            // do nothing
                        } else {
                            $grade_array[] = $subject_mark['grade'];

                            if(in_array($mark->subject_id, $ban_en_array)) {
                                continue;
                            } else {
                                $total_marks = $total_marks + $mark->total;
                                if($mark->grade_point != 'N/A') {
                                    $total_grade_point = $total_grade_point + $mark->grade_point;
                                } else {
                                    $total_grade_point = $total_grade_point * 0;
                                }
                            }
                            if($mark->subject_id == 1) {
                                $sorting_sub_ban = $mark->total; // bangla
                            } elseif($mark->subject_id == 3) {
                                $sorting_sub_en = $mark->total; // english
                            } elseif($mark->subject_id == 3) {
                                $sorting_sub_math = $mark->total; // math
                            }
                        }
                        // adhoc somadhan, jehetu bojhar upay nai j student higher naki
                    } else {
                        $grade_array[] = $subject_mark['grade'];

                        if(in_array($mark->subject_id, $ban_en_array)) {
                            continue;
                        } else {
                            $total_marks = $total_marks + $mark->total;
                            if($mark->grade_point != 'N/A') {
                                $total_grade_point = $total_grade_point + $mark->grade_point;
                            } else {
                                $total_grade_point = $total_grade_point * 0;
                            }
                        }
                        if($mark->subject_id == 1) {
                            $sorting_sub_ban = $mark->total; // bangla
                        } elseif($mark->subject_id == 3) {
                            $sorting_sub_en = $mark->total; // english
                        } elseif($mark->subject_id == 3) {
                            $sorting_sub_math = $mark->total; // math
                        }
                    }
                    
                }
            }
            if(in_array('F', $grade_array) || in_array('N/A', $grade_array)) {
                $total_grade_point = 0;
            }
            $gpa = $total_grade_point/$request->subject_count;
            if($gpa > 5.00) {
                $gpa = 5.00;
            }
            $gpa = number_format($gpa, 2);
            $grade = avg_grade($gpa);
            if(($grade == 'F') || ($grade == 'N/A')) {
                $gpa = number_format(0, 2);
            }
            $result_sub['gpa'] = (float)$gpa;
            $result_sub['total_marks'] = (int)$total_marks;
            $result_sub['sorting_sub_math'] = (int)$sorting_sub_math;
            $result_sub['sorting_sub_en'] = (int)$sorting_sub_en;
            $result_sub['sorting_sub_ban'] = (int)$sorting_sub_ban;
            $result_sub['roll'] = (int)$student->roll;
            $result_sub['student_id'] = $student->student_id;
            $result_sub['grade'] = $grade;
            $result_sub['subjects_marks'] = $subjects_marks;

            $result_sub['school_id'] = Auth::user()->school_id;
            $result_sub['exam_id'] = $request->exam_id;
            $result_sub['class'] = $class;
            $result_sub['section'] = $section;
            $result_sub['name'] = $student->name;
            $result_sub['father'] = $student->father;
            $result_sub['mother'] = $student->mother;
            $result_sub['dob'] = $student->dob;
            
            $results[$student->student_id] = $result_sub;
        }
        
        //rsort($results);
        foreach ($results as $key => $row)
        {
            $result_array_gpa[$key] = $row['gpa'];
            $result_array_total_marks[$key] = $row['total_marks'];
            $result_array_sorting_sub_math[$key] = $row['sorting_sub_math'];
            $result_array_sorting_sub_en[$key] = $row['sorting_sub_en'];
            $result_array_sorting_sub_ban[$key] = $row['sorting_sub_ban'];
            $result_array_roll[$key] = $row['roll'];
        }
        array_multisort($result_array_gpa, SORT_DESC, $result_array_total_marks, SORT_DESC, $result_array_sorting_sub_math, SORT_DESC, $result_array_sorting_sub_en, SORT_DESC, $result_array_sorting_sub_ban, SORT_DESC, $result_array_roll, SORT_ASC, $results); // $result_array_gpa, SORT_DESC, $result_array_total_marks, SORT_DESC, $result_array_sorting_sub_math, SORT_DESC, $result_array_sorting_sub_en, SORT_DESC, $result_array_sorting_sub_ban, SORT_DESC, 
        $results_coll = collect($results);
        // dd($results_coll);

        // get the highest marks each subjects
        // get the highest marks each subjects
        $highest = [];
        foreach ($results as $result) {
            foreach ($result['subjects_marks'] as $marks) {
                $highest[$marks['subject_id']][] = $marks['total'];
                rsort($highest[$marks['subject_id']]);
            }
        }
        // dd($highest);
        // get the highest marks each subjects
        // get the highest marks each subjects
        ini_set("pcre.backtrack_limit", "5000000");
        $pdf = PDF::loadView('exams.pdf.marksheets', ['results' => $results_coll], ['data' => [$exam, $class, $section, $examsubjects, $highest]], ['mode' => 'utf-8', 'format' => 'A4']);
        $fileName = 'Class_'.$class.'_'.english_section(Auth::user()->school->section_type, $class, $section).'_Mark_Sheets' . '.pdf';
        return $pdf->stream($fileName);
    }

    public function getSingleMarkSheetPdf(Request $request)
    {
        $this->validate($request, [
            'school_id'         => 'required',
            'exam_id'           => 'required',
            'class_section'     => 'required',
            'student_id'        => 'required',
        ]);

        $school = School::findOrFail($request->school_id);

        $exam = Exam::where('id', $request->exam_id)->first();

        $class_section_array = explode('_', $request->class_section);
        $class   = $class_section_array[0];
        $section = $class_section_array[1];

        $class_subject_count = 0;
        $classaray = [];
        $total_subjects_array = explode(',', $exam->total_subjects);
        foreach($total_subjects_array as $classarray) {
            $classsubarr = explode(':', $classarray);
            if($classsubarr[0] == $class) {
                $class_subject_count = $classsubarr[1];
            }
            $classaray[] = $classsubarr[0];
        }
        // dd($classaray);

        $student = Student::where('student_id', $request->student_id)->first();
        if(empty($student) || $student == null) {
            Session::flash('info', 'তথ্য দিতে ভুল হচ্ছে! সঠিক তথ্য প্রদান করুন।');
            return redirect()->back();
        } elseif($student->class != $class || $student->section != $section || !in_array($student->class, $classaray)) {
            Session::flash('info', 'তথ্য দিতে ভুল হচ্ছে! সঠিক তথ্য প্রদান করুন।');
            return redirect()->back();
        }

        // dd($student);

        
        $marks = Mark::where('exam_id', $request->exam_id)
                     ->where('class', $class)
                     ->where('section', $section)
                     ->get();
        $students = Student::where('school_id', $school->id)
                           ->where('session', $exam->exam_session)
                           ->where('class', $class)
                           ->where('section', $section)
                           ->orderBy('roll', 'ASC')
                           ->get();
        $examsubjects = Examsubject::where('exam_id', $request->exam_id)
                                  ->where('class', $class)
                                  ->orderBy('subject_id', 'asc')
                                  ->get();

        // skip if ban 2 or en 2, because numbers are counted in ban 1 and en 1
        $ban_en_array = [2, 4];
        foreach ($students as $student) {
            $total_marks = 0;
            $total_grade_point = 0;
            $sorting_sub_math = 0;
            $sorting_sub_en = 0;
            $sorting_sub_ban = 0;
            $subjects_marks = [];
            $grade_array = [];
            foreach ($marks as $mark) {
                if($student->student_id == $mark->student_id) {
                    $subject_mark['student_id'] = $mark->student_id;
                    $subject_mark['subject_id'] = $mark->subject_id;
                    $subject_mark['written'] = $mark->written;
                    $subject_mark['mcq'] = $mark->mcq;
                    $subject_mark['practical'] = $mark->practical;
                    $subject_mark['ca'] = $mark->ca;
                    $subject_mark['total_percentage'] = $mark->total_percentage;
                    $subject_mark['total'] = $mark->total;
                    $subject_mark['grade_point'] = $mark->grade_point;
                    $subject_mark['grade'] = $mark->grade;
                    $subjects_marks[] = $subject_mark;

                    // for class 9 and 10, consider higher math and agriculture
                    // for class 9 and 10, consider higher math and agriculture
                    if($class > 8) {
                        // adhoc somadhan, jehetu bojhar upay nai j student higher naki
                        if(($mark->subject_id == 15 && $mark->total == 0) || ($mark->subject_id == 19 && $mark->total == 0)) { // agriculture
                            // do nothing
                        } else {
                            $grade_array[] = $subject_mark['grade'];

                            if(in_array($mark->subject_id, $ban_en_array)) {
                                continue;
                            } else {
                                $total_marks = $total_marks + $mark->total;
                                if($mark->grade_point != 'N/A') {
                                    $total_grade_point = $total_grade_point + $mark->grade_point;
                                } else {
                                    $total_grade_point = $total_grade_point * 0;
                                }
                            }
                            if($mark->subject_id == 1) {
                                $sorting_sub_ban = $mark->total; // bangla
                            } elseif($mark->subject_id == 3) {
                                $sorting_sub_en = $mark->total; // english
                            } elseif($mark->subject_id == 3) {
                                $sorting_sub_math = $mark->total; // math
                            }
                        }
                        // adhoc somadhan, jehetu bojhar upay nai j student higher naki
                    } else {
                        $grade_array[] = $subject_mark['grade'];

                        if(in_array($mark->subject_id, $ban_en_array)) {
                            continue;
                        } else {
                            $total_marks = $total_marks + $mark->total;
                            if($mark->grade_point != 'N/A') {
                                $total_grade_point = $total_grade_point + $mark->grade_point;
                            } else {
                                $total_grade_point = $total_grade_point * 0;
                            }
                        }
                        if($mark->subject_id == 1) {
                            $sorting_sub_ban = $mark->total; // bangla
                        } elseif($mark->subject_id == 3) {
                            $sorting_sub_en = $mark->total; // english
                        } elseif($mark->subject_id == 3) {
                            $sorting_sub_math = $mark->total; // math
                        }
                    }
                    
                }
            }
            if(in_array('F', $grade_array) || in_array('N/A', $grade_array)) {
                $total_grade_point = 0;
            }
            $gpa = $total_grade_point/$class_subject_count;
            if($gpa > 5.00) {
                $gpa = 5.00;
            }
            $gpa = number_format($gpa, 2);
            $grade = avg_grade($gpa);
            if(($grade == 'F') || ($grade == 'N/A')) {
                $gpa = number_format(0, 2);
            }
            $result_sub['gpa'] = (float)$gpa;
            $result_sub['total_marks'] = (int)$total_marks;
            $result_sub['sorting_sub_math'] = (int)$sorting_sub_math;
            $result_sub['sorting_sub_en'] = (int)$sorting_sub_en;
            $result_sub['sorting_sub_ban'] = (int)$sorting_sub_ban;
            $result_sub['roll'] = (int)$student->roll;
            $result_sub['student_id'] = $student->student_id;
            $result_sub['grade'] = $grade;
            $result_sub['subjects_marks'] = $subjects_marks;

            $result_sub['school_id'] = $school->id;
            $result_sub['exam_id'] = $request->exam_id;
            $result_sub['class'] = $class;
            $result_sub['section'] = $section;
            $result_sub['name'] = $student->name;
            $result_sub['father'] = $student->father;
            $result_sub['mother'] = $student->mother;
            $result_sub['dob'] = $student->dob;
            
            $results[$student->student_id] = $result_sub;
        }
        
        //rsort($results);
        foreach ($results as $key => $row)
        {
            $result_array_gpa[$key] = $row['gpa'];
            $result_array_total_marks[$key] = $row['total_marks'];
            $result_array_sorting_sub_math[$key] = $row['sorting_sub_math'];
            $result_array_sorting_sub_en[$key] = $row['sorting_sub_en'];
            $result_array_sorting_sub_ban[$key] = $row['sorting_sub_ban'];
            $result_array_roll[$key] = $row['roll'];
        }
        array_multisort($result_array_gpa, SORT_DESC, $result_array_total_marks, SORT_DESC, $result_array_sorting_sub_math, SORT_DESC, $result_array_sorting_sub_en, SORT_DESC, $result_array_sorting_sub_ban, SORT_DESC, $result_array_roll, SORT_ASC, $results); // $result_array_gpa, SORT_DESC, $result_array_total_marks, SORT_DESC, $result_array_sorting_sub_math, SORT_DESC, $result_array_sorting_sub_en, SORT_DESC, $result_array_sorting_sub_ban, SORT_DESC, 
        $results_coll = collect($results);
        // dd($results_coll);

        // get the highest marks each subjects
        // get the highest marks each subjects
        $highest = [];
        foreach ($results as $result) {
            foreach ($result['subjects_marks'] as $marks) {
                $highest[$marks['subject_id']][] = $marks['total'];
                rsort($highest[$marks['subject_id']]);
            }
        }
        // dd($highest);
        // get the highest marks each subjects
        // get the highest marks each subjects
        ini_set("pcre.backtrack_limit", "5000000");
        $pdf = PDF::loadView('exams.pdf.marksheet', ['results' => $results_coll], ['data' => [$exam, $class, $section, $examsubjects, $highest], 'school' => $school, 'student_id' => $request->student_id], ['mode' => 'utf-8', 'format' => 'A4']);
        $fileName = 'Class_'.$class.'_'.english_section($school->section_type, $class, $section).'_'. $student->student_id .'_Mark_Sheets' . '.pdf';
        return $pdf->stream($fileName);
    }

    public function getExcelForSMS(Request $request)
    {
        $this->validate($request, [
            'exam_id'         => 'required',
            'class_section'   => 'required',
            'subject_count'   => 'required'
        ]);

        $exam = Exam::where('id', $request->exam_id)->first();

        $class_section_array = explode('_', $request->class_section);
        $class   = $class_section_array[0];
        $section = $class_section_array[1];
        
        $marks = Mark::where('exam_id', $request->exam_id)
                     ->where('class', $class)
                     ->where('section', $section)
                     ->get();
        $students = Student::where('school_id', Auth::user()->school_id)
                           ->where('session', $exam->exam_session)
                           ->where('class', $class)
                           ->where('section', $section)
                           ->orderBy('roll', 'ASC')
                           ->get();
        $examsubjects = Examsubject::where('exam_id', $request->exam_id)
                                  ->where('class', $class)
                                  ->orderBy('subject_id', 'asc')
                                  ->get();

        // skip if ban 2 or en 2, because numbers are counted in ban 1 and en 1
        $ban_en_array = [2, 4];
        foreach ($students as $student) {
            $total_marks = 0;
            $total_grade_point = 0;
            $sorting_sub_math = 0;
            $sorting_sub_en = 0;
            $sorting_sub_ban = 0;
            $subjects_marks = [];
            $grade_array = [];
            foreach ($marks as $mark) {
                if($student->student_id == $mark->student_id) {
                    // for class 9 and 10, consider higher math and agriculture
                    // for class 9 and 10, consider higher math and agriculture
                    if($class > 8) {
                        // adhoc somadhan, jehetu bojhar upay nai j student higher naki
                        if(($mark->subject_id == 15 && $mark->total == 0) || ($mark->subject_id == 19 && $mark->total == 0)) { // agriculture
                            // do nothing
                        } else {
                            $subject_mark['student_id'] = $mark->student_id;
                            $subject_mark['subject_id'] = $mark->subject_id;
                            $subject_mark['subject_name'] = substr($mark->subject->name_english, 0, 1);
                            $subject_mark['written'] = $mark->written;
                            $subject_mark['mcq'] = $mark->mcq;
                            $subject_mark['practical'] = $mark->practical;
                            $subject_mark['ca'] = $mark->ca;
                            $subject_mark['total'] = $mark->total;
                            $subject_mark['grade'] = $mark->grade;
                            $subjects_marks[] = $subject_mark;

                            if(in_array($mark->subject_id, $ban_en_array)) {
                                continue;
                            } else {
                                $total_marks = $total_marks + $mark->total;
                                if($mark->grade_point != 'N/A') {
                                    $total_grade_point = $total_grade_point + $mark->grade_point;
                                } else {
                                    $total_grade_point = $total_grade_point * 0;
                                }
                            }
                            if($mark->subject_id == 1) {
                                $sorting_sub_ban = $mark->total; // bangla
                            } elseif($mark->subject_id == 3) {
                                $sorting_sub_en = $mark->total; // english
                            } elseif($mark->subject_id == 3) {
                                $sorting_sub_math = $mark->total; // math
                            }
                            // grade array...
                            $grade_array[] = $mark->grade;
                        }
                        // adhoc somadhan, jehetu bojhar upay nai j student higher naki
                    } else {
                        $subject_mark['student_id'] = $mark->student_id;
                        $subject_mark['subject_id'] = $mark->subject_id;
                        $subject_mark['subject_name'] = substr($mark->subject->name_english, 0, 1);
                        $subject_mark['written'] = $mark->written;
                        $subject_mark['mcq'] = $mark->mcq;
                        $subject_mark['practical'] = $mark->practical;
                        $subject_mark['ca'] = $mark->ca;
                        $subject_mark['total'] = $mark->total;
                        $subject_mark['grade'] = $mark->grade;
                        $subjects_marks[] = $subject_mark;
                        
                        if(in_array($mark->subject_id, $ban_en_array)) {
                            continue;
                        } else {
                            $total_marks = $total_marks + $mark->total;
                            if($mark->grade_point != 'N/A') {
                                $total_grade_point = $total_grade_point + $mark->grade_point;
                            } else {
                                $total_grade_point = $total_grade_point * 0;
                            }
                        }
                        if($mark->subject_id == 1) {
                            $sorting_sub_ban = $mark->total; // bangla
                        } elseif($mark->subject_id == 3) {
                            $sorting_sub_en = $mark->total; // english
                        } elseif($mark->subject_id == 3) {
                            $sorting_sub_math = $mark->total; // math
                        }
                        // grade array...
                        $grade_array[] = $mark->grade;
                    }
                }
            }
            if(in_array('F', $grade_array) || in_array('N/A', $grade_array)) {
                $total_grade_point = 0;
            }
            $gpa = $total_grade_point/$request->subject_count;
            if($gpa > 5.00) {
                $gpa = 5.00;
            }
            $gpa = number_format($gpa, 2);
            $grade = avg_grade($gpa);
            if(($grade == 'F') || ($grade == 'N/A')) {
                $gpa = number_format(0, 2);
            }
            $result_sub['gpa'] = (float)$gpa;
            $result_sub['total_marks'] = (int)$total_marks;
            $result_sub['sorting_sub_math'] = (int)$sorting_sub_math;
            $result_sub['sorting_sub_en'] = (int)$sorting_sub_en;
            $result_sub['sorting_sub_ban'] = (int)$sorting_sub_ban;
            $result_sub['roll'] = (int)$student->roll;
            $result_sub['student_id'] = $student->student_id;
            $result_sub['grade'] = $grade;
            $result_sub['subjects_marks'] = $subjects_marks;

            $result_sub['school_id'] = Auth::user()->school_id;
            $result_sub['exam_id'] = $request->exam_id;
            $result_sub['class'] = $class;
            $result_sub['section'] = $section;
            $result_sub['name'] = $student->name;
            $result_sub['mobile'] = $student->contact;
            $result_sub['exam'] = $exam->name;
            
            $results[$student->student_id] = $result_sub;
        }
        
        //rsort($results);
        foreach ($results as $key => $row)
        {
            $result_array_gpa[$key] = $row['gpa'];
            $result_array_total_marks[$key] = $row['total_marks'];
            $result_array_sorting_sub_math[$key] = $row['sorting_sub_math'];
            $result_array_sorting_sub_en[$key] = $row['sorting_sub_en'];
            $result_array_sorting_sub_ban[$key] = $row['sorting_sub_ban'];
            $result_array_roll[$key] = $row['roll'];
        }
        array_multisort($result_array_gpa, SORT_DESC, $result_array_total_marks, SORT_DESC, $result_array_sorting_sub_math, SORT_DESC, $result_array_sorting_sub_en, SORT_DESC, $result_array_sorting_sub_ban, SORT_DESC, $result_array_roll, SORT_ASC, $results);
        $results_coll = collect($results);

        // dd($results_coll);

        return view('exams.excel.export')->withResults($results_coll);
    }

    public function getSendSMSResult(Request $request)
    {
        $this->validate($request, [
            'exam_id'         => 'required',
            'class_section'   => 'required',
            'subject_count'   => 'required'
        ]);

        $exam = Exam::where('id', $request->exam_id)->first();

        $class_section_array = explode('_', $request->class_section);
        $class   = $class_section_array[0];
        $section = $class_section_array[1];
        
        $marks = Mark::where('exam_id', $request->exam_id)
                     ->where('class', $class)
                     ->where('section', $section)
                     ->get();
        $students = Student::where('school_id', Auth::user()->school_id)
                           ->where('session', $exam->exam_session)
                           ->where('class', $class)
                           ->where('section', $section)
                           ->orderBy('roll', 'ASC')
                           ->get();
        $examsubjects = Examsubject::where('exam_id', $request->exam_id)
                                  ->where('class', $class)
                                  ->orderBy('subject_id', 'asc')
                                  ->get();

        // CHECK SMS BALANCE
        // CHECK SMS BALANCE
        if(count($students) > Auth::user()->school->smsbalance) {
          Session::flash('warning', 'অপর্যাপ্ত SMS ব্যালেন্স!');
          return redirect()->route('exam.getresultgenpage');
        }
        // CHECK SMS BALANCE
        // CHECK SMS BALANCE

        // skip if ban 2 or en 2, because numbers are counted in ban 1 and en 1
        $ban_en_array = [2, 4];
        foreach ($students as $student) {
            $total_marks = 0;
            $total_grade_point = 0;
            $sorting_sub_math = 0;
            $sorting_sub_en = 0;
            $sorting_sub_ban = 0;
            $subjects_marks = [];
            $grade_array = [];
            foreach ($marks as $mark) {
                if($student->student_id == $mark->student_id) {
                    // for class 9 and 10, consider higher math and agriculture
                    // for class 9 and 10, consider higher math and agriculture
                    if($class > 8) {
                        // adhoc somadhan, jehetu bojhar upay nai j student higher naki
                        if(($mark->subject_id == 15 && $mark->total == 0) || ($mark->subject_id == 19 && $mark->total == 0)) { // agriculture
                            // do nothing
                        } else {
                            $subject_mark['student_id'] = $mark->student_id;
                            $subject_mark['subject_id'] = $mark->subject_id;
                            $subject_mark['subject_name'] = substr($mark->subject->name_english, 0, 1);
                            $subject_mark['written'] = $mark->written;
                            $subject_mark['mcq'] = $mark->mcq;
                            $subject_mark['practical'] = $mark->practical;
                            $subject_mark['ca'] = $mark->ca;
                            $subject_mark['total'] = $mark->total;
                            $subject_mark['grade'] = $mark->grade;
                            $subjects_marks[] = $subject_mark;

                            if(in_array($mark->subject_id, $ban_en_array)) {
                                continue;
                            } else {
                                $total_marks = $total_marks + $mark->total;
                                if($mark->grade_point != 'N/A') {
                                    $total_grade_point = $total_grade_point + $mark->grade_point;
                                } else {
                                    $total_grade_point = $total_grade_point * 0;
                                }
                            }
                            if($mark->subject_id == 1) {
                                $sorting_sub_ban = $mark->total; // bangla
                            } elseif($mark->subject_id == 3) {
                                $sorting_sub_en = $mark->total; // english
                            } elseif($mark->subject_id == 3) {
                                $sorting_sub_math = $mark->total; // math
                            }
                            // grade array...
                            $grade_array[] = $mark->grade;
                        }
                        // adhoc somadhan, jehetu bojhar upay nai j student higher naki
                    } else {
                        $subject_mark['student_id'] = $mark->student_id;
                        $subject_mark['subject_id'] = $mark->subject_id;
                        $subject_mark['subject_name'] = substr($mark->subject->name_english, 0, 1);
                        $subject_mark['written'] = $mark->written;
                        $subject_mark['mcq'] = $mark->mcq;
                        $subject_mark['practical'] = $mark->practical;
                        $subject_mark['ca'] = $mark->ca;
                        $subject_mark['total'] = $mark->total;
                        $subject_mark['grade'] = $mark->grade;
                        $subjects_marks[] = $subject_mark;
                        
                        if(in_array($mark->subject_id, $ban_en_array)) {
                            continue;
                        } else {
                            $total_marks = $total_marks + $mark->total;
                            if($mark->grade_point != 'N/A') {
                                $total_grade_point = $total_grade_point + $mark->grade_point;
                            } else {
                                $total_grade_point = $total_grade_point * 0;
                            }
                        }
                        if($mark->subject_id == 1) {
                            $sorting_sub_ban = $mark->total; // bangla
                        } elseif($mark->subject_id == 3) {
                            $sorting_sub_en = $mark->total; // english
                        } elseif($mark->subject_id == 3) {
                            $sorting_sub_math = $mark->total; // math
                        }
                        // grade array...
                        $grade_array[] = $mark->grade;
                    }
                }
            }
            if(in_array('F', $grade_array) || in_array('N/A', $grade_array)) {
                $total_grade_point = 0;
            }
            $gpa = $total_grade_point/$request->subject_count;
            if($gpa > 5.00) {
                $gpa = 5.00;
            }
            $gpa = number_format($gpa, 2);
            $grade = avg_grade($gpa);
            if(($grade == 'F') || ($grade == 'N/A')) {
                $gpa = number_format(0, 2);
            }
            $result_sub['gpa'] = (float)$gpa;
            $result_sub['total_marks'] = (int)$total_marks;
            $result_sub['sorting_sub_math'] = (int)$sorting_sub_math;
            $result_sub['sorting_sub_en'] = (int)$sorting_sub_en;
            $result_sub['sorting_sub_ban'] = (int)$sorting_sub_ban;
            $result_sub['roll'] = (int)$student->roll;
            $result_sub['student_id'] = $student->student_id;
            $result_sub['grade'] = $grade;
            $result_sub['subjects_marks'] = $subjects_marks;

            $result_sub['school_id'] = Auth::user()->school_id;
            $result_sub['exam_id'] = $request->exam_id;
            $result_sub['class'] = $class;
            $result_sub['section'] = $section;
            $result_sub['name'] = $student->name;
            $result_sub['mobile'] = $student->contact;
            $result_sub['exam'] = $exam->name;
            
            $results[$student->student_id] = $result_sub;
        }
        
        //rsort($results);
        foreach ($results as $key => $row)
        {
            $result_array_gpa[$key] = $row['gpa'];
            $result_array_total_marks[$key] = $row['total_marks'];
            $result_array_sorting_sub_math[$key] = $row['sorting_sub_math'];
            $result_array_sorting_sub_en[$key] = $row['sorting_sub_en'];
            $result_array_sorting_sub_ban[$key] = $row['sorting_sub_ban'];
            $result_array_roll[$key] = $row['roll'];
        }
        // dd($results);
        array_multisort($result_array_gpa, SORT_DESC, $result_array_total_marks, SORT_DESC, $result_array_sorting_sub_math, SORT_DESC, $result_array_sorting_sub_en, SORT_DESC, $result_array_sorting_sub_ban, SORT_DESC, $result_array_roll, SORT_ASC, $results);
        $results_coll = collect($results);

        $smsdata = [];
        $counter = 1;
        foreach ($results_coll as $i => $result) {
            $resultdetails = '';
            foreach($result['subjects_marks'] as $marks) {
                $resultdetails .= $marks['subject_name'] .':'. $marks['grade'] . ',';
            }

            if($result['grade'] == 'F') {
                $smstext = 'Jamalpur H School:' . exam_en($result['exam']) . ' Result. ' . rtrim($result['name']) . '.Merit:N/A,GPA:' . $result['gpa'] . ',Details:' . rtrim($resultdetails, ',');
            } else {
                $smstext = 'Jamalpur H School:' . exam_en($result['exam']) . ' Result. ' . rtrim($result['name']) . '.Merit:'. $counter . ',GPA:' . $result['gpa'] . ',Details:' . rtrim($resultdetails, ',');
            }
            $mobile_number = $result['mobile'];
            $encodedtext = rawurlencode($smstext);
            // $encodedtext = $text;
            $smsdata[$i] = array(
                // 'name'=>"$member->name",
                // 'name_bangla'=>"$member->name_bangla",
                // 'member_id'=>"$member->member_id",
                'to'=>"$mobile_number",
                'message'=>"$smstext", // $encodedtext
                // 'joining_date'=>"$member->joining_date",
                // 'due'=>"$member->totalpendingmonthly",
            );

            $counter++;
        }
        $smsdata = array_values($smsdata);
        $smsjsondata = json_encode($smsdata);

        // dd($smsdata);

        // send sms
        $url = config('sms.gw_url');

        $data= array(
            'smsdata'=>"$smsjsondata",
            // 'username'=>config('sms.username'),
            // 'password'=>config('sms.password'),
            'token'=>config('sms.gw_token'),
        ); // Add parameters in key value
        $ch = curl_init(); // Initialize cURL
        curl_setopt($ch, CURLOPT_URL,$url);
        curl_setopt($ch, CURLOPT_ENCODING, '');
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $smsresult = curl_exec($ch);

        // $sendstatus = $result = substr($smsresult, 0, 3);
        $resultstr = substr($smsresult, 0, 6);
        // dd($smsresult);
        // send sms

        if($resultstr == '') {
            Session::flash('success', 'SMS সফলভাবে পাঠানো হয়েছে!');
            Auth::user()->school->smsbalance = Auth::user()->school->smsbalance - count($students);
            // aro kaaj ache
            // aro kaaj ache
            Auth::user()->school->save();
        } elseif($resultstr == 'Error:' && strpos($smsresult, 'Invalid Number !') !== false) {
            Session::flash('success', bangla(count($smsdata) - substr_count($smsresult, 'Invalid Number !')) . ' টি নাম্বারে SMS সফলভাবে পাঠানো হয়েছে! মোট ' . bangla(substr_count($smsresult, 'Invalid Number !')) . ' টি অকার্যকর নম্বর।');
        } elseif($resultstr == 'Error:' && strpos($smsresult, 'Invalid Number !') == false) {
            Session::flash('info', 'দুঃখিত! SMS পাঠানো যায়নি!');
            // Session::flash('warning', 'অপর্যাপ্ত SMS ব্যালেন্সের কারণে SMS পাঠানো যায়নি!');
        } else {
            // Session::flash('warning', 'দুঃখিত! SMS পাঠানো যায়নি!');
            Session::flash('warning', 'কিছু কিছু নাম্বারে SMS পাঠানো যায়নি!');
            Auth::user()->school->smsbalance = Auth::user()->school->smsbalance - count($students);
            // aro kaaj ache
            // aro kaaj ache
            Auth::user()->school->save();
        }
        return redirect()->route('exam.getresultgenpage');
    }

    public function export() 
    {
        return Excel::download(new InvoicesExport, 'invoices.xlsx');
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
    public function destroy(Request $request, $id)
    {
        $this->validate($request,array(
            'contact_sum_result_hidden'   => 'required',
            'contact_sum_result'   => 'required'
        ));

        if($request->contact_sum_result_hidden == $request->contact_sum_result) {
            $exam = Exam::findOrFail($id);

            // delete from subjects table
            $examsubjects = Examsubject::where('exam_id', $id)->get();
            foreach($examsubjects as $examsubject) {
                $examsubject->delete();
            }

            // delete from marksheet table
            $marks = Mark::where('exam_id', $id)->get();
            foreach($marks as $mark) {
                $mark->delete();
            }

            $exam->delete();

            Session::flash('success', 'পরীক্ষাটি ও তৎসংশ্লিষ্ট তথ্যাদি ডিলেট করা হয়েছে!');
            return redirect()->route('exams.index');
        } else {
            return redirect()->route('exams.index')->with('warning', 'যোগফল সঠিক নয়, আবার চেষ্টা করুন।');
        }        
    }
}
