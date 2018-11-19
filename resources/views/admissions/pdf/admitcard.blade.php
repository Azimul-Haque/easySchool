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
    padding: 5px;
    font-family: 'kalpurush', sans-serif;
    font-size: 14px;
  }
  </style>
</head>
<body>
  <table>
    <tr>
      <td width="18%">
        @if($application->school->monogram != null || $application->school->monogram != '')
          <img src="{{ public_path('images/schools/monograms/'.$application->school->monogram) }}" height="120" width="120" style="float: left !important;">
        @else
          
        @endif
      </td>
      <td>
        <p style="text-align: center; font-size: 22px;">
          <center>
            <b>{{ $application->school->name_bangla }}</b><br/>
            <span style="font-size: 15px;">
              {{ $application->school->address }}, {{ $application->school->upazilla }}, {{ $application->school->district }} <br/>
              স্থাপিতঃ {{ bangla($application->school->established) }} ইংরেজি | ইআইআইএনঃ {{ bangla($application->school->eiin) }}<br/><br/>
              <span style="font-size: 22px;">
                <b><u>প্রবেশপত্র</u></b>
              </span><br/><br/>
              <span style="font-size: 18px;">
                <u>{{ bangla_class($application->class) }} শ্রেণিতে ভর্তি পরীক্ষা-{{ bangla($application->school->admission_session) }} খ্রিঃ</u>
              </span>
            </span><br/><br/><br/>
          </center>
        </p>
      </td>
      <td width="18%">
        @if($application->image != null || $application->image != '')
          <img src="{{ public_path('images/admission-images/'.$application->image) }}" height="120" width="120" style="float: right !important; border: 1px solid #666;">
        @else
          <img src="{{ public_path('images/dummy_student.jpg') }}" height="120" width="120" style="float: right !important; border: 1px solid #666;">
        @endif
      </td>
    </tr>
  </table>
  <table class="maintable">
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
  </table><br/>
  <p>
    <small>
      <i>সাধারণ নির্দেশাবলীঃ<br/>
        ১। ভর্তি পরীক্ষার তারিখঃ ০৩/০১/২০১৯ ইং, রোজঃ বৃহস্পতিবার, সময়ঃ সকাল ১০.৩০ ঘটিকা, ভর্তি পরীক্ষার স্থানঃ বিদ্যালয় প্রাঙ্গণ।<br/>
        ২। পরীক্ষার বিষয ও মান বন্টনঃ  ৫ম শ্রেণীর বই থেকে  বাংলা-১৫,  ইংরেজী-১৫,  গণিত-২০ ; মোট ৫০ নম্বর।<br/>
        ৩। ফলাফল প্রকাশঃ ০৩/০১/২০১৯ ইং, রোজঃ বৃহস্পতিবার, সময়ঃ বিকাল ৩.০০ ঘটিকা <br/>
        ৪। ভর্তির  তারিখঃ  ০৩/০১/২০১৯ ইং হতে ০৬/০১/২০১৯ ইং পর্যন্ত। বই বিতরণঃ  ভর্তি হওয়ার পর, প্রতিদিন দুপুর ১২ টা হতে।<br/>
        ৫। ভর্তি পরীক্ষার ফরম পূরণ করে ০২ কপি পাসপোর্ট সাইজের ছবিসহ ০২/০১/২০১৯ইং, বিকাল ৩.০০ টার মধ্যে জমা দিতে হবে।<br/>
        ৬। ভর্তি পরীক্ষায় উত্তীর্ণের পর ভর্তির জন্য সমাপনী পাসের প্রশংসা পত্র সহ ২ নং ফরমটি পূরণ করে জমা দিতে হবে।
        ৭।  ভর্তির পর জানুয়ারী মাসের মধ্যে মার্কশীট ও জন্ম নিবন্ধন সনদ জমা দিতে হবে। <br/>
        ৮। ভর্তি পরীক্ষার দিন প্রবেশ পত্র অবশ্যই আনতে হবে। <br/>
      </i>
    </small>
  </p>
</body>
</html>