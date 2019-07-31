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
    width: 175px;
    height: auto;
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
      <td align="center" style="padding-top: 8px; padding-bottom: 3px;"><b>SUBJECT-WISE GRADE & MARK SHEET</b></td>
    </tr>
  </table>
  <table class="markstable">
    <tr>
      <th width="20%">Subject</th>
      <th>Written</th>
      <th>MCQ</th>
      <th>Practical</th>
      <th>Total</th>
      <th>Total %</th>
      <th width="6%">CA %</th>
      <th>Grand Total</th>
      <th width="6%">GP</th>
      <th>Grade</th>
      <th>GPA</th>
      <th>Grade</th>
    </tr>
    @foreach($data[3] as $key => $subject)
      <tr>
        <td align="center">{{ $subject->subject->name_english }}</td>
        @foreach($result['subjects_marks'] as $subject_marks)
          @if($subject->subject_id == $subject_marks['subject_id'])
            <td align="center">{{ $subject_marks['written'] }}</td>
            <td align="center">
              @if($subject->mcq > 0)
                {{ $subject_marks['mcq'] }}
              @endif
            </td>
            <td align="center">
              @if($subject->practical > 0)
                {{ $subject_marks['practical'] }}
              @endif
            </td>
            <td align="center">{{ $subject_marks['written'] + $subject_marks['mcq'] + $subject_marks['practical'] }}</td>
            <td align="center">{{ $subject_marks['total_percentage'] }}</td>
            <td align="center">
              @if($subject->ca > 0)
                {{ $subject_marks['ca'] }}
              @endif
            </td>
            <td align="center">{{ $subject_marks['total'] }}</td>
            <td align="center">{{ $subject_marks['grade_point'] }}</td>
            <td align="center">{{ $subject_marks['grade'] }}</td>
          @endif
        @endforeach
        @if($key == 0)
          <td rowspan="{{ count($data[3]) }}" align="center">{{ $result['gpa'] }}</td>
          <td rowspan="{{ count($data[3]) }}" align="center">{{ $result['grade'] }}</td>
        @endif
      </tr>
    @endforeach
    <tr>
      <th>Total</th>
      <th colspan="6"></th>
      <th>{{ $result['total_marks'] }}</th>
      <th colspan="4"></th>
    </tr>
  </table>
  <table>
    <tr>
      <td align="center" style="padding-top: 8px; padding-bottom: 3px;"><b>ATTENDANCE REPORT</b></td>
    </tr>
  </table>
  <table class="markstable">
    <tr>
      <th width="15%">Month</th>
      <th>Jan</th>
      <th>Feb</th>
      <th>Mar</th>
      <th>Apr</th>
      <th>May</th>
      <th>Jun</th>
      <th>Jul</th>
      <th>Aug</th>
      <th>Sep</th>
      <th>Oct</th>
      <th>Nov</th>
      <th>Dec</th>
    </tr>
    <tr>
      <td align="center">Working Days</td>
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
    <tr>
      <td align="center">Presence</td>
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
  </table>
  <div style="width: 50%; float: left;">
    <table>
      <tr>
        <td align="center" style="padding-top: 8px; padding-bottom: 3px;"><b>OVERALL REPORT</b></td>
      </tr>
    </table>
    <table class="markstable" style="margin-right: 10px;">
      <tr>
        <th>Subject Code</th>
        <th>Total Marks</th>
        <th>GP</th>
      </tr>
      <tr>
        <td style="height: 16px;"></td>
        <td></td>
        <td></td>
      </tr>
      <tr>
        <td style="height: 16px;"></td>
        <td></td>
        <td></td>
      </tr>
      <tr>
        <td style="height: 16px;"></td>
        <td></td>
        <td></td>
      </tr>
      <tr>
        <td style="height: 16px;"></td>
        <td></td>
        <td></td>
      </tr>
      <tr>
        <td style="height: 16px;"></td>
        <td></td>
        <td></td>
      </tr>
      <tr>
        <td style="height: 16px;"></td>
        <td></td>
        <td></td>
      </tr>
      <tr>
        <th>Total</th>
        <th></th>
        <th></th>
      </tr>
    </table>
  </div>
  <div style="width: 50%; float: left;">
    <table>
      <tr>
        <td align="center" style="padding-top: 8px; padding-bottom: 3px;"><b>EXTRA ACTIVITIES</b></td>
      </tr>
    </table>
    <table class="markstable" style="margin-left: 10px;">
      <tr>
        <td width="60%" align="center">Cultural activity/ Dramatic Performance</td>
        <td></td>
      </tr>
      <tr>
        <td align="center">Scout/BNCC /Red Crescent</td>
        <td></td>
      </tr>
      <tr>
        <td align="center">Games and Sports</td>
        <td></td>
      </tr>
      <tr>
        <td align="center">Math / Science Olympiad</td>
        <td></td>
      </tr>
      <tr>
        <th colspan="2">ACHIEVEMENT</th>
      </tr>
      <tr>
        <th>Examination : 1 / 2</th>
        <td></td>
      </tr>
    </table>
  </div>
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