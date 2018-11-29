<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Subject;

class SubjectController extends Controller
{
    public function __construct(){
        $this->middleware('role:headmaster');
        $this->middleware('permission:universal-subjects'); // ['only' => ['create', 'store', 'edit', 'delete']]
    }


    public function index()
    {
        $subjects = Subject::all();
        return view('subjects.index')->withSubjects($subjects);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('subjects.create');
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
            'name_bangla' => 'required',
            'name_english' => 'required'
        ]);

        $subject = new Subject;
        $subject->name_bangla = $request->name_bangla;
        $subject->name_english = $request->name_english;
        $subject->save();

        return redirect()->route('subjects.index')
                        ->with('success','সফলভাবে বিষয় তৈরি করা হয়েছে!');
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
        $subject = Subject::find($id);
        return view('subjects.edit')->withSubject($subject);
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
            'name_bangla' => 'required',
            'name_english' => 'required'
        ]);

        $subject = Subject::find($id);
        $subject->name_bangla = $request->name_bangla;
        $subject->name_english = $request->name_english;
        $subject->save();

        return redirect()->route('subjects.index')
                        ->with('success','সফলভাবে বিষয় হালনাগাদ করা হয়েছে!');
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
