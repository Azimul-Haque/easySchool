<html>
<head>
  <title>Students Album | PDF</title>
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
    padding: 2px;
    font-family: 'kalpurush', sans-serif;
    font-size: 12px;
  }
  .nostyletd {
    border: 0px solid white !important;
  }
  @page {
    header: page-header;
    footer: page-footer;
  }
  </style>
</head>
<body>
  <htmlpageheader name="page-header">
    <table>
      <tr>
        <td width="10%">
          @if(Auth::user()->school->monogram != null || Auth::user()->school->monogram != '')
            <img src="{{ public_path('images/schools/monograms/'.Auth::user()->school->monogram) }}" height="50" width="50" style="float: left !important; margin-top: -25px;">
          @else
            
          @endif
        </td>
        <td>
          <p style="text-align: center; font-size: 22px;">
            <center>
              {{ Auth::user()->school->name_bangla }}<br/>
              <span style="font-size: 15px;">
                ডাকঘরঃ {{ Auth::user()->school->address }}, উপজেলাঃ {{ Auth::user()->school->upazilla }}, জেলাঃ {{ Auth::user()->school->district }}
              </span><br/>
              <big>শিক্ষার্থী অ্যালবাম</big>
            </center>
          </p>
        </td>
        <td width="10%"></td>
      </tr>
    </table>
    <center>
      <table class="">
        <tr>
          <th width="25%" style="width: 25% !important;">শ্রেণিঃ {{ bangla_class($data[1]) }},</th>
          <th width="25%" style="width: 25% !important;">শাখাঃ {{ bangla_section(Auth::user()->school->section_type, $data[1], $data[2]) }},</th>
          <th width="25%" style="width: 25% !important;">শিক্ষার্থী সংখ্যাঃ {{ bangla(count($students)) }} জন,</th>
          <th width="25%" style="width: 25% !important;">শিক্ষাবর্ষ {{ bangla($data[0]) }}</th>
        </tr>
      </table>
    </center>
  </htmlpageheader>
  <table class="maintable">
    <tr>
    @php
      $counter = 1;
    @endphp
    @foreach($students as $student)
      <td width="25%" style="width: 25% !important;">
        <center>
          @if($student->image != null && $student->image != '')
          <img src="{{ public_path('images/admission-images/'.$student->image) }}" height="135" width="135" style="margin-top: 13px;">
          @else
          <img src="{{ public_path('images/dummy_student.jpg') }}" height="135" width="135" style="margin-top: 13px;">
          @endif
        </center><br/>
        {{ $student->name }}<br/>
        {{ $student->village }}, {{ $student->post_office }}<br/>
        রোলঃ {{ $student->roll }}, <img src="{{ public_path('images/phone.png') }}" height="8" width="8"> {{ $student->contact }}
      </td>
    @if($counter%4 == 0)
      </tr> <tr>
    @endif
    @if($counter%16 == 0)
     </tr>
    </table>
     <pagebreak></pagebreak>
    <table class="maintable">
      <tr>
    @endif
    @php
      $counter++;
    @endphp
    @endforeach
    </tr>
  </table>

  <htmlpagefooter name="page-footer">
    <small style="font-family: Calibri; color: #6D6E6A;">Powered by EasySchool.XYZ</small>
  </htmlpagefooter>
</body>
</html>