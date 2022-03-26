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
    padding: 3px;
    font-family: 'kalpurush', sans-serif;
    font-size: 13px;
  }
  @page {
    margin: 20px 20px;
    header: page-header;
    footer: page-footer;
  }
  </style>
</head>
<body>
    <table>
        <tr>
            <td width="50%">
                <table>
                    <tr>
                        <td>
                            <p style="text-align: center; font-size: 18px;">
                                <center>
                                    <b>{{ Auth::user()->school->name_bangla }}</b><br/>
                                    <span style="font-size: 14px;">
                                        {{-- adhoc --}}
                                        {{-- adhoc --}}
                                        ডাকঘর-শিবগঞ্জ, উপজেলা ও জেলা- ঠাকুরগাঁও
                                        {{-- adhoc --}}
                                        {{-- adhoc --}}
                                    </span><br/>
                                    <span style="font-size: 15px;">
                                        বেতন ও অন্যান্য ফি আদায়ের রশিদ - অফিস কপি
                                    </span><br/>
                                </center>
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding: 10px;">
                            <table class="maintable">
                                <tr>
                                    <td colspan="3">STUDENT NAME:</td>
                                </tr>
                                <tr>
                                    <td colspan="3">MOBILE NO:</td>
                                </tr>
                                <tr>
                                    <td>CLASS:</td>
                                    <td>SECTION:</td>
                                    <td>ROLL NO:</td>
                                </tr>
                                <tr>
                                    <td colspan="2">STUDENT ID:</td>
                                    <td>DATE:</td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding: 10px;">
                            <table class="maintable" style="margin-top: -10px;">
                                <tr>
                                    <th width="15%">ক্রঃ নং</th>
                                    <th width="75%">বিবরণ</th>
                                    <th width="20%">টাকা (৳)</th>
                                </tr>
                                <tr>
                                    <td>১</td>
                                    <td>ভর্তি ফি/ সেশন চাজ</td>
                                </tr>
                                <tr>
                                    <td>১</td>
                                    <td>ভর্তি ফি/ সেশন চাজ</td>
                                    <td>বার্ষিক ক্রীড়া/ সাংস্কৃ: অনুষ্ঠান</td>
                                    <td>গত বছরের বকেয়া</td>
                                    <td>পরীক্ষা ফি অর্ধবার্ষিক/ বার্ষিক/ নির্বাচনি/ মডেল টেস্ট</td>
                                    <td>ফুলফ্রি/ হাফফ্রি ফরম</td>
                                    <td>৩/৬/৯/১২ মাসের বেতন</td>
                                    <td>জেএসসি/ এসএসসি রেজি:/ ফরম ফিল আপ</td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </td>
            <td width="50%">
            
            </td>
        </tr>
    </table>
    <table class="maintable" id="" style="">
        {{-- datatable-students --}}
        <thead>
            <tr>
                <th width="5%" style="font-size: 11px;"></th>
                <th width="5%" style="font-size: 11px;">	</th>
                <th width="5%" style="font-size: 10.5px;"></th>
                <th width="5%" style="font-size: 10.5px;">প্রশংসা/ প্রত্যয়ন পত্র /টিসি/ মার্কশীট /সনদ পত্র</th>
                <th width="5%" style="font-size: 11px;">স্কাউট/ গার্লস গাইড ফি</th>
                <th width="5%" style="font-size: 11px;">উন্নয়ন/ দান</th>
                <th width="5%" style="font-size: 11px;">বিবিধ</th> 
                <th width="5%">মোট (৳)</th>--}}
            </tr>
        </thead>
        <tbody>
          @php
            $count_key = 0;
            $collectiongroup = [];
            foreach ($usedstudentids as $studentid) {
              foreach ($feecollections as $collection) {
                if($studentid->collection_date == $collection->collection_date && $studentid->class == $collection->class && $studentid->section == $collection->section) {
                    $collectiongroup[$studentid->collection_date][$studentid->class][$studentid->section][] = $collection;
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
            @foreach ($datecollections as $classkey => $classcollections)
                @foreach ($classcollections as $sectionkey => $sectioncollections)
                    @php
                        $total_single_section_fee = 0;
                    @endphp
                    <tr>
                        <td align="center">{{ $count_key = $count_key + 1 }}</td>
                        <td align="center">{{ date('d-m-y', strtotime($datekey)) }}</td>
                        <td align="center">{{ $sectioncollections[0]->class }}</td>
                        <td align="center">{{ english_section_short(Auth::user()->school->section_type, $sectioncollections[0]->class, $sectioncollections[0]->section) }}</td>
                        <td align="center">{{ $sectioncollections[0]->receipt_no }} হতে {{ $sectioncollections[count($sectioncollections)-1]->receipt_no }}</td>
                        {{-- <td align="center">
                            @php
                                $total_single_section_single_sector_fee = 0;
                            @endphp
                            @foreach ($sectioncollections as $collection)
                                @if ($collection->fee_attribute == 'admission_session_fee')
                                    @php
                                        $total_single_section_single_sector_fee = $total_single_section_single_sector_fee + $collection->fee_value;
                                        $total_single_section_fee = $total_single_section_fee + $collection->fee_value;
                                        $total_admission_session_fee = $total_admission_session_fee + $collection->fee_value;
                                    @endphp
                                @endif
                            @endforeach
                            {{ $total_single_section_single_sector_fee == 0 ? '' : $total_single_section_single_sector_fee }}
                        </td>
                        <td align="center">
                            @php
                                $total_single_section_single_sector_fee = 0;
                            @endphp
                            @foreach ($sectioncollections as $collection)
                                @if ($collection->fee_attribute == 'annual_sports_cultural')
                                    @php
                                        $total_single_section_single_sector_fee = $total_single_section_single_sector_fee + $collection->fee_value;
                                        $total_single_section_fee = $total_single_section_fee + $collection->fee_value;
                                        $total_annual_sports_cultural = $total_annual_sports_cultural + $collection->fee_value;
                                    @endphp
                                @endif
                            @endforeach
                            {{ $total_single_section_single_sector_fee == 0 ? '' : $total_single_section_single_sector_fee }}
                        </td>
                        <td align="center">
                            @php
                                $total_single_section_single_sector_fee = 0;
                            @endphp
                            @foreach ($sectioncollections as $collection)
                                @if ($collection->fee_attribute == 'last_year_due')
                                    @php
                                        $total_single_section_single_sector_fee = $total_single_section_single_sector_fee + $collection->fee_value;
                                        $total_single_section_fee = $total_single_section_fee + $collection->fee_value;
                                        $total_last_year_due = $total_last_year_due + $collection->fee_value;
                                    @endphp
                                @endif
                            @endforeach
                            {{ $total_single_section_single_sector_fee == 0 ? '' : $total_single_section_single_sector_fee }}
                        </td>
                        <td align="center">
                            @php
                                $total_single_section_single_sector_fee = 0;
                            @endphp
                            @foreach ($sectioncollections as $collection)
                                @if ($collection->fee_attribute == 'exam_fee')
                                    @php
                                        $total_single_section_single_sector_fee = $total_single_section_single_sector_fee + $collection->fee_value;
                                        $total_single_section_fee = $total_single_section_fee + $collection->fee_value;
                                        $total_exam_fee = $total_exam_fee + $collection->fee_value;
                                    @endphp
                                @endif
                            @endforeach
                            {{ $total_single_section_single_sector_fee == 0 ? '' : $total_single_section_single_sector_fee }}
                        </td>
                        <td align="center">
                            @php
                                $total_single_section_single_sector_fee = 0;
                            @endphp
                            @foreach ($sectioncollections as $collection)
                                @if ($collection->fee_attribute == 'full_half_free_form')
                                    @php
                                        $total_single_section_single_sector_fee = $total_single_section_single_sector_fee + $collection->fee_value;
                                        $total_single_section_fee = $total_single_section_fee + $collection->fee_value;
                                        $total_full_half_free_form = $total_full_half_free_form + $collection->fee_value;
                                    @endphp
                                @endif
                            @endforeach
                            {{ $total_single_section_single_sector_fee == 0 ? '' : $total_single_section_single_sector_fee }}
                        </td>
                        <td align="center">
                            @php
                                $total_single_section_single_sector_fee = 0;
                            @endphp
                            @foreach ($sectioncollections as $collection)
                                @if ($collection->fee_attribute == '3_6_8_12_fee')
                                    @php
                                        $total_single_section_single_sector_fee = $total_single_section_single_sector_fee + $collection->fee_value;
                                        $total_single_section_fee = $total_single_section_fee + $collection->fee_value;
                                        $total_3_6_8_12_fee = $total_3_6_8_12_fee + $collection->fee_value;
                                    @endphp
                                @endif
                            @endforeach
                            {{ $total_single_section_single_sector_fee == 0 ? '' : $total_single_section_single_sector_fee }}
                        </td>
                        <td align="center">
                            @php
                                $total_single_section_single_sector_fee = 0;
                            @endphp
                            @foreach ($sectioncollections as $collection)
                                @if ($collection->fee_attribute == 'jsc_ssc_form_fee')
                                    @php
                                        $total_single_section_single_sector_fee = $total_single_section_single_sector_fee + $collection->fee_value;
                                        $total_single_section_fee = $total_single_section_fee + $collection->fee_value;
                                        $total_jsc_ssc_form_fee = $total_jsc_ssc_form_fee + $collection->fee_value;
                                    @endphp
                                @endif
                            @endforeach
                            {{ $total_single_section_single_sector_fee == 0 ? '' : $total_single_section_single_sector_fee }}
                        </td>
                        <td align="center">
                            @php
                                $total_single_section_single_sector_fee = 0;
                            @endphp
                            @foreach ($sectioncollections as $collection)
                                @if ($collection->fee_attribute == 'certificate_fee')
                                    @php
                                        $total_single_section_single_sector_fee = $total_single_section_single_sector_fee + $collection->fee_value;
                                        $total_single_section_fee = $total_single_section_fee + $collection->fee_value;
                                        $total_certificate_fee = $total_certificate_fee + $collection->fee_value;
                                    @endphp
                                @endif
                            @endforeach
                            {{ $total_single_section_single_sector_fee == 0 ? '' : $total_single_section_single_sector_fee }}
                        </td>
                        <td align="center">
                            @php
                                $total_single_section_single_sector_fee = 0;
                            @endphp
                            @foreach ($sectioncollections as $collection)
                                @if ($collection->fee_attribute == 'scout_fee')
                                    @php
                                        $total_single_section_single_sector_fee = $total_single_section_single_sector_fee + $collection->fee_value;
                                        $total_single_section_fee = $total_single_section_fee + $collection->fee_value;
                                        $total_scout_fee = $total_scout_fee + $collection->fee_value;
                                    @endphp
                                @endif
                            @endforeach
                            {{ $total_single_section_single_sector_fee == 0 ? '' : $total_single_section_single_sector_fee }}
                        </td>
                        <td align="center">
                            @php
                                $total_single_section_single_sector_fee = 0;
                            @endphp
                            @foreach ($sectioncollections as $collection)
                                @if ($collection->fee_attribute == 'develoment_donation')
                                    @php
                                        $total_single_section_single_sector_fee = $total_single_section_single_sector_fee + $collection->fee_value;
                                        $total_single_section_fee = $total_single_section_fee + $collection->fee_value;
                                        $total_develoment_donation = $total_develoment_donation + $collection->fee_value;
                                    @endphp
                                @endif
                            @endforeach
                            {{ $total_single_section_single_sector_fee == 0 ? '' : $total_single_section_single_sector_fee }}
                        </td> 
                        <td align="center">
                            @php
                                $total_single_section_single_sector_fee = 0;
                            @endphp
                            @foreach ($sectioncollections as $collection)
                                @if ($collection->fee_attribute == 'other_fee')
                                    @php
                                        $total_single_section_single_sector_fee = $total_single_section_single_sector_fee + $collection->fee_value;
                                        $total_single_section_fee = $total_single_section_fee + $collection->fee_value;
                                        $total_other_fee = $total_other_fee + $collection->fee_value;
                                    @endphp
                                @endif
                            @endforeach
                            {{ $total_single_section_single_sector_fee == 0 ? '' : $total_single_section_single_sector_fee }}
                        </td>
                        <td align="center"><b>{{ $total_single_section_fee }}</b></td>--}}
                    </tr>                
                @endforeach            
            @endforeach         
          @endforeach            
        </tbody>
        <tfoot>
          <tr>
            <td colspan="5" align="right">মোট (৳)</td>
            {{-- <th>{{ $total_admission_session_fee }}</th>
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
            <th align="center">{{ $total_admission_session_fee + $total_annual_sports_cultural + $total_last_year_due + $total_exam_fee + $total_full_half_free_form + $total_3_6_8_12_fee + $total_jsc_ssc_form_fee + $total_certificate_fee + $total_scout_fee + $total_develoment_donation + $total_other_fee }}</th> --}}
          </tr>
        </tfoot>
    </table>
  

<htmlpagefooter name="page-footer">
    {{-- <small style="font-family: Calibri; color: #6D6E6A;">Powered by EasySchool.XYZ</small> --}}
</htmlpagefooter>
</body>
</html>