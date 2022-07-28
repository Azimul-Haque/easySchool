<html>
<head>
  <title>Exam Seatplan | PDF</title>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <link rel="shortcut icon" type="image/png" sizes="192x192" href="{{ asset('images/pdf-icon.png') }}">
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
    padding: 5px;
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
  @php $i = 1; @endphp
  @foreach($students as $student)
    <div style="text-align: center;  border:0px solid black; width: 33%;  float: left;">
      <div style="text-align: center;  border:1px solid black; width: 200px;  height: 115px; line-height: 1.47em; letter-spacing: 0px;">
          <span style="@if(strlen($student->school->name_bangla) < 65) font-size: 19px; @elseif(strlen($student->school->name_bangla) > 65 && strlen($student->school->name_bangla) <= 97) font-size: 14px;letter-spacing: -1px; @elseif(strlen($student->school->name_bangla) > 97) font-size: 12px;letter-spacing: -1px; @endif margin-top: 5px;"><b>{{ $student->school->name_bangla }}</b></span><br/>
          <span style="font-size: 14px;">
            <u>{{ exam(Auth::user()->exam->name) }}-{{ bangla(Auth::user()->exam->exam_session) }}<br/></u>
          </span>
          <span style="font-size: 13px; margin-top: 0px;">শ্রেণিঃ {{ bangla_class($student->class) }}
          @if($student->section !=0)
            , শাখাঃ {{ bangla_section(Auth::user()->school->section_type, $student->class, $student->section) }}
          @endif
          <br/>
          </span>
          <span style="font-size: 20px; margin-top: 0px;"><b>রোল: {{ bangla(STR_PAD($student->roll, 2, 0, STR_PAD_LEFT)) }}<br/></b></span>
          <span style="font-size: 13px; margin-top: 0px;line-height: 1em; letter-spacing: -1px;">
            @if(strlen($student->name) > 30)
              <span style="font-size: 11px;">{{ $student->name }}<br/> স্টুডেন্ট আইডিঃ {{ $student->student_id }}</span>
            @else
              {{ $student->name }}<br/> স্টুডেন্ট আইডিঃ {{ $student->student_id }}
            @endif
          </span>
      </div>
    </div>
    @if($i%18==0) <pagebreak></pagebreak> 
    @else
      @if($i%3==0) <br/> @endif
    @endif
    @php $i++; @endphp
  @endforeach

  <htmlpagefooter name="page-footer">
    <small style="font-family: Calibri; color: #6D6E6A;">Powered by EasySchool.XYZ</small>
  </htmlpagefooter>
</body>
</html>