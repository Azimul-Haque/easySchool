@extends('adminlte::page')

@section('title', 'Easy School | Collection List')

@section('css')
  <link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap-datepicker.min.css') }}">
  <style type="text/css">
    .hiddenCheckbox, .hiddenFinalSaveBtn {
      display:none;
    }
    input::-webkit-outer-spin-button,
    input::-webkit-inner-spin-button {
        /* display: none; <- Crashes Chrome on hover */
        -webkit-appearance: none;
        margin: 0; /* <-- Apparently some margin are still there even though it's hidden */
    }
    input[type=number]{
        width: 45px;
        padding: 5px;
        -moz-appearance:textfield; /* Firefox */
    } 
  </style>
@stop

@section('content_header')
    <h1>
        আদায় তালিকা <span style="color: #008000;">[শিক্ষাবর্ষঃ {{ bangla($sessionsearch) }}, শ্রেণিঃ {{ bangla_class($classsearch) }}, শাখাঃ {{ bangla_section(Auth::user()->school->section_type, $classsearch, $sectionsearch) }}]</span>
        <div class="pull-right btn-group"></div>	
    </h1>
@stop

@section('content')
  @permission('student-crud')
    {{-- @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif --}}
    <div class="row">
      <div class="col-md-2">
          <select class="form-control" id="search_class">
              <option selected="" disabled="" value="">শ্রেণি নির্ধারণ করুন</option>
              @php
                  $classes = explode(',', Auth::user()->school->classes);
              @endphp
              @foreach($classes as $class)
              <option value="{{ $class }}" @if($classsearch == $class) selected="" @endif>Class {{ $class }}</option>
              @endforeach
          </select>
      </div>
      @if(Auth::user()->school->sections > 0)
        <div class="col-md-2">
            <select class="form-control" id="search_section">
                <option selected="" disabled="" value="">সেকশন নির্ধারণ করুন</option>
                @if($classsearch < 9)
                        <option value="1" @if($sectionsearch == 1) selected="" @endif>A</option>
                        <option value="2" @if($sectionsearch == 2) selected="" @endif>B</option>
                    @if(Auth::user()->school->sections == 3)
                        <option value="3" @if($sectionsearch == 3) selected="" @endif>C</option>
                    @endif
                @else
                    @if(Auth::user()->school->section_type == 1)
                        <option value="1" @if($sectionsearch == 1) selected="" @endif>A</option>
                        <option value="2" @if($sectionsearch == 2) selected="" @endif>B</option>
                        @if(Auth::user()->school->sections >2)
                            <option value="3" @if($sectionsearch == 3) selected="" @endif>C</option>
                        @endif
                    @elseif(Auth::user()->school->section_type == 2)
                            <option value="1" @if($sectionsearch == 1) selected="" @endif>SCIENCE</option>
                            <option value="2" @if($sectionsearch == 2) selected="" @endif>ARTS</option>
                        @if(Auth::user()->school->sections >2)
                            <option value="3" @if($sectionsearch == 3) selected="" @endif>COMMERCE</option>
                            <option value="4" @if($sectionsearch == 4) selected="" @endif>VOCATIONAL</option>
                            <option value="5" @if($sectionsearch == 5) selected="" @endif>TECHNICAL</option>
                        @endif
                    @endif
                @endif
            </select>
        </div>
      @endif
      <div class="col-md-2">
          <select class="form-control" id="search_session">
              <option selected="" disabled="">শিক্ষাবর্ষ নির্ধারণ করুন</option>
              @for($optionyear = (date('Y')+1) ; $optionyear>=(Auth::user()->school->established); $optionyear--)
              <option value="{{ $optionyear }}" 
              @if($sessionsearch == null)
                  @if($optionyear == date('Y')) selected="" @endif
              @else
                  @if($sessionsearch == $optionyear) selected="" @endif
              @endif
              >{{ $optionyear }}</option>
              @endfor
          </select>
      </div>
      <div class="col-md-2">
          <button class="btn btn-primary btn-sm" id="search_students_btn"><i class="fa fa-fw fa-search"></i> শিক্ষার্থী তালিকা</button>
      </div>
    </div>

    {!! Form::open(array('route' => ['collection.storecollection', $sessionsearch, $classsearch, $sectionsearch], 'method'=>'POST')) !!}
    <div class="table-responsive" style="margin-top: 5px;">
        @if($students == true)
        <table class="table" id="">
            {{-- datatable-students --}}
            <thead>
                <tr>
                    {{-- <th class="hiddenCheckbox" id="hiddenCheckbox"></th> --}}
                    <th>ক্রঃ নঃ</th>
                    <th>রোল</th>
                    <th>আইডি</th>
                    <th width="20%">নাম</th>
                    <th>ভর্তি ফি /সেশন চাজ</th>
                    <th>বার্ষিক ক্রীড়া/ সাংস্কৃ: অনুষ্ঠান</th>
                    <th>গত বছরের বকেয়া</th>
                    <th>পরীক্ষা ফি অর্ধবার্ষিক/ বার্ষিক/নির্বাচনি/মডেল টেস্ট</th>
                    <th>ফুলফ্রি/ হাফফ্রি ফরম</th>
                    <th>৩/৬/৯/১২ মাসের বেতন	</th>
                    <th>জেএসসি/ এসএসসি রেজি:/ ফরম ফিল আপ</th>
                    <th>প্রশংসা/ প্রত্যয়ন পত্র /টিসি/ মার্কশীট /সনদ পত্র</th>
                    <th>স্কাউট/ গার্লস গাইড ফি</th>
                    <th>উন্নয়ন/ দান</th>
                    <th>বিবিধ</th>
                </tr>
            </thead>
            <tbody>
            @foreach ($students as $key => $student)
                <tr>
                    {{-- <td class="hiddenCheckbox" id="hiddenCheckbox"><input type="checkbox" name="student_check_ids[]" value="{{ $student->id }}"></td> --}}
                    <td>
                      {{ $key + 1 }}
                      {!! Form::hidden('student_id'.$student->student_id, $student->student_id) !!}
                    </td>
                    <td>{{ $student->roll }}</td>
                    <td>{{ $student->student_id }}</td>
                    <td>{{ $student->name }}</td>
                    <td><center><input type="number" name="admission_session_fee{{ $student->student_id }}" class="form-control" min="0" step="any"></center></td>
                    <td><center><input type="number" name="annual_sports_cultural{{ $student->student_id }}" class="form-control" min="0" step="any"></center></td>
                    <td><center><input type="number" name="last_year_due{{ $student->student_id }}" class="form-control" min="0" step="any"></center></td>
                    <td><center><input type="number" name="exam_fee{{ $student->student_id }}" class="form-control" min="0" step="any"></center></td>
                    <td><center><input type="number" name="full_half_free_form{{ $student->student_id }}" class="form-control" min="0" step="any"></center></td>
                    <td><center><input type="number" name="3_6_8_12_fee{{ $student->student_id }}" class="form-control" min="0" step="any"></center></td>
                    <td><center><input type="number" name="jsc_ssc_form_fee{{ $student->student_id }}" class="form-control" min="0" step="any"></center></td>
                    <td><center><input type="number" name="certificate_fee{{ $student->student_id }}" class="form-control" min="0" step="any"></center></td>
                    <td><center><input type="number" name="scout_fee{{ $student->student_id }}" class="form-control" min="0" step="any"></center></td>
                    <td><center><input type="number" name="develoment_donation{{ $student->student_id }}" class="form-control" min="0" step="any"></center></td>
                    <td><center><input type="number" name="other_fee{{ $student->student_id }}" class="form-control" min="0" step="any"></center></td>
                </tr>
            @endforeach
            </tbody>
        </table>
        @endif
    </div>
    
    @if(!empty($students))
    <div class="row">
      <div class="col-md-2">
        <input class="form-control" type="text" name="collection_date" id="collection_date" value="" placeholder="আদায়ের তারিখ" readonly required>
      </div>
      <div class="col-md-2">
          <select name="collector" id="collector" class="form-control" required>
            <option value="" selected disabled>আদায়কারী নির্বাচন করুন</option>
            @foreach ($teachers as $teacher)
            <option value="{{ $teacher->name }}">{{ $teacher->name }}</option>
            @endforeach
          </select>
      </div>
      <div class="col-md-2">
        <button class="btn btn-success" type="button" data-toggle="modal" data-target="#saveButtonModal" data-backdrop="static">দাখিল করুন</button>
        <!-- Trigger the modal with a button -->
        <!-- Modal -->
        <div class="modal fade" id="saveButtonModal" role="dialog">
          <div class="modal-dialog modal-md">
            <div class="modal-content">
              <div class="modal-header modal-header-success">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">ফি আদায় দাখিলকরণ</h4>
              </div>
        
              <div class="modal-body">
                আপনি কি নিশ্চিতভাবে আদায়কৃত ফিসমূহ সংরক্ষণ করতে চান?
              </div>
              <div class="modal-footer">
                <button type="submit" class="btn btn-success">দাখিল করুন</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">বন্ধ করুন</button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    @endif
    
  {!! Form::close() !!}
  @endpermission
@stop

@section('js')
<script type="text/javascript" src="{{ asset('js/bootstrap-datepicker.min.js') }}"></script>
<script type="text/javascript">
  $(function(){
   $('a[title]').tooltip();
   $('button[title]').tooltip();
  });
</script>
<script type="text/javascript">
  $(function() {
    $("#collection_date").datepicker({
      format: 'MM dd, yyyy',
      todayHighlight: true,
      autoclose: true,
    });
  });
</script>
<script type="text/javascript">
    $(function () {
      $('#example1').DataTable()
      $('#datatable-students').DataTable({
        'paging'      : true,
        'pageLength'  : 100,
        'lengthChange': true,
        'searching'   : true,
        'ordering'    : true,
        'info'        : true,
        'autoWidth'   : true,
        'order': [[ 4, "asc" ]],
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
      $(document).ready(function() {
        $('#search_students_btn').click(function() {
        @if(Auth::user()->school->sections > 0)
            if($('#search_class').val() && $('#search_section').val() && $('#search_session').val()) {
  		  		
            window.location.href = window.location.protocol + "//" + window.location.host + "/collection/input/form/"+$('#search_session').val()+"/"+$('#search_class').val()+"/"+$('#search_section').val();
            } else {
                toastr.warning('শ্রেণি, শাখা এবং শিক্ষাবর্ষ সবগুলো সিলেক্ট করুন!');
            }
        @else
          window.location.href = window.location.protocol + "//" + window.location.host + "/collection/input/form/"+$('#search_session').val()+"/"+$('#search_class').val()+"/No_Section";
        @endif
        })

        $('#showCheckbox').click(function() {
            $('td:nth-child(1)').toggleClass('hiddenCheckbox');
            $('th:nth-child(1)').toggleClass('hiddenCheckbox');
            $('#hiddenFinalSaveBtn').toggleClass('hiddenFinalSaveBtn');
        });
        $('#hiddenFinalSaveBtn').click(function() {
            var checked = [];
                $("input[name='student_check_ids[]']:checked").each(function ()
                {
                    checked.push($(this).val());
                });
                $('#student_ids').val(checked);
                if($('#student_ids').val() == '') {
                    toastr.warning('অন্তত একজন শিক্ষার্থী নির্বাচন করুন!', 'Warning').css('width','400px');
					
                    setTimeout(function() {
            $('#promoteModal').modal('hide');
          }, 1000);
                }
                console.log(checked);
        });

      })
</script>
<script type="text/javascript">
  $('#search_class').on('change', function() {
    $('#search_section').prop('disabled', true);
    $('#search_section').append('<option value="" selected disabled>লোড হচ্ছে...</option>');

    if($('#search_class').val() < 9) {
      $('#search_section')
            .find('option')
            .remove()
            .end()
            .prop('disabled', false)
            .append('<option value="" selected disabled>শাখা নির্ধারণ করুন</option>');

      $('#search_section').append('<option value="'+1+'">A</option>');
      $('#search_section').append('<option value="'+2+'">B</option>');
      $('#search_section').append('<option value="'+3+'">C</option>');
    } else {
      $('#search_section')
            .find('option')
            .remove()
            .end()
            .prop('disabled', false)
            .append('<option value="" selected disabled>শাখা নির্ধারণ করুন</option>');

      @if(Auth::user()->school->section_type == 1)
        $('#search_section').append('<option value="'+1+'">A</option>');
        $('#search_section').append('<option value="'+2+'">B</option>');
        $('#search_section').append('<option value="'+3+'">C</option>');
      @elseif(Auth::user()->school->section_type == 2)
        $('#search_section').append('<option value="'+1+'">SCIENCE</option>');
        $('#search_section').append('<option value="'+2+'">ARTS</option>');
        $('#search_section').append('<option value="'+3+'">COMMERCE</option>');
        $('#search_section').append('<option value="'+4+'">VOCATIONAL</option>');
        $('#search_section').append('<option value="'+5+'">TECHNICAL</option>');
      @endif
    }
  });
</script>
@stop