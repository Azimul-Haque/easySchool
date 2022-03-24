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
        কাজ চলছে...
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
          <button class="btn btn-primary btn-sm" id="search_students_btn"><i class="fa fa-fw fa-search"></i> তালিকা দেখুন</button>
          @if($feecollections == true)
            <a href="{{ Request::url() . '/pdf' }}" class="btn btn-success btn-sm" style="margin-left: 10px;" id=""><i class="fa fa-fw fa-download"></i> পিডিএফ</a>
          @endif
      </div>
    </div>
  @endpermission
@stop

@section('js')

@stop