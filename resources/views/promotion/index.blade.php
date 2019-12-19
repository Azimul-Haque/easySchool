@extends('adminlte::page')

@section('title', 'Easy School')

@section('css')
	<style type="text/css">
		
	</style>
@stop

@section('content_header')
    <h1>
    	শিক্ষার্থী তালিকাঃ <span style="color: #008000;">[শিক্ষাবর্ষঃ {{ bangla($sessionsearch) }}, শ্রেণিঃ {{ bangla_class($classsearch) }}, শাখাঃ {{ bangla_section(Auth::user()->school->section_type, $classsearch, $sectionsearch) }}]</span>
    	<div class="pull-right btn-group">
          
	    </div>	
    </h1>
@stop

@section('content')
  @permission('student-crud')
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
	</div><br/>
  <div class="row">
    <div class="col-md-12">
      @if(!empty($students))
      <button class="btn btn-success promoteBtn" id="promoteBtn" data-toggle="modal" data-target="#promoteModal" data-backdrop="static">নতুন ক্লাসে উন্নীত করুন</button>
      @endif
    </div>
  </div><br/>

	<div class="table-responsive" style="margin-top: 5px;">
		@if($students == true)
		<table class="table" id="datatable-students">
			<thead>
				<tr>
          <th>আইডি</th>
          <th>রোল</th>
          <th>শাখা</th>
          <th>ক্লাস</th>
          <th width="20%">নাম</th>
          <th>পিতা মাতা</th>
					<th>ছবি</th>
					<th>নতুন ক্লাসে রোল</th>
				</tr>
			</thead>
			<tbody>
			@foreach($students as $key => $student)
				<tr>
					<td>{{ $student->student_id }}</td>
          <td>{{ $student->roll }}</td>
          <td>{{ english_section(Auth::user()->school->section_type, $student->class, $student->section) }}</td>
          <td>{{ $student->class }}</td>
          <td>{{ $student->name }}</td>
          <td>{{ $student->father }}<br/>{{ $student->mother }}</td>
					<td>
						@if($student->image != null || $student->image != '')
            <img src="{{ asset('images/admission-images/'.$student->image) }}" style="width: 35px;">
            @else
            <img src="{{ asset('images/dummy_student.jpg') }}" style="width: 35px;">
            @endif
					</td>
					<td>
            <input type="text" class="form-control" style="width: 60px;" id="new_roll{{ $student->student_id }}" value="" tabindex="{{ $student->roll }}">
					</td>
				</tr>
			@endforeach
			</tbody>
		</table>
		@endif
	</div>
	
  {{-- promotion select modal--}}
	
	<!-- Trigger the modal with a button -->
    	<!-- Modal -->
      <div class="modal fade" id="promoteModal" role="dialog">
        <div class="modal-dialog modal-md">
          <div class="modal-content">
            <div class="modal-header modal-header-success">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
              <h4 class="modal-title">নতুন শ্রেণিতে উন্নীতকরণ</h4>
            </div>
            {!! Form::open(array('route' => 'students.promotebulk','method'=>'POST')) !!}
            <div class="modal-body">
              আপনি কি নিশ্চিতভাবে রোল দেওয়া শিক্ষার্থীদের চূড়ান্তভাবে নিম্ননির্ধারিত শ্রেণিতে উন্নীত করতে চান?
              {!! Form::hidden('student_ids', null, ['id' => 'student_ids', 'required' => '']) !!}
              <div class="form-group">
                <label for="promotion_class"><strong>শ্রেণি নির্ধারণ করুন</strong></label>
                <select class="form-control" id="promotion_class" name="promotion_class">
                  <option selected="" disabled="" value="">শ্রেণি নির্ধারণ করুন</option>
                  @php
                    $classes = explode(',', Auth::user()->school->classes);
                  @endphp
                  @foreach($classes as $class)
                  <option value="{{ $class }}">Class {{ $class }}</option>
                  @endforeach
                </select>
              </div>
              <div class="form-group">
                @if(Auth::user()->school->sections > 0)
                <label for="promotion_class"><strong> শাখা নির্ধারণ করুন</strong></label>
                <select class="form-control" id="promotion_section" name="promotion_section">
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
                @else
                <input type="hidden" name="promotion_section" value="0">
                @endif
							</div>	
							<div class="form-group">
								<label for="promotion_session"><strong>শ্রেণি নির্ধারণ করুন</strong></label>
								<select class="form-control" id="promotion_session" name="promotion_session">
									<option selected="" disabled="">শিক্ষাবর্ষ নির্ধারণ করুন</option>
									@for($optionyear = (date('Y')+1) ; $optionyear>=(Auth::user()->school->established); $optionyear--)
									<option value="{{ $optionyear }}" @if($optionyear == date('Y')) selected="" @endif>{{ $optionyear }}</option>
									@endfor
								</select>
							</div>
            </div>
            <div class="modal-footer">
              <button type="submit" class="btn btn-success">Save</button>
              <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
            {!! Form::close() !!}
            </div>
          </div>
        </div>
      </div>
  {{-- promotion select modal--}}
	@endpermission
@stop

@section('js')
<script type="text/javascript">
  $(function(){
   $('a[title]').tooltip();
   $('button[title]').tooltip();
  });
</script>
<script type="text/javascript">
	$(function () {
  	  $('#datatable-students').DataTable({
  	    'paging'      : true,
  	    'pageLength'  : 100,
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
	  $(document).ready(function() {
	  	$('#search_students_btn').click(function() {
        @if(Auth::user()->school->sections > 0)
  	  		if($('#search_class').val() && $('#search_section').val() && $('#search_session').val()) {
  		  		
            window.location.href = window.location.protocol + "//" + window.location.host + "/promotion/"+$('#search_session').val()+"/"+$('#search_class').val()+"/"+$('#search_section').val();
  		  	} else {
  		  		toastr.warning('শ্রেণি, শাখা এবং শিক্ষাবর্ষ সবগুলো সিলেক্ট করুন!');
  		  	}
        @else
          window.location.href = window.location.protocol + "//" + window.location.host + "/promotion/"+$('#search_session').val()+"/"+$('#search_class').val()+"/No_Section";
        @endif
	  	})

      $('#promoteBtn').click(function() {
        var promotion_ids_with_new_roll = [];
        @foreach($students as $student)
          var new_roll = $('#new_roll{{ $student->student_id }}').val();
          var id = {{ $student->student_id }};
          if(($('#new_roll{{ $student->student_id }}').val() != '') && ($('#new_roll{{ $student->student_id }}').val() != null) && ($('#new_roll{{ $student->student_id }}').val() != undefined)) {
            promotion_ids_with_new_roll.push(id+':'+new_roll);
            new_roll = '';
          }
        @endforeach
        $('#student_ids').val(promotion_ids_with_new_roll);
        if($('#student_ids').val() == '') {
          toastr.warning('অন্তত একজন শিক্ষার্থীর নতুন রোল প্রদান করুন!', 'Warning').css('width','400px');
          
          setTimeout(function() {
            $('#promoteModal').modal('hide');
          }, 1000);
        }
        console.log(promotion_ids_with_new_roll);
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
<script type="text/javascript">
  $('#promotion_class').on('change', function() {
    $('#promotion_section').prop('disabled', true);
    $('#promotion_section').append('<option value="" selected disabled>লোড হচ্ছে...</option>');

    if($('#promotion_class').val() < 9) {
      $('#promotion_section')
            .find('option')
            .remove()
            .end()
            .prop('disabled', false)
            .append('<option value="" selected disabled>শাখা নির্ধারণ করুন</option>');

      $('#promotion_section').append('<option value="'+1+'">A</option>');
      $('#promotion_section').append('<option value="'+2+'">B</option>');
      $('#promotion_section').append('<option value="'+3+'">C</option>');
    } else {
      $('#promotion_section')
            .find('option')
            .remove()
            .end()
            .prop('disabled', false)
            .append('<option value="" selected disabled>শাখা নির্ধারণ করুন</option>');

      @if(Auth::user()->school->section_type == 1)
        $('#promotion_section').append('<option value="'+1+'">A</option>');
        $('#promotion_section').append('<option value="'+2+'">B</option>');
        $('#promotion_section').append('<option value="'+3+'">C</option>');
      @elseif(Auth::user()->school->section_type == 2)
        $('#promotion_section').append('<option value="'+1+'">SCIENCE</option>');
        $('#promotion_section').append('<option value="'+2+'">ARTS</option>');
        $('#promotion_section').append('<option value="'+3+'">COMMERCE</option>');
        $('#promotion_section').append('<option value="'+4+'">VOCATIONAL</option>');
        $('#promotion_section').append('<option value="'+5+'">TECHNICAL</option>');
      @endif
    }
  });
</script>
@stop