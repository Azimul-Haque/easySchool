<html>
<head>
  <title>Result List | PDF</title>
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
    padding: 3px;
    font-family: 'kalpurush', sans-serif;
    font-size: 13px;
  }
  </style>
</head>
<body>
  <table>
    <tr>
      <td width="18%">
      </td>
      <td>
        <p style="text-align: center; font-size: 22px;">
          <center>
            <b>{{ Auth::user()->school->name_bangla }}</b><br/>
            <span style="font-size: 15px;">
              স্থাপিতঃ {{ bangla(Auth::user()->school->established) }} ইংরেজি | ইআইআইএনঃ {{ bangla(Auth::user()->school->eiin) }}<br/><br/>
              <span style="font-size: 18px;">
                <b><u>শ্রেণিঃ {{ bangla_class($data[2]) }}, শাখাঃ {{ bangla_section(Auth::user()->school->section_type, $data[2], $data[3]) }}, পরীক্ষাঃ {{ exam($data[0]) }}, শিক্ষাবর্ষঃ {{ bangla($data[1]) }}</u></b>
              </span><br/>
            </span><br/><br/>
          </center>
        </p>
      </td>
      <td width="18%"></td>
    </tr>
  </table>
  <table class="maintable">
    <tr>
      <th width="25%">মোট পরীক্ষার্থীঃ {{ bangla(count($results)) }} জন</th>
      <th width="25%">অংশগ্রহণকারীঃ  {{ bangla(count($results) - count($results->where('total_marks', 0))) }} জন</th>
      <th width="25%">উত্তীর্ণঃ {{ bangla(count($results) - count($results->where('grade', 'F'))) }} জন</th>
      <th width="25%">অকৃতকার্যঃ {{ bangla((count($results) - count($results->where('total_marks', 0))) - (count($results) - count($results->where('grade', 'F')))) }} জন</th> 
      {{-- {{ bangla(count($results->where('grade', 'F'))) }} --}}
    </tr>
  </table>
  <table class="maintable" style="margin-top: 5px;">
    <tr>
      <th width="5%">রোল</th>
      <th width="12%">আইডি</th>
      <th width="7%">নাম</th>
      <th width="8%">মোট প্রাপ্ত নম্বর</th>
      <th width="8%">জিপিএ</th>
      <th width="8%">গ্রেড</th>
      <th width="8%">মেরিট পজিশন</th>
      <th width="8%">ফলাফল</th>
    </tr>
    @php
      $counter = 1;
    @endphp
    @foreach($results as $result)
    <tr>
      <th>{{ $result['roll'] }}</th>
      <th>{{ $result['student_id'] }}</th>
      <td>{{ $result['name'] }}</td>
      <th>{{ $result['total_marks'] }}</th>
      <th>{{ number_format($result['gpa'], 2) }}</th>
      <th>
        {{ $result['grade'] }}
        @if($result['f_count'] > 0)
          ({{ $result['f_count'] }})
        @endif
      </th>
      <th>
        @if($result['grade'] == 'F')
          N/A
        @else
          {{ $counter }}
        @endif
      </th>
      @if($result['grade'] == 'F')
        <th style="background: #FF0000; color: #FFFFFF;">অকৃতকার্য</th>
      @else
        <th>কৃতকার্য</th>
      @endif
    </tr>
    @php
      $counter++;
    @endphp
    @endforeach
  </table>
</body>
</html>