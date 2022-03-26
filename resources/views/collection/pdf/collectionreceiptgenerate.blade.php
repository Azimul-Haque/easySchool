<html>
<head>
  <title>Receipt | PDF</title>
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
    font-size: 12.5px;
  }
  @page {
    margin: 20px 20px;
    header: page-header;
    footer: page-footer;
  }
  </style>
</head>
<body>
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
<htmlpagefooter name="page-footer">
    {{-- <small style="font-family: Calibri; color: #6D6E6A;">Powered by EasySchool.XYZ</small> --}}
</htmlpagefooter>
</body>
</html>