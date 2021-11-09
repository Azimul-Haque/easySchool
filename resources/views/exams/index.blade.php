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
      স্কুল পরীক্ষা সেটিংস
      <div class="pull-right btn-group">
          <a href="{{ route('exams.create') }}" class="btn btn-success btn-sm">নতুন পরীক্ষা যোগ করুন</a>
      </div>  
    </h1>
@stop

@section('content')
  <div class="row">
    <div class="col-md-6">
      <h4>
        চলতি পরীক্ষার নামঃ 
        <b>
          @if($currentexam != null)
            {{ exam($currentexam->name) }}-{{ bangla($currentexam->exam_session) }}
          @endif
        </b>
      </h4>
    </div>
    <div class="col-md-6"></div>
  </div>
  <div class="table-responsive">
    <table class="table" id="datatable-exams">
      <thead>
        <tr>
          <th width="10%">পরীক্ষার নাম</th>
          <th width="10%">পরীক্ষার শিক্ষাবর্ষ</th>
          <th width="10%">পরীক্ষার কোড</th>
          <th width="60%">বিষয় সমূহ</th>
          <th width="10%">কার্যকলাপ</th>
        </tr>
      </thead>
      <tbody>
      @foreach($exams as $exam)
        <tr>
          <td>
            @if($exam->currentexam == 1)
            <a href="#!" title="এই পরীক্ষাটি বিদ্যালয়ের চলতি পরীক্ষা"><i class="fa fa-check-circle" style="font-size: 20px;" aria-hidden="true"></i></a>
            @endif
            {{ exam($exam->name) }}
          </td>
          <td>{{ $exam->exam_session }}</td>
          <td>{{ $exam->exam_code }}</td>
          <td>
            @foreach($exam->examsubjects as $examsubject)
              {{ bangla_class($examsubject->class) }} {{ $examsubject->subject->name_bangla }},
            @endforeach
          </td>
          <td>
            {{-- make current exam modal--}}
            <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#makeCurrentExamModal{{ $exam->id }}" data-backdrop="static" title="এই পরীক্ষাটিকে চলতি পরীক্ষা হিসেবে নির্ধারণ করুন"><i class="fa fa-flash" aria-hidden="true"></i></button>
              <!-- Trigger the modal with a button -->
              <!-- Modal -->
              <div class="modal fade" id="makeCurrentExamModal{{ $exam->id }}" role="dialog">
                <div class="modal-dialog modal-md">
                  <div class="modal-content">
                    <div class="modal-header modal-header-success">
                      <button type="button" class="close" data-dismiss="modal">&times;</button>
                      <h4 class="modal-title">চলতি পরীক্ষা নিশ্চিতকরণ</h4>
                    </div>
                    <div class="modal-body">
                      <b>{{ exam($exam->name) }}</b>-কে চলতি পরীক্ষা করতে চান?<br/><br/>
                      <b><span style="color: #FF0000;">সতর্কীকরণঃ</span></b><br/>
                      <ul>
                        <li>চলতি পরীক্ষা করা হলে শিক্ষকেরা শুধুমাত্র এই পরীক্ষার নম্বর প্রদান করতে পারবেন</li>
                      </ul>
                    </div>
                    <div class="modal-footer">
                      {!! Form::model($exam, ['route' => ['exam.makecurrent', $exam->id], 'method' => 'PATCH']) !!}
                          <button type="submit" class="btn btn-success">নিশ্চিত করছি</button>
                          <button type="button" class="btn btn-default" data-dismiss="modal">ফিরে যান</button>
                      {!! Form::close() !!}
                    </div>
                  </div>
                </div>
              </div>
            {{-- make current exam modal--}}
            {{-- delete exam modal--}}
            <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#deleteExamModal{{ $exam->id }}" data-backdrop="static" title="এই পরীক্ষাটিকে ডিলেট করুন!"><i class="fa fa-trash" aria-hidden="true"></i></button>
              <!-- Trigger the modal with a button -->
              <!-- Modal -->
              <div class="modal fade" id="deleteExamModal{{ $exam->id }}" role="dialog">
                <div class="modal-dialog modal-md">
                  <div class="modal-content">
                    <div class="modal-header modal-header-danger">
                      <button type="button" class="close" data-dismiss="modal">&times;</button>
                      <h4 class="modal-title">পরীক্ষা ডিলেট নিশ্চিতকরণ</h4>
                    </div>
                    {!! Form::model($exam, ['route' => ['exams.destroy', $exam->id], 'method' => 'DELETE']) !!}
                    <div class="modal-body">
                      <b>{{ exam($exam->name) }}</b> পরীক্ষাটিকে নিশ্চিতভাবে ডিলেট করতে চান?<br/><br/>
                      <b><span style="color: #FF0000;">সতর্কীকরণঃ</span></b><br/>
                      <ul>
                        <li>এই পরীক্ষাটি একবার ডিলেট করা হলে এর তথ্য আর ফিরে পাওয়া যাবে না!</li>
                        <li>পরীক্ষাটি ডিলেট করা হলে পরীক্ষাটির ফলাফল তৈরি করা যাবে না</li>
                        <li>তবে পুনরায় অনুরুপ একটি পরীক্ষা তৈরি করা যাবে</li>
                      </ul><br/><br/>
                      নিশ্চায়ন প্রক্রিয়া সম্পন্ন করতে নিচের যোগফলটি ফাঁকা ঘরে ইংরেজি অংকে বসানঃ<br/>
                      @php
                        $contact_num1 = rand(1,20);
                        $contact_num2 = rand(1,20);
                        $contact_sum_result_hidden = $contact_num1 + $contact_num2;
                      @endphp
                      <input type="hidden" name="contact_sum_result_hidden" value="{{ $contact_sum_result_hidden }}">
                      <center>
                        <input type="text" name="contact_sum_result" id="" class="form-control" placeholder="{{ $contact_num1 }} + {{ $contact_num2 }} = ?" required="">
                      </center>
                    </div>
                    <div class="modal-footer">
                          <button type="submit" class="btn btn-danger" id="deleteExamModal{{ $exam->id }}"><i class="fa fa-trash" aria-hidden="true"></i> নিশ্চিত করছি</button>
                          <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times" aria-hidden="true"></i> ফিরে যান</button>
                    </div>
                    {!! Form::close() !!}
                  </div>
                </div>
              </div>
            {{-- delete exam modal--}}
          </td>
        </tr>
      @endforeach
      </tbody>
    </table>
  </div>
@stop

@section('js')
  <script type="text/javascript">
    $(function () {
      $('#datatable-exams').DataTable({
        'paging'      : true,
        'pageLength'  : 10,
        'lengthChange': true,
        'searching'   : true,
        'ordering'    : true,
        'info'        : true,
        'autoWidth'   : true,
        'order': [[ 1, "asc" ]],
         // columnDefs: [
         //    { targets: [5], type: 'date'}
         // ]
        'language': {
           "lengthMenu": "প্রতি পৃষ্ঠায় _MENU_ টি রেকর্ড প্রদর্শন করুন",
           "zeroRecords": "কোন তথ্য পাওয়া যায়নি!",
           "info": "পৃষ্ঠা নম্বরঃ _PAGE_, মোট পৃষ্ঠাঃ _PAGES_ টি",
           "infoEmpty": "তথ্য পাওয়া যায়নি",
           "infoFiltered": "(মোট _MAX_ সংখ্যক রেকর্ড থেকে খুঁজে বের করা হয়েছে)",
           "search":         "খুঁজুনঃ",
           "paginate": {
               "first":      "প্রথম পাতা",
               "last":       "শেষ পাতা",
               "next":       "পরের পাতা",
               "previous":   "আগের পাতা"
           },
        }
      })
    })
  </script>
  <script type="text/javascript">
    $(function(){
     $('a[title]').tooltip();
     $('button[title]').tooltip();
    });
  </script>
@stop