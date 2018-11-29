<html>
<head>
  <title>Students List | PDF</title>
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
        <td>
          <p style="text-align: center; font-size: 15px;">
            <center>
              <span>টটলিস্ট {{ bangla_class($data[1]) }}-{{ bangla($data[0]) }}</span><br/>
              Zila Code: _ _ _, Zilla Name: {{ Auth::user()->school->district }}, Upazilla: {{ Auth::user()->school->upazilla }}, Post Office: {{ Auth::user()->school->address }}, Mobile No: {{ Auth::user()->school->contact }}<br/>
              CENTRE CODE: _ _ _, CENTRE NAME: _ _ _ _ _ _ _ _ _ _ _ _ _, EMAIL-ADDRESS: _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ <br/>
              EIIN NO: {{ Auth::user()->school->eiin }} SCHOOL CODE: {{ Auth::user()->school->school_code }} SCHOOL NAME: <big>{{ Auth::user()->school->name }}</big>
            </center>
          </p>
        </td>
      </tr>
    </table>
  </htmlpageheader>
  <htmlpagefooter name="page-footer">
    <table>
      <tr>
        <td width="80%"></td>
        <td width="20%">
          <center>
            @if(file_exists(public_path('images/schools/signs/'.Auth::user()->school->headmaster_sign)))
              <img src="{{ public_path('images/schools/signs/'.Auth::user()->school->headmaster_sign) }}" height="50">
            @endif
          </center>
          প্রধান শিক্ষকের স্বাক্ষর
        </td>
      </tr>
    </table>
  </htmlpagefooter>
  <table class="maintable">
    <tr>
      <th width="3%">SL.<br/>NO</th>
      <th>STUDENT'S NAME</th>
      <th>FATHER'S NAME</th>
      <th>MOTHER'S NAME</th>
      <th>DATE OF BIRTH<br/>GENDER</th>
      <th>CLASS ROLL<br/>SECTION</th>
      <th>JSC PASSIING YEAR<br/>ROLL</th>
      <th>GROUP<br/>RELIGION<br/>4th SUBJECT</th>
      <th width="15%">SUBJECT CODE</th>
      <th width="10%">STUDENT'S<br/>SIGNATURE</th>
    </tr>
    @php
      $counter = 1;
    @endphp
    @foreach($students as $student)
    <tr>
      <th>{{ $counter }}</th>
      <td>
        @if(strlen($student->name) > 30)
          <span style="font-size: 11px;">{{ $student->name }}</span>
        @else
          {{ $student->name }}
        @endif
      </td>
      <td>{{ $student->father }}</td>
      <td>{{ $student->mother }}</td>
      <td>{{ date('d-m-Y', strtotime($student->dob)) }}<br/>{{ $student->gender }}</td>
      <td>{{ $student->roll }}<br/>{{ english_section(Auth::user()->school->section_type, $student->class, $student->section) }}</td>
      <td>{{ $student->jsc_session }}<br/>{{ $student->jsc_roll }}</td>
      <td>{{ english_section(Auth::user()->school->section_type, $student->class, $student->section) }}<br/>{{ $student->religion }}<br/>{{ $student->ssc_fourth_subject_code }}</td>
      <td>{{ $student->ssc_subject_codes }}</td>
      <td></td>
    </tr>
    @if($counter%10 == 0)
     </table>
     <pagebreak></pagebreak> 
     <table class="maintable">
        <tr>
          <th width="3%">SL.<br/>NO</th>
          <th>STUDENT'S NAME</th>
          <th>FATHER'S NAME</th>
          <th>MOTHER'S NAME</th>
          <th>DATE OF BIRTH<br/>GENDER</th>
          <th>CLASS ROLL<br/>SECTION</th>
          <th>JSC PASSIING YEAR<br/>ROLL</th>
          <th>GROUP<br/>RELIGION<br/>4th SUBJECT</th>
          <th width="15%">SUBJECT CODE</th>
          <th width="10%">STUDENT'S<br/>SIGNATURE</th>
        </tr>
    @endif
    @php
      $counter++;
    @endphp
    @endforeach
  </table>
</body>
</html>