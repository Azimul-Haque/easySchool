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
        {{-- <tr>
            <td align="center">{{ $count_key = $count_key + 1 }}</td>
            <td align="center">{{ $studentidcollections[0]->roll }} @if($data[1] == 'All_Classes') ({{ $studentidcollections[0]->class }}{{ english_section_short(Auth::user()->school->section_type, $studentidcollections[0]->class, $studentidcollections[0]->section) }}) @endif</td>
            <td align="center">
                
            </td>

            <td align="center">
            <b>{{ $total_single_student_fee }}</b>
            </td>
        </tr> --}}
        <table>
            <tr>
                <td width="50%" style="border-right: 1px dashed black;">
                    <table style="margin-top: 10px;">
                        <tr>
                            <td>
                                <p style="text-align: center; font-size: 18px;">
                                    <center>
                                        <b>{{ Auth::user()->school->name_bangla }}</b><br/>
                                        <span style="font-size: 14px;">
                                            {{-- adhoc --}}
                                            ডাকঘর-শিবগঞ্জ, উপজেলা ও জেলা- ঠাকুরগাঁও
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
                            <td align="right" style="padding-right: 15px;">রশিদ নং - {{ $studentidcollections[0]->receipt_no }}</td>
                        </tr>
                        <tr>
                            <td style="padding: 15px;">
                                <table class="maintable" style="margin-top: -15px;">
                                    <tr>
                                        <td colspan="3">STUDENT NAME: {{ $studentidcollections[0]->student->name }}</td>
                                    </tr>
                                    <tr>
                                        <td colspan="3">MOBILE NO: {{ $studentidcollections[0]->student->contact }}</td>
                                    </tr>
                                    <tr>
                                        <td>CLASS: {{ $studentidcollections[0]->student->class }}</td>
                                        <td>SECTION: {{ $studentidcollections[0]->student->section }}</td>
                                        <td>ROLL NO: {{ $studentidcollections[0]->student->roll }}</td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">STUDENT ID: {{ $studentidkey }}</td>
                                        <td>DATE: {{ date('d-m-Y', strtotime($datekey)) }}</td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td style="padding: 15px;">
                                <table class="maintable" style="margin-top: -15px;">
                                    <tr>
                                        <th width="10%">ক্রঃ নং</th>
                                        <th width="75%">বিবরণ</th>
                                        <th width="15%">টাকা (৳)</th>
                                    </tr>
                                    <tr>
                                        <td align="center">১</td>
                                        <td>ভর্তি ফি/ সেশন চাজ</td>
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
                                    </tr>
                                    <tr>
                                        <td align="center">২</td>
                                        <td>বার্ষিক ক্রীড়া/ সাংস্কৃ: অনুষ্ঠান</td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td align="center">৩</td>
                                        <td>গত বছরের বকেয়া</td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td align="center">৪</td>
                                        <td>পরীক্ষা ফি অর্ধবার্ষিক/ বার্ষিক/ নির্বাচনি/ মডেল টেস্ট</td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td align="center">৫</td>
                                        <td>ফুলফ্রি/ হাফফ্রি ফরম</td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td align="center">৬</td>
                                        <td>৩/৬/৯/১২ মাসের বেতন</td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td align="center">৭</td>
                                        <td>জেএসসি/ এসএসসি রেজি:/ ফরম ফিল আপ</td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td align="center">৮</td>
                                        <td>প্রশংসা/ প্রত্যয়ন পত্র /টিসি/ মার্কশীট /সনদ পত্র</td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td align="center">৯</td>
                                        <td>স্কাউট/ গার্লস গাইড ফি</td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td align="center">১০</td>
                                        <td>উন্নয়ন/ দান</td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td align="center">১১</td>
                                        <td>বিবিধ</td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td align="right" colspan="2">মোট = </td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td colspan="3">কথায়ঃ</td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td style="padding: 0px 15px 0px 15px;">আদায়কারী/শ্রেণি শিক্ষকের নামঃ </td>
                        </tr>
                    </table>
                </td>
                <td width="50%">
                    <table style="margin-top: 10px;">
                        <tr>
                            <td>
                                <p style="text-align: center; font-size: 18px;">
                                    <center>
                                        <b>{{ Auth::user()->school->name_bangla }}</b><br/>
                                        <span style="font-size: 14px;">
                                            {{-- adhoc --}}
                                            ডাকঘর-শিবগঞ্জ, উপজেলা ও জেলা- ঠাকুরগাঁও
                                            {{-- adhoc --}}
                                        </span><br/>
                                        <span style="font-size: 15px;">
                                            বেতন ও অন্যান্য ফি আদায়ের রশিদ - শিক্ষার্থী কপি
                                        </span><br/>
                                    </center>
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <td align="right" style="padding-right: 15px;">রশিদ নং - </td>
                        </tr>
                        <tr>
                            <td style="padding: 15px;">
                                <table class="maintable" style="margin-top: -15px;">
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
                            <td style="padding: 15px;">
                                <table class="maintable" style="margin-top: -15px;">
                                    <tr>
                                        <th width="10%">ক্রঃ নং</th>
                                        <th width="75%">বিবরণ</th>
                                        <th width="15%">টাকা (৳)</th>
                                    </tr>
                                    <tr>
                                        <td align="center">১</td>
                                        <td>ভর্তি ফি/ সেশন চাজ</td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td align="center">২</td>
                                        <td>বার্ষিক ক্রীড়া/ সাংস্কৃ: অনুষ্ঠান</td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td align="center">৩</td>
                                        <td>গত বছরের বকেয়া</td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td align="center">৪</td>
                                        <td>পরীক্ষা ফি অর্ধবার্ষিক/ বার্ষিক/ নির্বাচনি/ মডেল টেস্ট</td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td align="center">৫</td>
                                        <td>ফুলফ্রি/ হাফফ্রি ফরম</td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td align="center">৬</td>
                                        <td>৩/৬/৯/১২ মাসের বেতন</td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td align="center">৭</td>
                                        <td>জেএসসি/ এসএসসি রেজি:/ ফরম ফিল আপ</td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td align="center">৮</td>
                                        <td>প্রশংসা/ প্রত্যয়ন পত্র /টিসি/ মার্কশীট /সনদ পত্র</td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td align="center">৯</td>
                                        <td>স্কাউট/ গার্লস গাইড ফি</td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td align="center">১০</td>
                                        <td>উন্নয়ন/ দান</td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td align="center">১১</td>
                                        <td>বিবিধ</td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td align="right" colspan="2">মোট = </td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td colspan="3">কথায়ঃ</td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td style="padding: 0px 15px 0px 15px;">আদায়কারী/শ্রেণি শিক্ষকের নামঃ </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table> 
        @endforeach            
    @endforeach          
<htmlpagefooter name="page-footer">
    {{-- <small style="font-family: Calibri; color: #6D6E6A;">Powered by EasySchool.XYZ</small> --}}
</htmlpagefooter>
</body>
</html>