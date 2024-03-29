@extends('adminlte::page')

@section('title', 'Easy School | Input Form')

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
      রশিদ ডাউনলোড
    </h1>
    <ol class="breadcrumb">
      <li><a href="{{ route('collection.index') }}"><i class="fa fa-money"></i> আদায় ব্যবস্থাপনা</a></li>
      <li class="active">রশিদ ডাউনলোড</li>
    </ol>
@stop

@section('content')
  @permission('student-crud')
    <div class="row">
      <div class="col-md-2">
          <select class="form-control" id="search_class">
              <option selected="" disabled="" value="">শ্রেণি নির্ধারণ করুন</option>
              {{-- <option value="All_Classes" @if($classsearch == 'All_Classes') selected="" @endif>সকল শ্রেণি</option> --}}
              @php
                  $classes = explode(',', Auth::user()->school->classes);
              @endphp
              @foreach($classes as $class)
              <option value="{{ $class }}" @if($classsearch == $class) selected="" @endif>
                @if($class == -1) Nursery @elseif($class == 0) KG Zero @else Class {{ $class }} @endif
              </option>
              @endforeach
          </select>
      </div>
      @if(Auth::user()->school->sections > 0)
        <div class="col-md-2" id="search_section_div">
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
          <button class="btn btn-success btn-sm" id="search_students_btn"><i class="fa fa-fw fa-download"></i> ডাউনলোড করুন</button>
          {{-- @if($feecollections == true)
            <a href="{{ Request::url() . '/pdf' }}" class="btn btn-success btn-sm" style="margin-left: 10px;" id=""><i class="fa fa-fw fa-download"></i> পিডিএফ</a>
          @endif --}}
      </div>
    </div>
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
            if($('#search_class').val() && $('#search_session').val() && $('#from_date').val() && $('#to_date').val()) 
            {
              if($('#search_class').val() == "All_Classes") {
                window.location.href = window.location.protocol + "//" + window.location.host + "/collection/receipt/generate/"+$('#search_session').val()+"/"+$('#search_class').val()+"/"+$('#search_section').val()+"/"+$('#from_date').val()+"/"+$('#to_date').val();
              } else {
                if($('#search_session').val()) {
                  window.location.href = window.location.protocol + "//" + window.location.host + "/collection/receipt/generate/"+$('#search_session').val()+"/"+$('#search_class').val()+"/"+$('#search_section').val()+"/"+$('#from_date').val()+"/"+$('#to_date').val();
                } else {
                  toastr.warning('শ্রেণি, শাখা, শিক্ষাবর্ষ এবং তারিখসহ সবগুলো সিলেক্ট করুন!');
                }
              }
            } else {
                toastr.warning('শ্রেণি, শাখা, শিক্ষাবর্ষ এবং তারিখসহ সবগুলো সিলেক্ট করুন!');
            }
        @else
          window.location.href = window.location.protocol + "//" + window.location.host + "/collection/receipt/generate/"+$('#search_session').val()+"/"+$('#search_class').val()+"/No_Section/"+$('#from_date').val()+"/"+$('#to_date').val();
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
</script>
@stop