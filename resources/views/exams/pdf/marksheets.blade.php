<html>
<head>
  <title>Mark Sheets | PDF</title>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <link rel="icon" sizes="192x192" href="{{ asset('images/pdf-icon.png') }}">
  <style>
  body {
    font-family: Calibri, sans-serif;
  }
  table {
      border-collapse: collapse;
      width: 100%;
  }

  .maintable tr td, .maintable tr th {
      border: 1px solid black;
  }
  .maintable tr th, .maintable tr td{
    padding: 1px;
    font-family: Calibri, sans-serif;
    font-size: 13px;
  }

  .markstable tr td, .markstable tr th {
      border: 1px solid black;
  }
  .markstable tr th, .markstable tr td{
    padding: 2px;
    font-family: Calibri, sans-serif;
    font-size: 13px;
  }
  .nostyletd {
    border: 0px solid white !important;
  }
  .monogram {
    width: 85px;
  }
  .grade_table {
    width: 180px;
  }
  @page {
    header: page-header;
    footer: page-footer;
    /*background-image: url('');
    background-size: cover;              
    background-repeat: no-repeat;
    background-position: center center;*/
  }
  </style>
</head>
<body>
  @php
    $merit_counter = 1;
  @endphp
  @foreach($results as $result)
  <table class="">
    <tr>
      <td width="26%" align="right">
        <img class="monogram" src="{{ public_path('images/schools/monograms/'. Auth::user()->school->monogram) }}">
      </td>
      <td>
        <p style="text-align: center;">
          <center>
            <b style="font-size: 22px;">{{ Auth::user()->school->name }}</b><br/>
            <span>{{ Auth::user()->school->address }}, {{ Auth::user()->school->upazilla }}, {{ Auth::user()->school->district }}</span><br/>
            <span>Est. {{ Auth::user()->school->established }}<br/>
            <span>http://jamalpurhs.com</span>{{-- would be removed --}}
            <h2>Progress Report-{{ $data[0]->exam_session }}</h2>
            <b style="font-size: 16px;">{{ exam_en($data[0]->name) }} Examination</b>
          </center>
        </p>
      </td>
      <td width="26%">
        <center>
          <img class="grade_table" src="{{ public_path('images/grade_table.png') }}">
        </center>
      </td>
    </tr>
  </table>
  <br/>
  <table>
    <tr>
      <td>Class: {{ en_class($data[1]) }}</td>
      <td>Section/Group: {{ english_section(Auth::user()->school->section_type, $data[1], $data[2]) }}</td>
    </tr>
  </table>
  <table class="maintable">
    <tr>
      <td>Student Name: {{ $result['name'] }}</td>
      <td>Student ID: {{ $result['student_id'] }}</td>
    </tr>
    <tr>
      <td>Father's Name: {{ $result['father'] }}
      <td>Roll: {{ $result['roll'] }}</td>
    </tr>
    <tr>
      <td>Mother's Name: {{ $result['mother'] }}</td>
      <td>GPA: {{ $result['roll'] }}</td>
    </tr>
    <tr>
      <td>Date of Birth: {{ date('F d, Y', strtotime($result['dob'])) }}</td>
      <td>
        Merit Position:
        @if($result['grade'] == 'F')
          N/A
        @else
          {{ $merit_counter }}
        @endif
      </td>
    </tr>
    <tr>
      <td colspan="2">
        Result:
        @if($result['grade'] == 'F')
          FAILED
        @else
          PASSED
        @endif
      </td>
    </tr>
  </table>
  <table>
    <tr>
      <td align="center" style="padding-top: 10px; padding-bottom: 5px;"><b>SUBJECT-WISE GRADE & MARK SHEET</b></td>
    </tr>
  </table>
  <table class="markstable">
    <tr>
      <th>Subject</th>
      <th>Written</th>
      <th>MCQ</th>
      <th>Practical</th>
      <th>Total</th>
      <th>Total %</th>
      <th>CA %</th>
      <th>Grand Total</th>
      <th>GP</th>
      <th>Grade</th>
      <th>GPA</th>
      <th>Grade</th>
    </tr>
    @foreach($data[3] as $key => $subject)
      <tr>
        <td align="center">{{ $subject->subject->name_english }}</td>
        <td>Written</td>
        <td>MCQ</td>
        <td>Practical</td>
        <td>Total</td>
        <td>Total %</td>
        <td>CA %</td>
        <td>Grand Total</td>
        <td>GP</td>
        <td>Grade</td>
        @if($key == 0)
          <td rowspan="{{ count($data[3]) }}">GPA</td>
          <td rowspan="{{ count($data[3]) }}">Grade</td>
        @endif
      </tr>
    @endforeach
    <tr>
      <th>Total</th>
      <th colspan="6"></th>
      <th></th>
      <th colspan="4"></th>
    </tr>
  </table>
  <pagebreak></pagebreak>
  @php
    $merit_counter++;
  @endphp
  @endforeach

  <htmlpagefooter name="page-footer">
    <table>
      <tr>
        <td align="left">.................................<br/>Signature (Guardian) </td>
        <td align="center">.........................................<br/>Signature (Class Teacher) </td>
        <td align="right">.......................................<br/>Signature (Head Master) </td>
      </tr>
    </table>
  </htmlpagefooter>
</body>
</html>