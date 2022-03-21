@extends('adminlte::page')

@section('title', 'Easy School | Collection Sector Wise')

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
    /* .from_to_date{
        padding: 5px;
        font-size: 13px;
        -moz-appearance:textfield; /* Firefox */
    .table>tbody>tr>td {
      padding: 4px;
    }
    }  */
  </style>
@stop

@section('content_header')
    <h1>
        খাতওয়ারী আদায় <span style="color: #008000;">[শিক্ষাবর্ষঃ {{ bangla($sessionsearch) }}, শ্রেণিঃ {{ bangla_class($classsearch) }}, শাখাঃ @if($sectionsearch != 'null') {{ bangla_section(Auth::user()->school->section_type, $classsearch, $sectionsearch) }} @else সকল @endif]</span>
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
      <div class="col-md-3">
          <div class="row">
            <div class="col-md-6">
                <select class="form-control" id="search_class">
                    <option selected="" disabled="" value="">শ্রেণি নির্ধারণ করুন</option>
                    <option value="All_Classes" @if($classsearch == 'All_Classes') selected="" @endif>সকল শ্রেণি</option>
                    @php
                        $classes = explode(',', Auth::user()->school->classes);
                    @endphp
                    @foreach($classes as $class)
                    <option value="{{ $class }}" @if($classsearch == $class) selected="" @endif>Class {{ $class }}</option>
                    @endforeach
                </select>
            </div>
            @if(Auth::user()->school->sections > 0)
              <div class="col-md-6" id="search_section_div">
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
          </div>
      </div>
      <div class="col-md-4">
        <div class="row">
            <div class="col-md-4">
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
            <div class="col-md-4">
                <input class="form-control" type="text" name="from_date" id="from_date" @if($fromdatesearch) value="{{ date('d-M-Y', strtotime($fromdatesearch)) }}" @endif placeholder="হতে" readonly required>
            </div>
            <div class="col-md-4">
                <input class="form-control" type="text" name="to_date" id="to_date" @if($todatesearch) value="{{ date('d-M-Y', strtotime($todatesearch)) }}" @endif placeholder="পর্যন্ত" readonly required>
            </div>
        </div>
      </div>
      <div class="col-md-5">
        <div class="row">
            <div class="col-md-4">
                <select class="form-control" id="search_sector">
                    <option selected="" disabled="">খাত নির্ধারণ করুন</option>
                    <option value="admission_session_fee" @if($sectorsearch == 'admission_session_fee') selected @endif>ভর্তি ফি/সেশন চাজ</option>
                    <option value="annual_sports_cultural" @if($sectorsearch == 'annual_sports_cultural') selected @endif>বার্ষিক ক্রীড়া/সাংস্কৃ: অনুষ্ঠান</option>
                    <option value="last_year_due" @if($sectorsearch == 'last_year_due') selected @endif>গত বছরের বকেয়া</option>
                    <option value="exam_fee" @if($sectorsearch == 'exam_fee') selected @endif>পরীক্ষা ফি অর্ধবার্ষিক/বার্ষিক/নির্বাচনি/মডেল টেস্ট</option>
                    <option value="full_half_free_form" @if($sectorsearch == 'full_half_free_form') selected @endif>ফুলফ্রি/হাফফ্রি ফরম</option>
                    <option value="3_6_8_12_fee" @if($sectorsearch == '3_6_8_12_fee') selected @endif>৩/৬/৯/১২মাসের বেতন</option>
                    <option value="jsc_ssc_form_fee" @if($sectorsearch == 'jsc_ssc_form_fee') selected @endif>জেএসসি/এসএসসি রেজি:/ ফরম ফিল আপ</option>
                    <option value="certificate_fee" @if($sectorsearch == 'certificate_fee') selected @endif>প্রশংসা/প্রত্যয়ন পত্র /টিসি/ মার্কশীট /সনদ পত্র</option>
                    <option value="scout_fee" @if($sectorsearch == 'scout_fee') selected @endif>স্কাউট/গার্লস গাইড ফি</option>
                    <option value="develoment_donation" @if($sectorsearch == 'develoment_donation') selected @endif>উন্নয়ন/দান</option>
                    <option value="other_fee" @if($sectorsearch == 'other_fee') selected @endif>বিবিধ</option>
                </select>
            </div>
            <div class="col-md-8">
                <button class="btn btn-primary btn-sm" id="search_students_btn"><i class="fa fa-fw fa-search"></i> তালিকা দেখুন</button>
                @if($feecollections == true)
                <a href="{{ Request::url() . '/pdf' }}" id="downloadpdfbutton" class="btn btn-success btn-sm" style="margin-left: 10px;" id=""><i class="fa fa-fw fa-download"></i> পিডিএফ</a>
                @endif
            </div>
        </div>
          
      </div>
    </div>

    {{-- {!! Form::open(array('route' => ['collection.storecollection', $sessionsearch, $classsearch, $sectionsearch], 'method'=>'POST')) !!} --}}
    <div class="table-responsive" style="margin-top: 5px;">
        {{-- {{ Request::url() }} --}}
        @if($feecollections == true)
        <table class="table table-bordered" id="">
            {{-- datatable-students --}}
            <thead>
                <tr>
                    {{-- <th class="hiddenCheckbox" id="hiddenCheckbox"></th> --}}
                    <th>ক্রঃ নঃ</th>
                    <th width="7%">তারিখ</th>
                    <th width="5%">রোল</th>
                    <th>আইডি</th>
                    <th width="15%">নাম</th>
                    <th>{{ collection_sector_bangla($sectorsearch) }}</th>
                </tr>
            </thead>
            <tbody>
              @php
                $count_key = 0;
                $collectiongroup = [];
                foreach ($usedstudentids as $studentid) {
                  foreach ($feecollections as $collection) {
                    if($studentid->student_id == $collection->student_id && $studentid->collection_date == $collection->collection_date) {
                      $collectiongroup[$studentid->collection_date][$studentid->student_id][] = $collection;
                    }
                  } 
                }
                $total_attribute_fee = 0;
                // dd($collectiongroup);
              @endphp
              @foreach ($collectiongroup as $datekey => $datecollections)
                @foreach ($datecollections as $studentidkey => $studentidcollections)
                  <tr>
                    <td>{{ $count_key = $count_key + 1 }}</td>
                    <td>{{ date('d-m-y', strtotime($datekey)) }}</td>
                    <td>{{ $studentidcollections[0]->roll }} @if($classsearch == 'All_Classes') ({{ $studentidcollections[0]->class }}{{ english_section_short(Auth::user()->school->section_type, $studentidcollections[0]->class, $studentidcollections[0]->section) }}) @endif</td>
                    <td>{{ $studentidkey }}</td>
                    <td>{{ $studentidcollections[0]->student->name }}</td>
                    <td align="center">
                        @php
                            $total_single_student_attribute_fee = 0;
                        @endphp
                      @foreach ($studentidcollections as $collection)
                        @php
                            $total_single_student_attribute_fee = $total_single_student_attribute_fee + $collection->fee_value;
                            $total_attribute_fee = $total_attribute_fee + $collection->fee_value;
                        @endphp
                      @endforeach
                      {{ $total_single_student_attribute_fee }}
                    </td>
                  </tr>                
                @endforeach            
              @endforeach            
            </tbody>
            <tfoot>
              <tr>
                <td colspan="5" align="right">মোট (৳)</td>
                <th>{{ $total_attribute_fee }}</th>
              </tr>
            </tfoot>
        </table>
        @endif
    </div>    
  {{-- {!! Form::close() !!} --}}
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
    $("#from_date").datepicker({
      format: 'dd-M-yyyy',
      todayHighlight: true,
      autoclose: true,
    });
    $("#to_date").datepicker({
      format: 'dd-M-yyyy',
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
            if($('#search_class').val() && $('#search_session').val() && $('#from_date').val() && $('#to_date').val() && $('#search_sector').val()) 
            {
              if($('#search_class').val() == "All_Classes") {
                window.location.href = window.location.protocol + "//" + window.location.host + "/collection/sector/wise/"+$('#search_session').val()+"/"+$('#search_class').val()+"/"+$('#search_section').val()+"/"+$('#from_date').val()+"/"+$('#to_date').val()+"/"+$('#search_sector').val();
              } else {
                if($('#search_session').val()) {
                  window.location.href = window.location.protocol + "//" + window.location.host + "/collection/sector/wise/"+$('#search_session').val()+"/"+$('#search_class').val()+"/"+$('#search_section').val()+"/"+$('#from_date').val()+"/"+$('#to_date').val()+"/"+$('#search_sector').val();
                } else {
                  toastr.warning('শ্রেণি, শাখা, শিক্ষাবর্ষ, তারিখ ও খাতসহ সবগুলো সিলেক্ট করুন!');
                }
              }
            } else {
                toastr.warning('শ্রেণি, শাখা, শিক্ষাবর্ষ, তারিখ ও খাতসহ সবগুলো সিলেক্ট করুন!');
            }
        @else
          window.location.href = window.location.protocol + "//" + window.location.host + "/collection/sector/wise/"+$('#search_session').val()+"/"+$('#search_class').val()+"/No_Section/"+$('#from_date').val()+"/"+$('#to_date').val()+"/"+$('#search_sector').val();
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

    if($('#search_class').val() == 'All_Classes') {
      // All_Classes Case
      // All_Classes Case
      $('#search_section_div').hide();
    } else if($('#search_class').val() < 9) {
      $('#search_section_div').show();
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
      $('#search_section_div').show();
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
  $('#search_sector').on('change', function() {
    $('#downloadpdfbutton').hide();
  });
</script>
@stop