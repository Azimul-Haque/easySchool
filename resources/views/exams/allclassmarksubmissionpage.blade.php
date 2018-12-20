@extends('adminlte::page')

@section('title', 'Exam Settings | Easy School')

@section('css')
  <style type="text/css">
    .hiddenCheckbox, .hiddenFinalSaveBtn {
      display:none;
    }
  </style>
@stop

@section('content_header')
    <h1>
      নম্বর প্রদান করুন
      <div class="pull-right btn-group">
          
      </div>  
    </h1>
@stop

@section('content')
  @permission('result-gs')
  <div class="row">
    <div class="col-md-6">
      <h4>
        চলতি পরীক্ষার নামঃ <b>{{ exam(Auth::user()->exam->name) }}-{{ bangla(Auth::user()->exam->exam_session) }}</b>
      </h4>
    </div>
    <div class="col-md-6"></div>
  </div>
  <div class="row">
    <div class="col-md-12">
      @php
        $exams_total_subjects = explode(',', Auth::user()->exam->total_subjects);
        $exam_classes = [];
        foreach ($exams_total_subjects as $exams_total_subject) {
          $exam_array = explode(':', $exams_total_subject);
          array_push($exam_classes, $exam_array[0]);
        }
      @endphp
      @if(Auth::user()->school->sections > 0)
        <div class="row">
          @php
            $exam_classes_counter = 1;
          @endphp
          @foreach($exam_classes as $class)
          <div class="col-md-6">
            <div class="table-responsive">
              <table class="table">
                <thead>
                  <tr>
                    <th colspan="{{ Auth::user()->school->sections }}">
                      <center><span style="font-size: 18px;">{{ bangla_class($class) }}</span></center>
                    </th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td>
                      <table class="table">
                        <thead>
                          <tr>
                            @for($secscount = 1; $secscount <= Auth::user()->school->sections; $secscount++)
                            <th>
                              <center>
                                {{ bangla_section(Auth::user()->school->section_type, $class, $secscount) }}
                              </center>
                            </th>
                            @endfor
                          </tr>
                        </thead>
                        <tbody>
                          <tr>
                            @for($secscount = 1; $secscount <= Auth::user()->school->sections; $secscount++)
                            <td>
                              @foreach(Auth::user()->exam->examsubjects->where('class', (int)$class) as $subject)
                                <center>
                                  <a class="btn btn-success" title="{{ bangla_class($class) }} {{ bangla_section(Auth::user()->school->section_type, $class, $secscount) }} {{ $subject->subject->name_bangla }}-এ নম্বর প্রদান করুন" href="{{ route('exam.getsubmissionpage', [Auth::user()->id, Auth::user()->school_id, Auth::user()->exam_id, $subject->subject_id, $class, $secscount]) }}" style="margin: 3px;" target="_blank">
                                    {{ $subject->subject->name_bangla }}
                                  </a><br/>
                                </center>
                              @endforeach
                            </td>
                            @endfor
                          </tr>
                        </tbody>
                      </table>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
          @if($exam_classes_counter % 2 == 0)
          </div>
          <div class="row">
          @endif
          @php
            $exam_classes_counter++;
          @endphp
          @endforeach
        </div>
      @else
        <div class="table-responsive">
          <table class="table">
            <thead>
              <tr>
                @foreach($exam_classes as $class)
                <th>
                  <center><span style="font-size: 18px;">{{ bangla_class($class) }}</span></center>
                </th>
                @endforeach
              </tr>
            </thead>
            <tbody>
              <tr>
                @foreach($exam_classes as $class)
                <td>
                  @foreach(Auth::user()->exam->examsubjects->where('class', (int)$class) as $subject)
                    <center>
                      <a class="btn btn-success" title="{{ bangla_class($class) }} {{ bangla_section(Auth::user()->school->section_type, $class, 0) }} {{ $subject->subject->name_bangla }}-এ নম্বর প্রদান করুন" href="{{ route('exam.getsubmissionpage', [Auth::user()->id, Auth::user()->school_id, Auth::user()->exam_id, $subject->subject_id, $class, 0]) }}" style="margin: 3px;" target="_blank">
                        {{ $subject->subject->name_bangla }}
                      </a><br/>
                    </center>
                  @endforeach
                </td>
                @endforeach
              </tr>
            </tbody>
          </table>
        </div>
      @endif
    </div>
  </div>
  @endpermission
@stop

@section('js')
  {{-- {!!Html::script('js/select2.min.js')!!} --}}
  <script type="text/javascript">
    $(function(){
     $('a[title]').tooltip();
     $('button[title]').tooltip();
    });
  </script>
@stop