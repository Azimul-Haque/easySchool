@extends('adminlte::page')

@section('title', 'Easy School')

@section('content_header')
    <h1>ড্যাশবোর্ড</h1>
@stop

@section('content')
  @permission('school-settings')
    <div class="row">
      <div class="col-md-8" style="background-color:;">
        <div class="row">
          <div class="col-md-12">
            <div class="row">
              <div class="col-md-3 col-sm-6 col-xs-6">
                <a class="btn btn-default btn-block shadow-light shadow-light" title="কাজ চলছে">
                  <i class="fa fa-user dashboard-icon" aria-hidden="true"></i><br/>প্রশাসনিক
                </a><br/>
              </div>
              <div class="col-md-3 col-sm-6 col-xs-6">
                <a class="btn btn-default btn-block shadow-light" data-toggle="modal" data-target="#admissionmodal" data-backdrop="static" title="ভর্তি প্রক্রিয়ার পাতায় চলুন" style="color: #FDBD2F;">
                  <i class="fa fa-user-plus dashboard-icon" aria-hidden="true"></i><br/>ভর্তি প্রক্রিয়া
                </a><br/>
                <!-- Modal -->
                <div class="modal fade" id="admissionmodal" role="dialog">
                  <div class="modal-dialog modal-sm">
                    <div class="modal-content">
                      <div class="modal-header modal-header-success">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">শ্রেণি নির্ধারণ করুন</h4>
                      </div>
                      <div class="modal-body">
                        @php
                          $classes = explode(',', Auth::user()->school->classes);
                          if (($key = array_search(10, $classes)) !== false) {
                              unset($classes[$key]);
                          }
                        @endphp
                        @foreach($classes as $class)
                          <a href="{{ route('admissions.getclasswise', $class) }}"><i class="fa fa-file-text fa-fw"></i> {{ bangla_class($class) }} শ্রেণি</a><br/>
                        @endforeach
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-3 col-sm-6 col-xs-6">
                <a href="{{ route('students.index') }}" class="btn btn-default btn-block shadow-light" title="শিক্ষার্থী ব্যবস্থাপনার পাতায় চলুন" style="color: #F0685E;">
                  <i class="fa fa-users dashboard-icon" aria-hidden="true"></i><br/>শিক্ষার্থী ব্যবস্থাপনা
                </a><br/>
              </div>
              <div class="col-md-3 col-sm-6 col-xs-6">
                <a class="btn btn-default btn-block shadow-light" title="কাজ চলছে" style="color: #3E5E99;">
                  <i class="fa fa-graduation-cap dashboard-icon" aria-hidden="true"></i><br/>ফলাফল
                </a><br/>
              </div>
            </div>
          </div>
          <div class="col-md-12">
            <div class="row">
              <div class="col-md-3 col-sm-6 col-xs-6">
                <a class="btn btn-default btn-block shadow-light" title="কাজ চলছে">
                  <i class="fa fa-user dashboard-icon" aria-hidden="true"></i><br/>Text
                </a><br/>
              </div>
              <div class="col-md-3 col-sm-6 col-xs-6">
                <a class="btn btn-default btn-block shadow-light" title="কাজ চলছে">
                  <i class="fa fa-user dashboard-icon" aria-hidden="true"></i><br/>Text
                </a><br/>
              </div>
              <div class="col-md-3 col-sm-6 col-xs-6">
                <a class="btn btn-default btn-block shadow-light" title="কাজ চলছে">
                  <i class="fa fa-user dashboard-icon" aria-hidden="true"></i><br/>Text
                </a><br/>
              </div>
              <div class="col-md-3 col-sm-6 col-xs-6">
                <a class="btn btn-default btn-block shadow-light" title="কাজ চলছে">
                  <i class="fa fa-user dashboard-icon" aria-hidden="true"></i><br/>Text
                </a><br/>
              </div>
            </div>
          </div>
          <div class="col-md-12">
            <div class="row">
              <div class="col-md-3 col-sm-6 col-xs-6">
                <a class="btn btn-default btn-block shadow-light" title="কাজ চলছে">
                  <i class="fa fa-user dashboard-icon" aria-hidden="true"></i><br/>Text
                </a>
              </div>
              <div class="col-md-3 col-sm-6 col-xs-6">
                <a class="btn btn-default btn-block shadow-light" title="কাজ চলছে">
                  <i class="fa fa-user dashboard-icon" aria-hidden="true"></i><br/>Text
                </a>
              </div>
              <div class="col-md-3 col-sm-6 col-xs-6">
                <a class="btn btn-default btn-block shadow-light" title="কাজ চলছে">
                  <i class="fa fa-user dashboard-icon" aria-hidden="true"></i><br/>Text
                </a>
              </div>
              <div class="col-md-3 col-sm-6 col-xs-6">
                <a class="btn btn-default btn-block shadow-light" title="কাজ চলছে">
                  <i class="fa fa-user dashboard-icon" aria-hidden="true"></i><br/>Text
                </a>
              </div>
            </div>
          </div>
        </div>
        <br/><br/>
      </div>
      <div class="col-md-4">

      </div>
    </div>
  @endpermission

  @if(count(Auth::user()->roles) > 0)
    <div class="row">
      <div class="col-md-8">
        <div class="panel panel-primary">
          <div class="panel-heading">
            শিক্ষক প্রোফাইল
          </div>
          <div class="panel-body">
            <div class="row">
              <div class="col-md-8">
                <h4>
                  নামঃ {{ Auth::user()->name }}<br/>
                </h4>
                <h4>
                  বিদ্যালয়ের নামঃ {{ Auth::user()->school->name }}
                </h4>
                <h4>
                  <p style="margin-bottom: 5px;">প্রাপ্ত বিষয়সমূহঃ</p>
                  @if(count(Auth::user()->subjectallocations) > 0)
                    @foreach(Auth::user()->subjectallocations as $allocatedsubject)
                    <span>
                      {!! Form::open(array('route' => 'exam.getsubmissionpage','method'=>'POST', 'style' => 'float: left; margin-right: 5px; margin-bottom: 5px;')) !!}
                      {!! Form::hidden('user_id', Auth::user()->id) !!}
                      {!! Form::hidden('school_id', Auth::user()->school_id) !!}
                      {!! Form::hidden('exam_id', Auth::user()->exam_id) !!}
                      {!! Form::hidden('subject_id', $allocatedsubject->subject_id) !!}
                      {!! Form::hidden('class', $allocatedsubject->class) !!}
                      {!! Form::hidden('section', $allocatedsubject->section) !!}
                      <button class="btn btn-primary btn-sm" title="{{ bangla_class($allocatedsubject->class) }} {{ bangla_section(Auth::user()->school->section_type, $allocatedsubject->class, $allocatedsubject->section) }} {{ $allocatedsubject->subject->name_bangla }}-এ নম্বর প্রদান করুন">
                        {{ bangla_class($allocatedsubject->class) }}
                        {{ bangla_section(Auth::user()->school->section_type, $allocatedsubject->class, $allocatedsubject->section) }}
                        {{ $allocatedsubject->subject->name_bangla }}
                      </button>
                      {!! Form::close() !!}
                    </span>
                    @endforeach
                  @endif
                </h4>

                <br/><br/>
              </div>
              <div class="col-md-4">
                <center>
                  <img src="{{ asset('images/dummy_student.jpg') }}" class="image150 shadow">
                </center>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        
      </div>
    </div>
  @endif
@stop

@section('js')
<script type="text/javascript">
  $(function(){
   $('a[title]').tooltip();
   $('button[title]').tooltip();
  });
</script>
@stop