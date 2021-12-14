@extends('layouts.schoollayout')

@section('title')
  ইজি স্কুল | {{ $school->name }}
@endsection

@section('css')
  <link rel="stylesheet" type="text/css" href="{{ asset('css/school-tabs.css') }}">
@endsection

@section('content')
<div class="container-fluid" style="min-height: 750px;">
    <div class="row">
      <div class="col-md-4"></div>
      <div class="col-md-4 wow fadeInUp" data-wow-duration="600ms">
        <div class="panel panel-success">
            <div class="panel-heading"><i class="fa fa-download"></i> ফলাফল ডাউনলোড করুন</div>
            <div class="panel-body">
              {!! Form::open(['route' => 'exam.getsinglemarksheetpdf', 'method' => 'GET']) !!}
                <div class="form-group">
                  @php
                    $currentexamid = '';
                    $currentexamname = '';
                    foreach($exams as $exam) {
                      if($exam->id == $school->currentexam) {
                        $currentexamid = $exam->id;
                        $currentexamname = $exam->name;
                      }
                    }
                  @endphp
                  <input type="hidden" name="school_id" class="form-control" value="{{ $school->id }}">
                  <input type="hidden" name="exam_id" class="form-control" value="{{ $currentexamid }}">
                  <input type="text" name="currentexamname" class="form-control" value="{{ exam($currentexamname) }}-{{ bangla($exam->exam_session) }}" disabled>
                </div>
                <div class="form-group">
                  <select name="class_section" class="form-control" required="">
                    <option value="" selected="" disabled="">শ্রেণি ও শাখা নির্ধারণ করুন</option>
                    @php
                      $school_classes = explode(',', $school->classes)
                    @endphp
                    @foreach($school_classes as $class)
                      @if($school->sections > 0)
                        @for($seccount=1; $seccount <= $school->sections; $seccount++)
                          <option value="{{ $class }}_{{ $seccount }}">{{ bangla_class($class) }} {{ bangla_section($school->section_type, $class, $seccount) }}</option>
                        @endfor
                      @else
                        <option value="{{ $class }}_0">{{ bangla_class($class) }}</option>
                      @endif
                    @endforeach
                  </select>
                </div>
                <div class="form-group">
                    <input type="number" name="student_id" class="form-control" placeholder="স্টুডেন্ট আইডি নম্বর" title="স্টুডেন্ট আইডি নম্বর" required>
                </div>
                <button class="btn btn-primary btn-block" type="submit"><i class="fa fa-fw fa-file-pdf-o" aria-hidden="true"></i> নম্বরপত্র (মার্কশিট) ডাউনলোড করুন</button>
              {!! Form::close() !!}
            </div>
        </div>
      </div>
    </div>
</div>
@endsection

@section('js')
   <script type="text/javascript">
     $(function(){
      $('a[title]').tooltip();
     });
   </script>
@endsection
