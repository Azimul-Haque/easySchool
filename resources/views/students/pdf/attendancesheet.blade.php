<html>
<head>
  <title>Attenfance Sheet | PDF</title>
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
    padding: 4px 1px 4px 1px;
    font-family: 'kalpurush', sans-serif;
    font-size: 11px;
  }
  @page {
    header: page-header;
    footer: page-footer;
  }
  </style>
</head>
<body>
  <htmlpageheader name="page-header">
    <table class="">
      <tr>
        <td width="18%">
          @if(Auth::user()->school->monogram != null || Auth::user()->school->monogram != '')
            <img src="{{ public_path('images/schools/monograms/'.Auth::user()->school->monogram) }}" height="50" width="50" style="float: left !important;">
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
              উপস্থিতি তালিকা/ হাজিরা খাতা
            </span>
          </center>
        </td>
      </tr>
      <tr>
        <td>
          শ্রেণিঃ {{ bangla_class($data[1]) }}
        </td>
        <td>
          শাখাঃ {{ bangla_section(Auth::user()->school->section_type, $data[1], $data[2]) }}
        </td>
        <td>
          মোট শিক্ষার্থীঃ {{ bangla($students->count()) }}
        </td>
      </tr>
      <tr>
        <td>
          মাসঃ
        </td>
        <td>
          ................
        </td>
        <td>
          সালঃ ................
        </td>
      </tr>
    </table>
  </htmlpageheader>
  
  <table class="maintable">
    <tr>
      <th>শিক্ষার্থীর নাম</th>
      <th>রোল</th>
      @for($i = 1; $i <= 31; $i++)
      <th>{{ bangla(str_pad($i, 2, '0', STR_PAD_LEFT)) }}</th>
      @endfor
      <th>মোট উপ<br/>স্থিতি</th>
    </tr>
    @php
      $counter = 1;
    @endphp
    @foreach($students as $student)
    <tr>
      <td>
        @if(strlen($student->name) > 30)
          <span style="font-size: 8.5px;">{{ $student->name }}</span>
        @else
          {{ $student->name }}
        @endif
      </td>
      <th>{{ $student->roll }}</th>
      @for($j = 1; $j <= 31; $j++)
      <td></td>
      @endfor
      <td></td>
    </tr>
    @if($counter%35 == 0)
    </table>
     <pagebreak></pagebreak>
    <table class="maintable">
      <tr>
        <th>শিক্ষার্থীর নাম</th>
        <th>রোল</th>
        @for($k = 1; $k <= 31; $k++)
        <th>{{ bangla(str_pad($k, 2, '0', STR_PAD_LEFT)) }}</th>
        @endfor
        <th>মোট উপ<br/>স্থিতি</th>
      </tr>
    @endif
    @php
      $counter++;
    @endphp
    @endforeach
  </table>
</body>
</html>