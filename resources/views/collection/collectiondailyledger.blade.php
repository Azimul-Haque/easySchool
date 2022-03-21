@extends('adminlte::page')

@section('title', 'Easy School | Collection Daily Ledger')

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
        দৈনিক খতিয়ান <span style="color: #008000;">@if($fromdatesearch)({{ bangla(date('F d, Y', strtotime($fromdatesearch))) }} - {{ bangla(date('F d, Y', strtotime($todatesearch))) }})@endif</span>
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
            <input class="form-control" type="text" name="from_date" id="from_date" @if($fromdatesearch) value="{{ date('d-M-Y', strtotime($fromdatesearch)) }}" @endif placeholder="হতে" readonly required>
          </div>
          <div class="col-md-6">
            <input class="form-control" type="text" name="to_date" id="to_date" @if($todatesearch) value="{{ date('d-M-Y', strtotime($todatesearch)) }}" @endif placeholder="পর্যন্ত" readonly required>
          </div>
        </div>
      </div>
      <div class="col-md-3">
          <button class="btn btn-primary btn-sm" id="search_students_btn"><i class="fa fa-fw fa-search"></i> তালিকা দেখুন</button>
          @if($feecollections == true)
            <a href="{{ Request::url() . '/pdf' }}" class="btn btn-success btn-sm" style="margin-left: 10px;" id=""><i class="fa fa-fw fa-download"></i> পিডিএফ</a>
          @endif
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
                    <th width="5%">শ্রেণি</th>
                    <th>শাখা</th>
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
                    <th width="5%">মোট (৳)</th>
                </tr>
            </thead>
            <tbody>
              @php
                $count_key = 0;
                $collectiongroup = [];
                foreach ($usedstudentids as $studentid) {
                  foreach ($feecollections as $collection) {
                    if($studentid->collection_date == $collection->collection_date && $studentid->class == $collection->class && $studentid->section == $collection->section) {
                      $collectiongroup[$studentid->collection_date][$studentid->class][$studentid->section][] = $collection;
                    }
                  } 
                }
                $total_admission_session_fee = 0;
                $total_annual_sports_cultural = 0;
                $total_last_year_due = 0;
                $total_exam_fee = 0;
                $total_full_half_free_form = 0;
                $total_3_6_8_12_fee = 0;
                $total_jsc_ssc_form_fee = 0;
                $total_certificate_fee = 0;
                $total_scout_fee = 0;
                $total_develoment_donation = 0;
                $total_other_fee = 0;
                // dd($collectiongroup);
              @endphp
              @foreach ($collectiongroup as $datekey => $datecollections)
                @foreach ($datecollections as $classkey => $classcollections)
                    @foreach ($classcollections as $sectionkey => $sectioncollections)
                        @php
                            $total_single_section_fee = 0;
                        @endphp
                        <tr>
                            <td>{{ $count_key = $count_key + 1 }}</td>
                            <td>{{ date('d-m-y', strtotime($datekey)) }}</td>
                            <td>{{ $sectioncollections[0]->class }}</td>
                            <td>{{ english_section_short(Auth::user()->school->section_type, $sectioncollections[0]->class, $sectioncollections[0]->section) }}</td>
                            <td align="center">
                                @php
                                    $total_single_section_single_sector_fee = 0;
                                @endphp
                                @foreach ($sectioncollections as $collection)
                                    @if ($collection->fee_attribute == 'admission_session_fee')
                                        @php
                                            $total_single_section_single_sector_fee = $total_single_section_single_sector_fee + $collection->fee_value;
                                            $total_single_section_fee = $total_single_section_fee + $collection->fee_value;
                                            $total_admission_session_fee = $total_admission_session_fee + $collection->fee_value;
                                        @endphp
                                    @endif
                                @endforeach
                                {{ $total_single_section_single_sector_fee == 0 ? '' : $total_single_section_single_sector_fee }}
                            </td>
                            <td>
                                @php
                                    $total_single_section_single_sector_fee = 0;
                                @endphp
                                @foreach ($sectioncollections as $collection)
                                    @if ($collection->fee_attribute == 'annual_sports_cultural')
                                        @php
                                            $total_single_section_single_sector_fee = $total_single_section_single_sector_fee + $collection->fee_value;
                                            $total_single_section_fee = $total_single_section_fee + $collection->fee_value;
                                            $total_annual_sports_cultural = $total_annual_sports_cultural + $collection->fee_value;
                                        @endphp
                                    @endif
                                @endforeach
                                {{ $total_single_section_single_sector_fee == 0 ? '' : $total_single_section_single_sector_fee }}
                            </td>
                            <td>
                                @php
                                    $total_single_section_single_sector_fee = 0;
                                @endphp
                                @foreach ($sectioncollections as $collection)
                                    @if ($collection->fee_attribute == 'last_year_due')
                                        @php
                                            $total_single_section_single_sector_fee = $total_single_section_single_sector_fee + $collection->fee_value;
                                            $total_single_section_fee = $total_single_section_fee + $collection->fee_value;
                                            $total_last_year_due = $total_last_year_due + $collection->fee_value;
                                        @endphp
                                    @endif
                                @endforeach
                                {{ $total_single_section_single_sector_fee == 0 ? '' : $total_single_section_single_sector_fee }}
                            </td>
                            <td>
                                @php
                                    $total_single_section_single_sector_fee = 0;
                                @endphp
                                @foreach ($sectioncollections as $collection)
                                    @if ($collection->fee_attribute == 'exam_fee')
                                        @php
                                            $total_single_section_single_sector_fee = $total_single_section_single_sector_fee + $collection->fee_value;
                                            $total_single_section_fee = $total_single_section_fee + $collection->fee_value;
                                            $total_exam_fee = $total_exam_fee + $collection->fee_value;
                                        @endphp
                                    @endif
                                @endforeach
                                {{ $total_single_section_single_sector_fee == 0 ? '' : $total_single_section_single_sector_fee }}
                            </td>
                            <td>
                                @php
                                    $total_single_section_single_sector_fee = 0;
                                @endphp
                                @foreach ($sectioncollections as $collection)
                                    @if ($collection->fee_attribute == 'full_half_free_form')
                                        @php
                                            $total_single_section_single_sector_fee = $total_single_section_single_sector_fee + $collection->fee_value;
                                            $total_single_section_fee = $total_single_section_fee + $collection->fee_value;
                                            $total_full_half_free_form = $total_full_half_free_form + $collection->fee_value;
                                        @endphp
                                    @endif
                                @endforeach
                                {{ $total_single_section_single_sector_fee == 0 ? '' : $total_single_section_single_sector_fee }}
                            </td>
                            <td>
                                @php
                                    $total_single_section_single_sector_fee = 0;
                                @endphp
                                @foreach ($sectioncollections as $collection)
                                    @if ($collection->fee_attribute == '3_6_8_12_fee')
                                        @php
                                            $total_single_section_single_sector_fee = $total_single_section_single_sector_fee + $collection->fee_value;
                                            $total_single_section_fee = $total_single_section_fee + $collection->fee_value;
                                            $total_3_6_8_12_fee = $total_3_6_8_12_fee + $collection->fee_value;
                                        @endphp
                                    @endif
                                @endforeach
                                {{ $total_single_section_single_sector_fee == 0 ? '' : $total_single_section_single_sector_fee }}
                            </td>
                            <td>
                                @php
                                    $total_single_section_single_sector_fee = 0;
                                @endphp
                                @foreach ($sectioncollections as $collection)
                                    @if ($collection->fee_attribute == 'jsc_ssc_form_fee')
                                        @php
                                            $total_single_section_single_sector_fee = $total_single_section_single_sector_fee + $collection->fee_value;
                                            $total_single_section_fee = $total_single_section_fee + $collection->fee_value;
                                            $total_jsc_ssc_form_fee = $total_jsc_ssc_form_fee + $collection->fee_value;
                                        @endphp
                                    @endif
                                @endforeach
                                {{ $total_single_section_single_sector_fee == 0 ? '' : $total_single_section_single_sector_fee }}
                            </td>
                            <td>
                                @php
                                    $total_single_section_single_sector_fee = 0;
                                @endphp
                                @foreach ($sectioncollections as $collection)
                                    @if ($collection->fee_attribute == 'certificate_fee')
                                        @php
                                            $total_single_section_single_sector_fee = $total_single_section_single_sector_fee + $collection->fee_value;
                                            $total_single_section_fee = $total_single_section_fee + $collection->fee_value;
                                            $total_certificate_fee = $total_certificate_fee + $collection->fee_value;
                                        @endphp
                                    @endif
                                @endforeach
                                {{ $total_single_section_single_sector_fee == 0 ? '' : $total_single_section_single_sector_fee }}
                            </td>
                            <td>
                                @php
                                    $total_single_section_single_sector_fee = 0;
                                @endphp
                                @foreach ($sectioncollections as $collection)
                                    @if ($collection->fee_attribute == 'scout_fee')
                                        @php
                                            $total_single_section_single_sector_fee = $total_single_section_single_sector_fee + $collection->fee_value;
                                            $total_single_section_fee = $total_single_section_fee + $collection->fee_value;
                                            $total_scout_fee = $total_scout_fee + $collection->fee_value;
                                        @endphp
                                    @endif
                                @endforeach
                                {{ $total_single_section_single_sector_fee == 0 ? '' : $total_single_section_single_sector_fee }}
                            </td>
                            <td>
                                @php
                                    $total_single_section_single_sector_fee = 0;
                                @endphp
                                @foreach ($sectioncollections as $collection)
                                    @if ($collection->fee_attribute == 'develoment_donation')
                                        @php
                                            $total_single_section_single_sector_fee = $total_single_section_single_sector_fee + $collection->fee_value;
                                            $total_single_section_fee = $total_single_section_fee + $collection->fee_value;
                                            $total_develoment_donation = $total_develoment_donation + $collection->fee_value;
                                        @endphp
                                    @endif
                                @endforeach
                                {{ $total_single_section_single_sector_fee == 0 ? '' : $total_single_section_single_sector_fee }}
                            </td>
                            <td>
                                @php
                                    $total_single_section_single_sector_fee = 0;
                                @endphp
                                @foreach ($sectioncollections as $collection)
                                    @if ($collection->fee_attribute == 'other_fee')
                                        @php
                                            $total_single_section_single_sector_fee = $total_single_section_single_sector_fee + $collection->fee_value;
                                            $total_single_section_fee = $total_single_section_fee + $collection->fee_value;
                                            $total_other_fee = $total_other_fee + $collection->fee_value;
                                        @endphp
                                    @endif
                                @endforeach
                                {{ $total_single_section_single_sector_fee == 0 ? '' : $total_single_section_single_sector_fee }}
                            </td>
                            <td>
                            <b>{{ $total_single_section_fee }}</b>
                            </td>
                        </tr>                
                    @endforeach            
                @endforeach            
              @endforeach            
            </tbody>
            <tfoot>
              <tr>
                <td colspan="4" align="right">মোট (৳)</td>
                <th>{{ $total_admission_session_fee }}</th>
                <th>{{ $total_annual_sports_cultural }}</th>
                <th>{{ $total_last_year_due }}</th>
                <th>{{ $total_exam_fee }}</th>
                <th>{{ $total_full_half_free_form }}</th>
                <th>{{ $total_3_6_8_12_fee }}</th>
                <th>{{ $total_jsc_ssc_form_fee }}</th>
                <th>{{ $total_certificate_fee }}</th>
                <th>{{ $total_scout_fee }}</th>
                <th>{{ $total_develoment_donation }}</th>
                <th>{{ $total_other_fee }}</th>
                <th>{{ $total_admission_session_fee + $total_annual_sports_cultural + $total_last_year_due + $total_exam_fee + $total_full_half_free_form + $total_3_6_8_12_fee + $total_jsc_ssc_form_fee + $total_certificate_fee + $total_scout_fee + $total_develoment_donation + $total_other_fee }}</th>
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
            if($('#from_date').val() && $('#to_date').val()) 
            {
                window.location.href = window.location.protocol + "//" + window.location.host + "/collection/daily/ledger/"+$('#from_date').val()+"/"+$('#to_date').val();
            } else {
                toastr.warning('শিক্ষাবর্ষ এবং তারিখ সিলেক্ট করুন!');
            }
        })
      })
</script>
@stop