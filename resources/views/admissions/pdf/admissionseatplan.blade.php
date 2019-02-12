<html>
<head>
  <title>Admission Seatplan | PDF</title>
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
  @foreach($applications as $application)
    <div style="text-align: center;  border:0px solid black; width: 33%;  float: left;">
      <div style="text-align: center;  border:1px solid black; width: 200px;  height: 115px;">
        <span>
          <span style="@if(strlen($application->school->name_bangla) < 65) font-size: 20px; @elseif(strlen($application->school->name_bangla) > 65 && strlen($application->school->name_bangla) <= 97) font-size: 14px; @elseif(strlen($application->school->name_bangla) > 97) font-size: 11px; @endif padding: 1px; margin-top: 5px;"><b>{{ $application->school->name_bangla }}</b></span><br/>
          <span style="font-size: 14px; padding: 1px; border-bottom: 1px solid black;">{{ bangla_class($application->class) }} শ্রেণি ভর্তি পরীক্ষা</span><br/>
          <span style="font-size: 14px; padding: 2px;">
            আইডিঃ {{ $application->application_id }}
          </span><br/>

          <span style="font-size: 24px; margin-top: 1px;"><b>রোল: {{ $application->application_roll }}</b></span><br/>
          <span style="font-size: 15px; margin-top: 1px;">{{ $application->name }}</span><br/>
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