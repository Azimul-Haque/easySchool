<html>
<head>
  <title>Collection List | PDF</title>
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
        <p style="text-align: center; font-size: 20px;">
          <center>
            <b>{{ Auth::user()->school->name_bangla }}</b><br/>
            <span style="font-size: 15px;">
              স্থাপিতঃ {{ bangla(Auth::user()->school->established) }} ইংরেজি | ইআইআইএনঃ {{ bangla(Auth::user()->school->eiin) }}<br/>
              <span style="font-size: 15px;">
                <b>শ্রেণিঃ {{ bangla_class($data[1]) }}, শাখাঃ @if($data[2] != 'null') {{ bangla_section(Auth::user()->school->section_type, $data[1], $data[2]) }}, @else সকল,@endif শিক্ষাবর্ষঃ {{ bangla($data[0]) }}</b>
              </span><br/>
              <span style="font-size: 20px;"><u>আদায় বিবরণী ({{ bangla(date('F d, Y', strtotime($data[3]))) }} - {{ bangla(date('F d, Y', strtotime($data[4]))) }})</u></span><br/>
            </span>
          </center>
        </p>
      </td>
      <td width="18%"></td>
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
            <th width="3.5%">ক্রঃ নঃ</th>
            <th width="6%">তারিখ</th>
            <th width="5%">রোল</th>
            <th width="6%">আইডি</th>
            <th width="17%">নাম</th>
            <th width="6.1%">রশিদ নং</th>
            <th width="4.7%" style="font-size: 11px;">ভর্তি ফি/ সেশন চাজ</th>
            <th width="4.7%" style="font-size: 11px;">বার্ষিক ক্রীড়া/ সাংস্কৃ: অনুষ্ঠান</th>
            <th width="4.7%" style="font-size: 11px;">গত বছরের বকেয়া</th>
            <th width="4.7%" style="font-size: 10.5px;">পরীক্ষা ফি অর্ধবার্ষিক/ বার্ষিক/ নির্বাচনি/ মডেল টেস্ট</th>
            <th width="4.7%" style="font-size: 11px;">ফুলফ্রি/ হাফফ্রি ফরম</th>
            <th width="4.7%" style="font-size: 11px;">৩/৬/৯/১২ মাসের বেতন	</th>
            <th width="4.7%" style="font-size: 10.5px;">জেএসসি/ এসএসসি রেজি:/ ফরম ফিল আপ</th>
            <th width="4.7%" style="font-size: 10.5px;">প্রশংসা/ প্রত্যয়ন পত্র /টিসি/ মার্কশীট /সনদ পত্র</th>
            <th width="4.7%" style="font-size: 11px;">স্কাউট/ গার্লস গাইড ফি</th>
            <th width="4.7%" style="font-size: 11px;">উন্নয়ন/ দান</th>
            <th width="4.7%" style="font-size: 11px;">বিবিধ</th>
            <th width="4.7%">মোট (৳)</th>
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
        $total_admission_session_fee = 0;
        $total_annual_sports_cultural = 0;
        $total_last_year_due = 0;
        $total_exam_fee = 0;
        $total_full_half_free_form = 0;
        $total_3_6_8_12_fee = 0;
        $total_jsc_ssc_form_fee = 0;
        $total_certificate_fee = 0;
        $total_scout_fee = 0;
        $total_develoment_donation = 0;
        $total_other_fee = 0;
        // dd($collectiongroup);
      @endphp
      @foreach ($collectiongroup as $datekey => $datecollections)
        @foreach ($datecollections as $studentidkey => $studentidcollections)
          @php
            $total_single_student_fee = 0;
          @endphp
          <tr>
            <td align="center">{{ $count_key = $count_key + 1 }}</td>
            <td align="center">{{ date('d-m-y', strtotime($datekey)) }}</td>
            <td align="center">{{ $studentidcollections[0]->roll }} @if($data[1] == 'All_Classes') ({{ $studentidcollections[0]->class }}{{ english_section_short(Auth::user()->school->section_type, $studentidcollections[0]->class, $studentidcollections[0]->section) }}) @endif</td>
            <td align="center">{{ $studentidkey }}</td>
            <td style="font-size: 12px;">{{ $studentidcollections[0]->student->name }}</td>
            <td align="center" style="font-size: 12px;">{{ $studentidcollections[0]->receipt_no }}</td>
            <td align="center">
              @php
                $total_single_student_single_sector_fee = 0;
              @endphp
              @foreach ($studentidcollections as $collection)
                @if ($collection->fee_attribute == 'admission_session_fee')
                  @php
                    $total_single_student_single_sector_fee = $total_single_student_single_sector_fee + $collection->fee_value;
                    $total_single_student_fee = $total_single_student_fee + $collection->fee_value;
                    $total_admission_session_fee = $total_admission_session_fee + $collection->fee_value;
                  @endphp
                @endif
              @endforeach
              {{ $total_single_student_single_sector_fee == 0 ? '' : $total_single_student_single_sector_fee }}
            </td>
            <td align="center">
              @php
                $total_single_student_single_sector_fee = 0;
              @endphp
              @foreach ($studentidcollections as $collection)
                @if ($collection->fee_attribute == 'annual_sports_cultural')
                  @php
                    $total_single_student_single_sector_fee = $total_single_student_single_sector_fee + $collection->fee_value;
                    $total_single_student_fee = $total_single_student_fee + $collection->fee_value;
                    $total_annual_sports_cultural = $total_annual_sports_cultural + $collection->fee_value;
                  @endphp
                @endif
              @endforeach
              {{ $total_single_student_single_sector_fee == 0 ? '' : $total_single_student_single_sector_fee }}
            </td>
            <td align="center">
              @php
                $total_single_student_single_sector_fee = 0;
              @endphp
              @foreach ($studentidcollections as $collection)
                @if ($collection->fee_attribute == 'last_year_due')
                  @php
                    $total_single_student_single_sector_fee = $total_single_student_single_sector_fee + $collection->fee_value;
                    $total_single_student_fee = $total_single_student_fee + $collection->fee_value;
                    $total_last_year_due = $total_last_year_due + $collection->fee_value;
                  @endphp
                @endif
              @endforeach
              {{ $total_single_student_single_sector_fee == 0 ? '' : $total_single_student_single_sector_fee }}
            </td>
            <td align="center">
              @php
                $total_single_student_single_sector_fee = 0;
              @endphp
              @foreach ($studentidcollections as $collection)
                @if ($collection->fee_attribute == 'exam_fee')
                  @php
                    $total_single_student_single_sector_fee = $total_single_student_single_sector_fee + $collection->fee_value;
                    $total_single_student_fee = $total_single_student_fee + $collection->fee_value;
                    $total_exam_fee = $total_exam_fee + $collection->fee_value;
                  @endphp
                @endif
              @endforeach
              {{ $total_single_student_single_sector_fee == 0 ? '' : $total_single_student_single_sector_fee }}
            </td>
            <td align="center">
              @php
                $total_single_student_single_sector_fee = 0;
              @endphp
              @foreach ($studentidcollections as $collection)
                @if ($collection->fee_attribute == 'full_half_free_form')
                 @php
                  $total_single_student_single_sector_fee = $total_single_student_single_sector_fee + $collection->fee_value;
                  $total_single_student_fee = $total_single_student_fee + $collection->fee_value;
                  $total_full_half_free_form = $total_full_half_free_form + $collection->fee_value;
                 @endphp
                @endif
              @endforeach
              {{ $total_single_student_single_sector_fee == 0 ? '' : $total_single_student_single_sector_fee }}
            </td>
            <td align="center">
              @php
                $total_single_student_single_sector_fee = 0;
              @endphp
              @foreach ($studentidcollections as $collection)
                @if ($collection->fee_attribute == '3_6_8_12_fee')
                  @php
                    $total_single_student_single_sector_fee = $total_single_student_single_sector_fee + $collection->fee_value;
                    $total_single_student_fee = $total_single_student_fee + $collection->fee_value;
                    $total_3_6_8_12_fee = $total_3_6_8_12_fee + $collection->fee_value;
                  @endphp
                @endif
              @endforeach
              {{ $total_single_student_single_sector_fee == 0 ? '' : $total_single_student_single_sector_fee }}
            </td>
            <td align="center">
              @php
                $total_single_student_single_sector_fee = 0;
              @endphp
              @foreach ($studentidcollections as $collection)
                @if ($collection->fee_attribute == 'jsc_ssc_form_fee')
                  @php
                    $total_single_student_single_sector_fee = $total_single_student_single_sector_fee + $collection->fee_value;
                    $total_single_student_fee = $total_single_student_fee + $collection->fee_value;
                    $total_jsc_ssc_form_fee = $total_jsc_ssc_form_fee + $collection->fee_value;
                  @endphp
                @endif
              @endforeach
              {{ $total_single_student_single_sector_fee == 0 ? '' : $total_single_student_single_sector_fee }}
            </td>
            <td align="center">
              @php
                $total_single_student_single_sector_fee = 0;
              @endphp
              @foreach ($studentidcollections as $collection)
                @if ($collection->fee_attribute == 'certificate_fee')
                  @php
                    $total_single_student_single_sector_fee = $total_single_student_single_sector_fee + $collection->fee_value;
                    $total_single_student_fee = $total_single_student_fee + $collection->fee_value;
                    $total_certificate_fee = $total_certificate_fee + $collection->fee_value;
                  @endphp
                @endif
              @endforeach
              {{ $total_single_student_single_sector_fee == 0 ? '' : $total_single_student_single_sector_fee }}
            </td>
            <td align="center">
              @php
                $total_single_student_single_sector_fee = 0;
              @endphp
              @foreach ($studentidcollections as $collection)
                @if ($collection->fee_attribute == 'scout_fee')
                  @php
                    $total_single_student_single_sector_fee = $total_single_student_single_sector_fee + $collection->fee_value;
                    $total_single_student_fee = $total_single_student_fee + $collection->fee_value;
                    $total_scout_fee = $total_scout_fee + $collection->fee_value;
                  @endphp
                @endif
              @endforeach
              {{ $total_single_student_single_sector_fee == 0 ? '' : $total_single_student_single_sector_fee }}
            </td>
            <td align="center">
              @php
                $total_single_student_single_sector_fee = 0;
              @endphp
              @foreach ($studentidcollections as $collection)
                @if ($collection->fee_attribute == 'develoment_donation')
                  @php
                    $total_single_student_single_sector_fee = $total_single_student_single_sector_fee + $collection->fee_value;
                    $total_single_student_fee = $total_single_student_fee + $collection->fee_value;
                    $total_develoment_donation = $total_develoment_donation + $collection->fee_value;
                  @endphp
                @endif
              @endforeach
              {{ $total_single_student_single_sector_fee == 0 ? '' : $total_single_student_single_sector_fee }}
            </td>
            <td align="center">
              @php
                $total_single_student_single_sector_fee = 0;
              @endphp
              @foreach ($studentidcollections as $collection)
                @if ($collection->fee_attribute == 'other_fee')
                  @php
                    $total_single_student_single_sector_fee = $total_single_student_single_sector_fee + $collection->fee_value;
                    $total_single_student_fee = $total_single_student_fee + $collection->fee_value;
                    $total_other_fee = $total_other_fee + $collection->fee_value;
                  @endphp
                @endif
              @endforeach
              {{ $total_single_student_single_sector_fee == 0 ? '' : $total_single_student_single_sector_fee }}
            </td>
            <td align="center">
              <b>{{ $total_single_student_fee }}</b>
            </td>
          </tr>                
        @endforeach            
      @endforeach            
    </tbody>
    <tfoot>
      <tr>
        <td colspan="6" align="right">মোট (৳)</td>
        <th>{{ $total_admission_session_fee }}</th>
        <th>{{ $total_annual_sports_cultural }}</th>
        <th>{{ $total_last_year_due }}</th>
        <th>{{ $total_exam_fee }}</th>
        <th>{{ $total_full_half_free_form }}</th>
        <th>{{ $total_3_6_8_12_fee }}</th>
        <th>{{ $total_jsc_ssc_form_fee }}</th>
        <th>{{ $total_certificate_fee }}</th>
        <th>{{ $total_scout_fee }}</th>
        <th>{{ $total_develoment_donation }}</th>
        <th>{{ $total_other_fee }}</th>
        <th align="center">{{ $total_admission_session_fee + $total_annual_sports_cultural + $total_last_year_due + $total_exam_fee + $total_full_half_free_form + $total_3_6_8_12_fee + $total_jsc_ssc_form_fee + $total_certificate_fee + $total_scout_fee + $total_develoment_donation + $total_other_fee }}</th>
      </tr>
    </tfoot>
</table>
</body>
</html>