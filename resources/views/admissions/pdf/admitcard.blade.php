<html>
<head>
  <title>{{ $application->application_id }} | Admit Card | PDF</title>
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
  .wrapper {
    border: 1px solid #333333;
    border-radius: 5px;
    padding: 5px;
  }
  @page {
    header: page-header;
    footer: page-footer;
  }
  </style>
</head>
<body>
  <div class="wrapper">
    <table>
      <tr>
        <td width="17%">
          @if($application->school->monogram != null || $application->school->monogram != '')
            <img src="{{ public_path('images/schools/monograms/'.$application->school->monogram) }}" height="120" width="120" style="float: left !important;">
          @else
            
          @endif
        </td>
        <td style="padding: 5px;">
          <p style="text-align: center; font-size: 22px;">
            <center>
              <b>{{ $application->school->name_bangla }}</b><br/>
              <span style="font-size: 15px;">
                {{ $application->school->address }}, {{ $application->school->upazilla }}, {{ $application->school->district }} <br/>
                স্থাপিতঃ {{ bangla($application->school->established) }} ইংরেজি | ইআইআইএনঃ {{ bangla($application->school->eiin) }}<br/>
                <p style="font-size: 20px;">
                  <u><b><span>প্রবেশপত্র</span></b></u>
                </p>
                <span style="font-size: 18px;">
                  <u>{{ bangla_class($application->class) }} শ্রেণিতে ভর্তি পরীক্ষা-{{ bangla($application->school->admission_session) }} খ্রিঃ</u>
                </span>
              </span>
            </center>
          </p>
        </td>
        <td width="17%">
          @if($application->image != null || $application->image != '')
            <img src="{{ public_path('images/admission-images/'.$application->image) }}" height="110" width="110" style="float: right; border: 1px solid #666;">
          @else
            <img src="{{ public_path('images/dummy_student.jpg') }}" height="110" width="110" style="float: right; border: 1px solid #666;">
          @endif
        </td>
      </tr>
    </table>
    <table class="maintable" style="margin-bottom: 5px;">
      <tr>
        <td width="40%">আবেদনকারী শিক্ষার্থীর নামঃ (ইংরেজিতে)</td>
        <td>{{ $application->name }}</td>
      </tr>
      <tr>
        <td>পিতার নামঃ (ইংরেজিতে)</td>
        <td>{{ $application->father }}</td>
      </tr>
      <tr>
        <td>আবেদন আইডিঃ</td>
        <td>{{ $application->application_id }}</td>
      </tr>
      <tr>
        <td>ভর্তি পরীক্ষার রোলঃ</td>
        <td>{{ $application->application_roll }}</td>
      </tr>
    </table>
    <span style="font-size: 13px;">
      <small>
        <i>সাধারণ নির্দেশাবলীঃ<br/>
      {{--     ১। ভর্তি পরীক্ষার তারিখঃ {{ bangla(date('d/m/Y', strtotime($application->school->admission_test_datetime))) }} ইং, রোজঃ {{ bangla(date('l', strtotime($application->school->admission_test_datetime))) }}, সময়ঃ {{ bangla(date('H:i a', strtotime($application->school->admission_test_datetime))) }}, ভর্তি পরীক্ষার স্থানঃ বিদ্যালয় প্রাঙ্গণ।<br/>
          ২। পরীক্ষার বিষয ও মান বন্টনঃ  {{ bangla_class($application->class - 1) }} শ্রেণীর বই থেকে  বাংলা-{{ bangla($application->school->admission_bangla_mark) }},  ইংরেজী-{{ bangla($application->school->admission_english_mark) }},  গণিত-{{ bangla($application->school->admission_math_mark) }}
           @if($application->school->admission_gk_mark > 0)
            , সাঃ জ্ঞান-{{ bangla($application->school->admission_gk_mark) }};
           @else
           ;
           @endif
           মোট {{ bangla($application->school->admission_total_marks) }} নম্বর।<br/>
          ৩। ফলাফল প্রকাশঃ {{ bangla(date('d/m/Y', strtotime($application->school->admission_test_result))) }} ইং, রোজঃ {{ bangla(date('l', strtotime($application->school->admission_test_result))) }}, সময়ঃ {{ bangla(date('H:i a', strtotime($application->school->admission_test_result))) }} <br/>
          ৪। ভর্তির  তারিখঃ  {{ bangla(date('d/m/Y', strtotime($application->school->admission_final_start))) }} ইং হতে {{ bangla(date('d/m/Y', strtotime($application->school->admission_final_end))) }} ইং পর্যন্ত। বই বিতরণঃ  ভর্তি হওয়ার পর, প্রতিদিন দুপুর ১২ টা হতে।<br/>
          ৫। ভর্তি পরীক্ষায় উত্তীর্ণের পর ভর্তির জন্য সমাপনী পাসের প্রশংসা পত্র সহ ২ নং ফরমটি পূরণ করে জমা দিতে হবে।<br/>
          ৬।  ভর্তির পর জানুয়ারী মাসের মধ্যে মার্কশিট ও জন্ম নিবন্ধন সনদ জমা দিতে হবে। <br/>
          ৭। ভর্তি পরীক্ষার দিন প্রবেশ পত্র অবশ্যই আনতে হবে। <br/> --}}
          {!! $application->school->admit_card_texts !!}
        </i>
      </small>
    </span>
    <table style="margin-top: -10px;">
      <tr>
        <td width="80%"></td>
        <td>
          <center>
            @if($application->school->headmaster_sign != null && $application->school->headmaster_sign != '')
            <img src="{{ public_path('images/schools/signs/'.$application->school->headmaster_sign) }}">
            @endif
            প্রধান শিক্ষক
          </center>
        </td>
      </tr>
    </table>
  </div>

  <htmlpagefooter name="page-footer">
    <small style="font-family: Calibri; color: #6D6E6A;">Powered by EasySchool.XYZ</small>
  </htmlpagefooter>
</body>
</html>