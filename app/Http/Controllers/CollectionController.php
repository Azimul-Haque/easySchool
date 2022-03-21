<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Student;
use App\User;
use App\Feecollection;

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
                               ->orderBy('roll','ASC')->get();

        } else {
            $students = Student::where('school_id', Auth::user()->school_id)
                               ->where('session',$session)
                               ->where('class',$class)
                               ->orderBy('roll','ASC')->get();
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
            if($request['admission_session_fee'.$student->student_id]) {
                $collection = new Feecollection;
                $collection->school_id = Auth::user()->school_id;
                $collection->session = $session;
                $collection->class = $class;
                $collection->section = $section == 'No_Section' ? 0 : $section;
                $collection->roll = $student->roll;
                $collection->student_id = $student->student_id;
                $collection->fee_attribute = 'admission_session_fee';
                $collection->fee_value = $request['admission_session_fee'.$student->student_id];
                $collection->collector = $request->collector;
                $collection->collection_date = date('Y-m-d', strtotime($request->collection_date));
                $collection->save();
            }
            if($request['annual_sports_cultural'.$student->student_id]) {
                $collection = new Feecollection;
                $collection->school_id = Auth::user()->school_id;
                $collection->session = $session;
                $collection->class = $class;
                $collection->section = $section == 'No_Section' ? 0 : $section;
                $collection->roll = $student->roll;
                $collection->student_id = $student->student_id;
                $collection->fee_attribute = 'annual_sports_cultural';
                $collection->fee_value = $request['annual_sports_cultural'.$student->student_id];
                $collection->collector = $request->collector;
                $collection->collection_date = date('Y-m-d', strtotime($request->collection_date));
                $collection->save();
            }
            if($request['last_year_due'.$student->student_id]) {
                $collection = new Feecollection;
                $collection->school_id = Auth::user()->school_id;
                $collection->session = $session;
                $collection->class = $class;
                $collection->section = $section == 'No_Section' ? 0 : $section;
                $collection->roll = $student->roll;
                $collection->student_id = $student->student_id;
                $collection->fee_attribute = 'last_year_due';
                $collection->fee_value = $request['last_year_due'.$student->student_id];
                $collection->collector = $request->collector;
                $collection->collection_date = date('Y-m-d', strtotime($request->collection_date));
                $collection->save();
            }
            if($request['exam_fee'.$student->student_id]) {
                $collection = new Feecollection;
                $collection->school_id = Auth::user()->school_id;
                $collection->session = $session;
                $collection->class = $class;
                $collection->section = $section == 'No_Section' ? 0 : $section;
                $collection->roll = $student->roll;
                $collection->student_id = $student->student_id;
                $collection->fee_attribute = 'exam_fee';
                $collection->fee_value = $request['exam_fee'.$student->student_id];
                $collection->collector = $request->collector;
                $collection->collection_date = date('Y-m-d', strtotime($request->collection_date));
                $collection->save();
            }
            if($request['full_half_free_form'.$student->student_id]) {
                $collection = new Feecollection;
                $collection->school_id = Auth::user()->school_id;
                $collection->session = $session;
                $collection->class = $class;
                $collection->section = $section == 'No_Section' ? 0 : $section;
                $collection->roll = $student->roll;
                $collection->student_id = $student->student_id;
                $collection->fee_attribute = 'full_half_free_form';
                $collection->fee_value = $request['full_half_free_form'.$student->student_id];
                $collection->collector = $request->collector;
                $collection->collection_date = date('Y-m-d', strtotime($request->collection_date));
                $collection->save();
            }
            if($request['3_6_8_12_fee'.$student->student_id]) {
                $collection = new Feecollection;
                $collection->school_id = Auth::user()->school_id;
                $collection->session = $session;
                $collection->class = $class;
                $collection->section = $section == 'No_Section' ? 0 : $section;
                $collection->roll = $student->roll;
                $collection->student_id = $student->student_id;
                $collection->fee_attribute = '3_6_8_12_fee';
                $collection->fee_value = $request['3_6_8_12_fee'.$student->student_id];
                $collection->collector = $request->collector;
                $collection->collection_date = date('Y-m-d', strtotime($request->collection_date));
                $collection->save();
            }
            if($request['jsc_ssc_form_fee'.$student->student_id]) {
                $collection = new Feecollection;
                $collection->school_id = Auth::user()->school_id;
                $collection->session = $session;
                $collection->class = $class;
                $collection->section = $section == 'No_Section' ? 0 : $section;
                $collection->roll = $student->roll;
                $collection->student_id = $student->student_id;
                $collection->fee_attribute = 'jsc_ssc_form_fee';
                $collection->fee_value = $request['jsc_ssc_form_fee'.$student->student_id];
                $collection->collector = $request->collector;
                $collection->collection_date = date('Y-m-d', strtotime($request->collection_date));
                $collection->save();
            }
            if($request['certificate_fee'.$student->student_id]) {
                $collection = new Feecollection;
                $collection->school_id = Auth::user()->school_id;
                $collection->session = $session;
                $collection->class = $class;
                $collection->section = $section == 'No_Section' ? 0 : $section;
                $collection->roll = $student->roll;
                $collection->student_id = $student->student_id;
                $collection->fee_attribute = 'certificate_fee';
                $collection->fee_value = $request['certificate_fee'.$student->student_id];
                $collection->collector = $request->collector;
                $collection->collection_date = date('Y-m-d', strtotime($request->collection_date));
                $collection->save();
            }
            if($request['scout_fee'.$student->student_id]) {
                $collection = new Feecollection;
                $collection->school_id = Auth::user()->school_id;
                $collection->session = $session;
                $collection->class = $class;
                $collection->section = $section == 'No_Section' ? 0 : $section;
                $collection->roll = $student->roll;
                $collection->student_id = $student->student_id;
                $collection->fee_attribute = 'scout_fee';
                $collection->fee_value = $request['scout_fee'.$student->student_id];
                $collection->collector = $request->collector;
                $collection->collection_date = date('Y-m-d', strtotime($request->collection_date));
                $collection->save();
            }
            if($request['develoment_donation'.$student->student_id]) {
                $collection = new Feecollection;
                $collection->school_id = Auth::user()->school_id;
                $collection->session = $session;
                $collection->class = $class;
                $collection->section = $section == 'No_Section' ? 0 : $section;
                $collection->roll = $student->roll;
                $collection->student_id = $student->student_id;
                $collection->fee_attribute = 'develoment_donation';
                $collection->fee_value = $request['develoment_donation'.$student->student_id];
                $collection->collector = $request->collector;
                $collection->collection_date = date('Y-m-d', strtotime($request->collection_date));
                $collection->save();
            }
            if($request['other_fee'.$student->student_id]) {
                $collection = new Feecollection;
                $collection->school_id = Auth::user()->school_id;
                $collection->session = $session;
                $collection->class = $class;
                $collection->section = $section == 'No_Section' ? 0 : $section;
                $collection->roll = $student->roll;
                $collection->student_id = $student->student_id;
                $collection->fee_attribute = 'other_fee';
                $collection->fee_value = $request['other_fee'.$student->student_id];
                $collection->collector = $request->collector;
                $collection->collection_date = date('Y-m-d', strtotime($request->collection_date));
                $collection->save();
            }
        }
        Session::flash('success', 'আদায় সফলভাবে সংরক্ষিত করা হয়েছে!');
        return redirect()->route('collection.getstudents', [$session, $class, $section]);
        // dd($request->all());
    }

    public function collectionList()
    {
        return view('collection.collectionlist')
                    ->withSessionsearch(null)
                    ->withClasssearch(null)
                    ->withSectionsearch(null)
                    ->withFeecollections(null)
                    ->withUsedstudentids(null)
                    ->withFromdatesearch(null)
                    ->withTodatesearch(null);
    }

    public function collectionListData($session, $class, $section, $date_from, $date_to)
    {
        $from = date('Y-m-d', strtotime($date_from));
        $to = date('Y-m-d', strtotime($date_to));

        // dd($from);
        

        if($section != 'No_Section') {
            if($class != 'All_Classes') {
                $used_student_ids = Feecollection::where('school_id', Auth::user()->school_id)
                                                 ->where('session',$session)
                                                 ->where('class',$class)
                                                 ->where('section',$section)
                                                 ->whereBetween('collection_date', [$from, $to])
                                                 ->distinct()->select('student_id', 'collection_date')
                                                 ->orderBy('collection_date','ASC')
                                                 ->orderBy('roll','ASC')
                                                 ->get();

                $feecollections = Feecollection::where('school_id', Auth::user()->school_id)
                                               ->where('session',$session)
                                               ->where('class',$class)
                                               ->where('section',$section)
                                               ->whereBetween('collection_date', [$from, $to])
                                            //    ->groupBy('collection_date')
                                               ->orderBy('collection_date','ASC')->get();
            } else {
                $used_student_ids = Feecollection::where('school_id', Auth::user()->school_id)
                                                ->where('session',$session)
                                                ->whereBetween('collection_date', [$from, $to])
                                                ->distinct()->select('student_id', 'collection_date')
                                                ->orderBy('collection_date','ASC')
                                                ->orderBy('class','ASC')
                                                ->orderBy('section','ASC')
                                                ->orderBy('roll','ASC')
                                                ->get();

                $feecollections = Feecollection::where('school_id', Auth::user()->school_id)
                                                ->where('session',$session)
                                                ->whereBetween('collection_date', [$from, $to])
                                                ->orderBy('collection_date','DESC')->get();
            }
        } else {
            // No_Section ER KAAJ BAKI ACHE
            // No_Section ER KAAJ BAKI ACHE
        }
        // dd($used_student_ids);

        return view('collection.collectionlist')
                    ->withSessionsearch($session)
                    ->withClasssearch($class)
                    ->withSectionsearch($section)
                    ->withFromdatesearch($from)
                    ->withTodatesearch($to)
                    ->withFeecollections($feecollections)
                    ->withUsedstudentids($used_student_ids);
    }
    
    public function collectionListPDF($session, $class, $section, $date_from, $date_to)
    {
        $from = date('Y-m-d', strtotime($date_from));
        $to = date('Y-m-d', strtotime($date_to));
        // dd($from);

        if($section != 'No_Section') {
            if($class != 'All_Classes') {
                $used_student_ids = Feecollection::where('school_id', Auth::user()->school_id)
                                                 ->where('session',$session)
                                                 ->where('class',$class)
                                                 ->where('section',$section)
                                                 ->whereBetween('collection_date', [$from, $to])
                                                 ->distinct()->select('student_id', 'collection_date')
                                                 ->orderBy('collection_date','ASC')
                                                 ->orderBy('roll','ASC')
                                                 ->get();

                $feecollections = Feecollection::where('school_id', Auth::user()->school_id)
                                               ->where('session',$session)
                                               ->where('class',$class)
                                               ->where('section',$section)
                                               ->whereBetween('collection_date', [$from, $to])
                                            //    ->groupBy('collection_date')
                                               ->orderBy('collection_date','ASC')->get();
            } else {
                $used_student_ids = Feecollection::where('school_id', Auth::user()->school_id)
                                                ->where('session',$session)
                                                ->whereBetween('collection_date', [$from, $to])
                                                ->distinct()->select('student_id', 'collection_date')
                                                ->orderBy('collection_date','ASC')
                                                ->orderBy('class','ASC')
                                                ->orderBy('roll','ASC')
                                                ->get();

                $feecollections = Feecollection::where('school_id', Auth::user()->school_id)
                                                ->where('session',$session)
                                                ->whereBetween('collection_date', [$from, $to])
                                                ->orderBy('collection_date','DESC')->get();
            }
        } else {
            // No_Section ER KAAJ BAKI ACHE
            // No_Section ER KAAJ BAKI ACHE
        }
        // dd($used_student_ids);

        $pdf = PDF::loadView('collection.pdf.collectionlist', ['feecollections' => $feecollections, 'usedstudentids' => $used_student_ids], ['data' => [$session, $class, $section, $date_from, $date_to]], ['mode' => 'utf-8', 'format' => 'A4-L']);
        $fileName = 'Collection_List_Report' . '.pdf';
        return $pdf->stream($fileName); // stream, download

        return view('collection.collectionlist')
                    ->withSessionsearch($session)
                    ->withClasssearch($class)
                    ->withSectionsearch($section)
                    ->withFromdatesearch($from)
                    ->withTodatesearch($to)
                    ->withFeecollections($feecollections)
                    ->withUsedstudentids($used_student_ids);
    }

    public function deleteSingle($id) {
        $collection = Feecollection::findOrFail($id);
        $collection->delete();

        Session::flash('success', 'Deleted!');
        return redirect()->back();
    }

    public function collectionDailyledger()
    {
        return view('collection.collectiondailyledger')
                    ->withFeecollections(null)
                    ->withUsedstudentids(null)
                    ->withFromdatesearch(null)
                    ->withTodatesearch(null);
    }

    public function collectionDailyledgerData($date_from, $date_to)
    {
        $from = date('Y-m-d', strtotime($date_from));
        $to = date('Y-m-d', strtotime($date_to));

        // dd($from);
        

        $used_student_ids = Feecollection::where('school_id', Auth::user()->school_id)
                                            ->whereBetween('collection_date', [$from, $to])
                                            ->distinct()->select('class', 'section', 'collection_date')
                                            ->orderBy('collection_date','ASC')
                                            ->orderBy('class','ASC')
                                            ->orderBy('section','ASC')
                                            ->get();

        $feecollections = Feecollection::where('school_id', Auth::user()->school_id)
                                        ->whereBetween('collection_date', [$from, $to])
                                    //    ->groupBy('collection_date')
                                        ->orderBy('collection_date','ASC')->get();
        // dd($used_student_ids);

        return view('collection.collectiondailyledger')
                    ->withFromdatesearch($from)
                    ->withTodatesearch($to)
                    ->withFeecollections($feecollections)
                    ->withUsedstudentids($used_student_ids);
    }
    
    public function collectionDailyledgerPDF($date_from, $date_to)
    {
        $from = date('Y-m-d', strtotime($date_from));
        $to = date('Y-m-d', strtotime($date_to));

        // dd($from);
        

        $used_student_ids = Feecollection::where('school_id', Auth::user()->school_id)
                                            ->whereBetween('collection_date', [$from, $to])
                                            ->distinct()->select('class', 'section', 'collection_date')
                                            ->orderBy('collection_date','ASC')
                                            ->orderBy('class','ASC')
                                            ->orderBy('section','ASC')
                                            ->get();

        $feecollections = Feecollection::where('school_id', Auth::user()->school_id)
                                        ->whereBetween('collection_date', [$from, $to])
                                    //    ->groupBy('collection_date')
                                        ->orderBy('collection_date','ASC')->get();
        // dd($used_student_ids);

        $pdf = PDF::loadView('collection.pdf.collectiondailyledger', ['feecollections' => $feecollections, 'usedstudentids' => $used_student_ids], ['data' => [$date_from, $date_to]], ['mode' => 'utf-8', 'format' => 'A4-L']);
        $fileName = 'Collection_Daily_Ledger_Report' . '.pdf';
        return $pdf->stream($fileName); // stream, download
    }
}
