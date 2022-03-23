<html>
<head>
  <title>Collection Sector Wise | PDF</title>
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
      <td width="5%">
      </td>
      <td>
        <p style="text-align: center; font-size: 20px;">
          <center>
            <b>{{ Auth::user()->school->name_bangla }}</b><br/>
            <span style="font-size: 15px;">
              স্থাপিতঃ {{ bangla(Auth::user()->school->established) }} ইংরেজি | ইআইআইএনঃ {{ bangla(Auth::user()->school->eiin) }}<br/>
              <span style="font-size: 15px;">
                <b>শ্রেণিঃ {{ bangla_class($data[1]) }}, শাখাঃ @if($data[2] != 'null') {{ bangla_section(Auth::user()->school->section_type, $data[1], $data[2]) }}, @else সকল,@endif শিক্ষাবর্ষঃ {{ bangla($data[0]) }}</b>
              </span><br/>
              <span style="font-size: 18px;">({{ bangla(date('F d, Y', strtotime($data[3]))) }} - {{ bangla(date('F d, Y', strtotime($data[4]))) }})</span><br/>
              <span style="font-size: 20px;"><u>খাতওয়ারী আদায় - {{ collection_sector_bangla($data[5]) }}</u></span><br/>
            </span>
          </center>
        </p>
      </td>
      <td width="5%"></td>
    </tr>
  </table>
  {{-- <table class="maintable">
    <tr>
      <th width="25%">মোট পরীক্ষার্থীঃ {{ bangla(count($results)) }} জন</th>
      <th width="25%">অংশগ্রহণকারীঃ  {{ bangla(count($results) - count($results->where('total_marks', 0))) }} জন</th>
      <th width="25%">উত্তীর্ণঃ {{ bangla(count($results) - count($results->where('grade', 'F'))) }} জন</th>
      <th width="25%">অকৃতকার্যঃ {{ bangla((count($results) - count($results->where('total_marks', 0))) - (count($results) - count($results->where('grade', 'F')))) }} জন</th> 
    </tr>
  </table> --}}
  <table class="maintable" id="" style="margin-top: 5px;">
    {{-- datatable-students --}}
    <thead>
        <tr>
            {{-- <th class="hiddenCheckbox" id="hiddenCheckbox"></th> --}}
            <th width="7%">ক্রঃ নঃ</th>
            <th width="13%">তারিখ</th>
            <th width="10%">রোল</th>
            <th width="13%">আইডি</th>
            <th width="30%">নাম</th>
            <th width="11%">রশিদ নং</th>
            <th width="16%" style="font-size: 11px;">{{ collection_sector_bangla($data[5]) }}</th>
        </tr>
    </thead>
    <tbody>
      @php
        $count_key = 0;
        $collectiongroup = [];
        foreach ($usedstudentids as $studentid) {
          foreach ($feecollections as $collection) {
            if($studentid->student_id == $collection->student_id && $studentid->collection_date == $collection->collection_date) {
              $collectiongroup[$studentid->collection_date][$studentid->student_id][] = $collection;
            }
          } 
        }
        $total_attribute_fee = 0;
        // dd($collectiongroup);
      @endphp
      @foreach ($collectiongroup as $datekey => $datecollections)
        @foreach ($datecollections as $studentidkey => $studentidcollections)
          <tr>
            <td align="center">{{ $count_key = $count_key + 1 }}</td>
            <td align="center">{{ date('d-m-y', strtotime($datekey)) }}</td>
            <td align="center">{{ $studentidcollections[0]->roll }} @if($data[1] == 'All_Classes') ({{ $studentidcollections[0]->class }}{{ english_section_short(Auth::user()->school->section_type, $studentidcollections[0]->class, $studentidcollections[0]->section) }}) @endif</td>
            <td align="center">{{ $studentidkey }}</td>
            <td style="font-size: 12px;">{{ $studentidcollections[0]->student->name }}</td>
            <td align="center" style="font-size: 12px;">{{ $studentidcollections[0]->receipt_no }}</td>
            <td align="center">
              @php
                $total_single_student_attribute_fee = 0;
              @endphp
              @foreach ($studentidcollections as $collection)
                @php
                    $total_single_student_attribute_fee = $total_single_student_attribute_fee + $collection->fee_value;
                    $total_attribute_fee = $total_attribute_fee + $collection->fee_value;
                @endphp
              @endforeach
              {{ $total_single_student_attribute_fee == 0 ? '' : $total_single_student_attribute_fee }}
            </td>
          </tr>                
        @endforeach            
      @endforeach            
    </tbody>
    <tfoot>
      <tr>
        <td colspan="6" align="right">মোট (৳)</td>
        <th>{{ $total_attribute_fee }}</th>
      </tr>
    </tfoot>
</table>
</body>
</html>