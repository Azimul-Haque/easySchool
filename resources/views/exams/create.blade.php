@extends('adminlte::page')

@section('title', 'Exam Settings | Easy School')

@section('css')
  <style type="text/css">
    .hiddenCheckbox, .hiddenFinalSaveBtn {
      display:none;
    }
  </style>
  {!!Html::style('css/bootstrap-datepicker.min.css')!!}
@stop

@section('content_header')
    <h1>
      নতুন পরীক্ষা যোগ করুন
      <div class="pull-right btn-group">
          
      </div>  
    </h1>
@stop

@section('content')
  {!! Form::open(array('route' => 'exams.store','method'=>'POST')) !!}
  <div class="row">
      <div class="col-md-12">
          <div class="well">
              <div class="row">
                  <div class="col-md-3">
                    <div class="form-group">
                      <strong>পরীক্ষার নাম</strong>
                      <select class="form-control" name="name" required="">
                        <option value="" selected disabled>পরীক্ষার নাম নির্ধারণ করুন</option>
                        <option value="first_term">প্রথম সাময়িক (First Term)</option>
                        <option value="second_term">দ্বিতীয় সাময়িক (Second Term)</option>
                        <option value="halfyearly">অর্ধবার্ষিক (Halfyearly)</option>
                        <option value="final">বার্ষিক (Final)</option>
                        <option value="first_term_preparation">প্রথম সাময়িক পূর্ব প্রস্তুতি (First Term Preparation)</option>
                        <option value="second_term_preparation">দ্বিতীয় সাময়িক পূর্ব প্রস্তুতি (Second Term Preparation)</option>
                        <option value="final_preparation">বার্ষিক পূর্ব প্রস্তুতি (Final Preparation)</option>
                        <option value="model_test">মডেল টেস্ট (Model Test)</option>
                        <option value="pre_test">প্রাক-নির্বাচনী (Pre-Test)</option>
                        <option value="test_exam">নির্বাচনী (Test)</option>
                      </select>
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="form-group">
                      <strong>পরীক্ষার শিক্ষাবর্ষ</strong>
                      <select class="form-control" name="exam_session" required="">
                        <option value="" selected disabled>শিক্ষাবর্ষ নির্ধারণ করুন</option>
                        @php
                          $y = date('Y')-2;
                          for($y; $y<=2038; $y++) {
                        @endphp
                          <option value="{{ $y }}" @if(date('Y') == $y) selected @endif>{{ $y }}</option>
                        @php
                          }
                        @endphp
                      </select>
                    </div>
                  </div>
                  <div class="col-md-3">
                      <div class="form-group">
                        <strong>পরীক্ষা শুরুর তারিখ</strong>
                        {!! Form::text('exam_start_date', null, array('placeholder' => 'পরীক্ষা শুরু','class' => 'form-control', 'required' => '', 'id' => 'exam_start_date', 'autocomplete' => 'off')) !!}
                      </div>
                  </div>
                  <div class="col-md-3">
                      <div class="form-group">
                        <strong>পরীক্ষা শেষের তারিখ</strong>
                        {!! Form::text('exam_end_date', null, array('placeholder' => 'পরীক্ষা শেষ','class' => 'form-control', 'required' => '', 'id' => 'exam_end_date', 'autocomplete' => 'off')) !!}
                      </div>
                  </div>
              </div>
              
              <div class="row">
                @php
                  $classes = explode(',', Auth::user()->school->classes);
                  $classcounter = 1;
                @endphp
                @foreach($classes as $class)
                <div class="col-md-3">
                  <div class="box box-success box-custom">
                    <div class="box-header with-border text-green">
                      <i class="fa fa-check-circle"></i>
                      <h3 class="box-title">{{ bangla_class($class) }} শ্রেণি</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                      <div class="form-group">
                        <strong>{{ bangla_class($class) }} শ্রেণির মোট বিষয় সংখ্যা <a href="#!" title="যেমনঃ বাংলা ১ম ও ২য় মিলে ১টি বিষয় বুঝাবে, এ হিসেবে মোট বিষয় সংখ্যা"><i class="fa fa-question-circle"></i></a></strong>
                        {!! Form::number('total_subjects_'.$class, null, array('placeholder' => 'শ্রেণির মোট বিষয় সংখ্যা','class' => 'form-control', 'id' => 'total_subjects_'.$class)) !!}
                      </div>
                      <div id="subjectfieldscontainer{{ $class }}"></div>
                      <button type="button" class="btn btn-success btn-sm btn-block" id="addSubject{{ $class }}">
                        <i class="fa fa-plus"></i> বিষয় যোগ করুন
                      </button>
                    </div>
                    <!-- /.box-body -->
                  </div>
                </div>

                @php
                  if($classcounter % 4 == 0) {
                    echo '</div><div class="row">';
                  }
                  $classcounter++;
                @endphp
                @endforeach
              </div>
              <button type="submit" class="btn btn-primary btn-block">Submit</button>
          </div>
      </div>
  </div>
  {!! Form::close() !!}
@stop

@section('js')
  <script type="text/javascript">
    $(function(){
     $('a[title]').tooltip();
     $('button[title]').tooltip();
    });
  </script>
  {!!Html::script('js/bootstrap-datepicker.min.js')!!}
  <script type="text/javascript">
      $(function() {
        $("#exam_start_date").datepicker({
          format: 'MM dd, yyyy',
          todayHighlight: true,
          autoclose: true
        });
        $("#exam_end_date").datepicker({
          format: 'MM dd, yyyy',
          todayHighlight: true,
          autoclose: true
        });
      });
  </script>
  <script type="text/javascript">
    var htlmFields = '';
    @foreach($classes as $class)
    var classcounter{{ $class + 1 }} = 1;
    $("#addSubject{{ $class }}").click(function() {
        htlmFields += '<div id="subject_{{ $class }}_'+classcounter{{ $class + 1 }}+'" class="exam_subject_add">';

        htlmFields += '  <button type="button" class="btn btn-danger btn-xs pull-right marginbottom10" onclick="removeSubject(subject_{{ $class }}_'+classcounter{{ $class + 1 }}+', {{ $class }})"><i class="fa fa-trash"></i> মুছে দিন</button>';
        htlmFields += '  <div class="form-group">';
        htlmFields += '   <select id="subject_id_{{ $class }}_'+classcounter{{ $class + 1 }}+'" onchange="onchageSelect(this, {{ $class }}, '+classcounter{{ $class + 1 }}+')" class="form-control">';
        htlmFields += '      <option value="" selected="" disabled="">বিষয় নির্ধারণ করুন</option>';
        @foreach($subjects as $subject)
        htlmFields += '      <option value="{{ $subject->id }}">{{ $subject->name_bangla }} ({{ $subject->name_english }})</option>';
        @endforeach
        htlmFields += '    </select>';
        htlmFields += '  </div>';

        htlmFields += '  <div class="form-group">';
        htlmFields += '   <input type="number" id="written_{{ $class }}_'+classcounter{{ $class + 1 }}+'" class="form-control" placeholder="লিখিত মার্ক (ইংরেজি সংখ্যায়)">';
        htlmFields += '  </div>';

        htlmFields += '  <div class="form-group">';
        htlmFields += '   <input type="number" id="written_pass_mark_{{ $class }}_'+classcounter{{ $class + 1 }}+'" class="form-control" placeholder="লিখিত পাশ মার্ক (ইংরেজি সংখ্যায়)">';
        htlmFields += '  </div>';

        htlmFields += '  <div class="form-group">';
        htlmFields += '   <input type="number" id="mcq_{{ $class }}_'+classcounter{{ $class + 1 }}+'" class="form-control" placeholder="এমসিকিউ মার্ক (ইংরেজি সংখ্যায়)">';
        htlmFields += '  </div>';

        htlmFields += '  <div class="form-group">';
        htlmFields += '   <input type="number" id="mcq_pass_mark_{{ $class }}_'+classcounter{{ $class + 1 }}+'" class="form-control" placeholder="এমসিকিউ পাশ মার্ক (ইংরেজি সংখ্যায়)">';
        htlmFields += '  </div>';

        htlmFields += '  <div class="form-group">';
        htlmFields += '   <input type="number" id="practical_{{ $class }}_'+classcounter{{ $class + 1 }}+'" class="form-control" placeholder="প্র্যাক্টিক্যাল মার্ক (ইংরেজি সংখ্যায়)">';
        htlmFields += '  </div>';

        htlmFields += '  <div class="form-group">';
        htlmFields += '   <input type="number" id="practical_pass_mark_{{ $class }}_'+classcounter{{ $class + 1 }}+'" class="form-control" placeholder="প্র্যাক্টিক্যাল পাশ মার্ক (ইংরেজি সংখ্যায়)">';
        htlmFields += '  </div>';

        htlmFields += '  <div class="form-group">';
        htlmFields += '   <input type="number" id="total_percentage_{{ $class }}_'+classcounter{{ $class + 1 }}+'" class="form-control" placeholder="প্রাপ্ত মার্কের পারসেন্টেজ (ইংরেজি সংখ্যায়)">';
        htlmFields += '  </div>';

        htlmFields += '  <div class="form-group">';
        htlmFields += '   <input type="number" id="ca_{{ $class }}_'+classcounter{{ $class + 1 }}+'" class="form-control" placeholder="সিএ/ এসবিএ মার্ক (ইংরেজি সংখ্যায়)">';
        htlmFields += '  </div>';

        htlmFields += '  <div class="form-group">';
        htlmFields += '   <input type="number" id="total_{{ $class }}_'+classcounter{{ $class + 1 }}+'" class="form-control" placeholder="সর্বমোট মার্ক (ইংরেজি সংখ্যায়)">';
        htlmFields += '  </div>';

        htlmFields += '  <div class="form-group">';
        htlmFields += '   <input type="number" id="pass_mark_{{ $class }}_'+classcounter{{ $class + 1 }}+'" class="form-control" placeholder="সর্বমোট পাশ মার্ক (ইংরেজি সংখ্যায়)">';
        htlmFields += '  </div>';

        htlmFields += '</div>';
        $("#subjectfieldscontainer{{ $class }}").append(htlmFields);
        $("#total_subjects_{{ $class }}").attr('required', true);
        htlmFields = '';
        classcounter{{ $class + 1 }}++;
    });
    @endforeach

    function removeSubject(idofsubject, classtoremove) {
      console.log(idofsubject);
      $(idofsubject).remove();
      $("#total_subjects_"+classtoremove).removeAttr('required');
    }

    function onchageSelect(subject_id, subject_class, subject_counter) {
      var subject_id = $(subject_id).val();
      $('#subject_id_'+subject_class+'_'+subject_counter).attr('name', 'subject_id_'+subject_class+'_'+subject_id);
      $('#written_'+subject_class+'_'+subject_counter).attr('name', 'written_'+subject_class+'_'+subject_id);
      $('#written_pass_mark_'+subject_class+'_'+subject_counter).attr('name', 'written_pass_mark_'+subject_class+'_'+subject_id);
      $('#mcq_'+subject_class+'_'+subject_counter).attr('name', 'mcq_'+subject_class+'_'+subject_id);
      $('#mcq_pass_mark_'+subject_class+'_'+subject_counter).attr('name', 'mcq_pass_mark_'+subject_class+'_'+subject_id);
      $('#practical_'+subject_class+'_'+subject_counter).attr('name', 'practical_'+subject_class+'_'+subject_id);
      $('#practical_pass_mark_'+subject_class+'_'+subject_counter).attr('name', 'practical_pass_mark_'+subject_class+'_'+subject_id);
      $('#total_percentage_'+subject_class+'_'+subject_counter).attr('name', 'total_percentage_'+subject_class+'_'+subject_id);
      $('#ca_'+subject_class+'_'+subject_counter).attr('name', 'ca_'+subject_class+'_'+subject_id);
      $('#total_'+subject_class+'_'+subject_counter).attr('name', 'total_'+subject_class+'_'+subject_id);
      $('#pass_mark_'+subject_class+'_'+subject_counter).attr('name', 'pass_mark_'+subject_class+'_'+subject_id);
    }
  </script>

@stop