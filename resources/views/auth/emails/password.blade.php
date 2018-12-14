<div style="border: 1px solid #ACACAC; padding: 10px">
  <center>
    <img src="{{ asset('images/icon.png') }}" width="100px; height: auto;">
    <p style="font-size: 25px; color: #1B237D;"><b>Easy</b>School</p>
    <p style="font-size: 20px"><u>আপনার পাসপার্ড রিসেট লিঙ্ক<br/>(Your Password Reset Link)</u></p>
  
    <p style="font-size: 15px">
      আপনার পাসওয়ার্ডটি পরিবর্তন করতে এই লিঙ্কে ক্লিক করুনঃ<br/>
      <a href="{{ $link = url('password/reset', $token).'?email='.urlencode($user->getEmailForPasswordReset()) }}">ক্লিক করুন</a><br/>
      অথবা,<br/>
      <a href="{{ $link = url('password/reset', $token).'?email='.urlencode($user->getEmailForPasswordReset()) }}"> {{ $link }} </a>
    </p>
    <br/><br/>
    <p style="font-size: 11px; color: #ACACAC;">
      This is a auto-generated email from EasySchool. This email arrived to you because you (or may be someone else!) have requested to reset the password associated with this email address. If you are getting this email by mistake, please ignore it.
    </p>
    <p style="font-size: 11px; color: #ACACAC;">
      &copy; @php echo date('Y'); @endphp <a href="http://easyschool.xyz/">EasySchool</a>, 95 Housing Society, Dhaka-1207 Bangladesh
    </p>
  </center>
</div>