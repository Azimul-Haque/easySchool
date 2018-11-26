<html>
<head>
  <title>Information Collection List | PDF</title>
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
    padding: 5px;
    font-family: 'kalpurush', sans-serif;
    font-size: 14px;
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
          <span style="font-size: 17px;">
            বিষয়ঃ .............................................................................
          </span>
        </center>
      </td>
    </tr>
  </table>
  <table>
    <tr>
      <td>
        শ্রেণিঃ {{ bangla_class($data[1]) }}
      </td>
      <td>
        শাখাঃ {{ bangla_section(Auth::user()->school->section_type, $data[1], $data[2]) }}
      </td>
      <td width="20%">
        মোট শিক্ষার্থীঃ {{ bangla($students->count()) }}
      </td>
    </tr>
    <tr>
      <td>
        শ্রেণি শিক্ষকের নামঃ
      </td>
      <td>
        তারিখঃ
      </td>
      <td>
        শিক্ষাবর্ষঃ {{ bangla($data[0]) }}
      </td>
    </tr>
  </table>
  <table class="maintable">
    <tr>
      <th>রোল</th>
      <th>আইডি<br/>মোবাইল নং</th>
      <th>শিক্ষার্থীর নাম<br/>পিতার নাম</th>
      <th>গ্রাম<br/>ডাকঘর</th>
      <th width="10%"></th>
      <th width="10%"></th>
      <th width="10%"></th>
    </tr>
    @foreach($students as $student)
    <tr>
      <td>{{ $student->roll }}</td>
      <td>{{ $student->student_id }}<br/>{{ $student->contact }}</td>
      <td>{{ $student->name }}<br/>{{ $student->father }}</td>
      <td>{{ $student->village }}<br/>{{ $student->post_office }}</td>
      <td></td>
      <td></td>
      <td></td>
    </tr>
    @endforeach
  </table>
</body>
</html>