<html>
<head>
  <title>{{ $student->name }} | Testimonial | PDF</title>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <link rel="icon" sizes="192x192" href="{{ asset('images/pdf-icon.png') }}">
  <style>
  body {
    font-family: 'kalpurush', sans-serif;
  }
  table {
      border-collapse: collapse;
      width: 100%;
  }

  .maintable tr td, .maintable tr th {
      border: 1px solid black;
  }
  .maintable tr th, .maintable tr td{
    padding: 4px;
    font-family: 'kalpurush', sans-serif;
    font-size: 14px;
  }
  @page {
    header: page-header;
    footer: page-footer;
  }
  </style>
</head>
<body>
  <table class="">
    <tr>
      <td width="18%">
        @if(Auth::user()->school->monogram != null || Auth::user()->school->monogram != '')
          <img src="{{ public_path('images/schools/monograms/'.Auth::user()->school->monogram) }}" height="70" width="70" style="float: left !important;">
        @else
          
        @endif
      </td>
      <td>
        <p style="text-align: center; font-size: 22px;">
          <center>
            <b>{{ Auth::user()->school->name_bangla }}</b><br/>
            <span style="font-size: 15px;">
              {{ Auth::user()->school->address }}, {{ Auth::user()->school->upazilla }}, {{ Auth::user()->school->district }} <br/>
              স্থাপিতঃ {{ bangla(Auth::user()->school->established) }} ইংরেজি | ইআইআইএনঃ {{ bangla(Auth::user()->school->eiin) }}
            </span>
          </center>
        </p>
      </td>
      <td width="18%"></td>
    </tr>
    <tr>
      <td colspan="3">
        <center>
          <span style="font-size: 20px;">
            <br/>
            শিক্ষার্থী তথ্য
          </span>
        </center>
      </td>
    </tr>
  </table>
  <br/><br/>
  <table class="maintable">
    <tr>
      <th colspan="2">শিক্ষার্থী তথ্য</th>
      <th colspan="2">অ্যাকাডেমিক তথ্য</th>
      <th rowspan="7" valign="center" width="16%" style="vertical-align:center;">
        <center>
          @if($student->image != null && $student->image != '')
            <img src="{{ public_path('images/admission-images/'.$student->image) }}" height="100" width="100">
          @else
            <img src="{{ public_path('images/dummy_student.jpg') }}" height="100" width="100">
          @endif
        </center>
      </th>
    </tr>
    <tr>
      <td>নাম</td>
      <td>{{ $student->name }}</td>
      <td>শ্রেণি</td>
      <td>{{ bangla_class($student->class) }}</td>
    </tr>
    <tr>
      <td>পিতার নাম</td>
      <td>{{ $student->father }}</td>
      <td>শাখা</td>
      <td>{{ bangla_section(Auth::user()->school->section_type, $student->class, $student->section) }}</td>
    </tr>
    <tr>
      <td>মাতার নাম</td>
      <td>{{ $student->mother }}</td>
      <td>রোল</td>
      <td>{{ bangla($student->roll) }}</td>
    </tr>
    <tr>
      <td>জন্মতারিখ</td>
      <td>{{ date('F d, Y', strtotime($student->dob)) }}</td>
      <td>আইডি</td>
      <td>{{ bangla($student->student_id) }}</td>
    </tr>
    <tr>
      <td>যোগাযোগ</td>
      <td>{{ $student->contact }}, {{ $student->contact_2 }}</td>
      <td>জেএসসি রোল</td>
      <td>{{ bangla($student->jsc_roll) }}</td>
    </tr>
    <tr>
      <td>ঠিকানা</td>
      <td>{{ $student->village }}, {{ $student->post_office }},<br/>{{ $student->upazilla }}, {{ $student->district }}</td>
      <td>এসএসসি রোল</td>
      <td>{{ bangla($student->ssc_roll) }}</td>
    </tr>
  </table><br/><br/>
  <table class="maintable">
    <thead>
      <tr>
        <th colspan="12"><i class="fa fa-fw fa-graduation-cap"></i> বিগত বছরের ফলাফল</th>
      </tr>
      <tr>
        <th align="center"><b>ক্র.<br/>নং</b></th>
        <th align="center"><b>শিক্ষাবর্ষ</b></th>
        <th align="center"><b>শ্রেণি</b></th>
        <th align="center"><b>শাখা</b></th>
        <th align="center"><b>রোল</b></th>
        <th align="center"><b>অর্ধবার্ষিক/প্রাক নির্বাচনীপরীঃ ফলাফল<br/>(মেরিট পজিসন)</b></th>
        <th align="center"><b>বার্ষিক/টেষ্ট পরীঃফলাফল<br/>(মেরিট পজিসন)</b></th>
        <th align="center"><b>সুবিধা ভোগী</b></th>
        <th align="center"><b>মোট কার্যদিবস</b></th>
        <th align="center"><b>মোট উপস্থিতি</b></th>
        <th align="center"><b>এই বিদ্যলয়ে ভর্তির তারিখ</b></th>
        <th align="center"><b>প্রধান শিক্ষকের মন্তব্য</b></th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
      </tr>
    </tbody>
  </table>

  <htmlpagefooter name="page-footer">
    <small style="font-family: Calibri; color: #6D6E6A;">Powered by EasySchool.XYZ</small>
  </htmlpagefooter>
</body>
</html>