@extends('layouts.app')

@section('title', 'Easy School')

@section('css')

@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-6 wow fadeInUp" data-wow-duration="300ms">
            <div class="panel panel-primary" style="min-height: 200px;">
                <div class="panel-heading">
                    স্কুল সিলেক্ট করুন
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                              {{-- <strong>জেলাঃ</strong> --}}
                              <select class="form-control" id="district" name="district" required="">
                                <option value="" selected="" disabled="">জেলা নির্ধারণ করুন</option>
                                @foreach($districts as $district)
                                <option value="{{ $district }}">{{ $district }}</option>
                                @endforeach
                              </select>
                            </div> 
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                              {{-- <strong>উপজেলাঃ</strong> --}}
                              <select class="form-control" id="upazilla" name="upazilla" required="" disabled="">
                                <option value="" selected disabled>উপজেলা নির্ধারণ করুন</option>
                              </select>
                            </div>  
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                              {{-- <strong>স্কুলঃ</strong> --}}
                              <select class="form-control" id="school" name="school" required="" disabled="">
                                <option value="" selected disabled>স্কুল নির্বাচন করুন</option>
                              </select>
                            </div>  
                        </div>
                        <div class="col-md-12">
                            <button class="btn btn-primary btn-block" id="gotoschoolbtn" disabled="">স্কুলের পাতায় চলুন</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 wow fadeInUp" data-wow-duration="600ms">
            <div class="panel panel-primary" style="min-height: 200px;">
                <div class="panel-body">
                  <center>
                    <p style="font-size: 30px; color: navy;"><b>Easy</b>School</p>
                    <p style="font-size: 20px;">
                      আপনার স্কুলের সকল কার্যক্রমের সেরা সমাধান!
                    </p>
                    <a href="#contactsection" class="btn btn-success btn-lg">সেবাটি নিতে যোগাযোগ করুন</a>
                  </center>
                </div>
            </div>
        </div>
        <div class="col-md-12">
          @include('partials._slider')
        </div>
    </div>
    <div class="row" style="background: #DDDDDD;" id="featuresection">
      <div class="col-md-3">
        <center>
          <div class="featurebox shadow wow fadeInUp" data-wow-duration="300ms">
            <br/>
            <img src="{{ asset('images/homepageicons/admin.png') }}">
            <h4>প্রধান শিক্ষকের এডমিন প্যানেলের মাধ্যমে কেন্দ্রীয় নিয়ন্ত্রণ</h4>
          </div>
        </center>
      </div>
      <div class="col-md-3">
        <center>
          <div class="featurebox shadow wow fadeInUp" data-wow-duration="600ms">
            <br/>
            <img src="{{ asset('images/homepageicons/teacher.png') }}">
            <h4>শিক্ষকদের পৃথক একাউন্ট ও প্যানেল</h4>
          </div>
        </center>
      </div>
      <div class="col-md-3">
        <center>
          <div class="featurebox shadow wow fadeInUp" data-wow-duration="900ms">
            <br/>
            <img src="{{ asset('images/homepageicons/students.png') }}">
            <h4>শিক্ষার্থীদের তথ্য সংরক্ষণ ও তথ্য ব্যবহার</h4>
          </div>
        </center>
      </div>
      <div class="col-md-3">
        <center>
          <div class="featurebox shadow wow fadeInUp" data-wow-duration="1200ms">
            <br/>
            <img src="{{ asset('images/homepageicons/parents.png') }}">
            <h4>শিক্ষার্থী অভিভাবকের সাথে স্কুলের সরাসরি সেতুবন্ধন</h4>
          </div>
        </center>
        <br/><br/>
      </div>
      <div class="col-md-12">
        <center>
          <div style="max-width: 500px;">
            <img class="img-responsive" src="{{ asset('images/homepageicons/info-graphics-1.png') }}" style="max-width: 100%;">
          </div>
        </center>
        <br/><br/>
      </div>
    </div>
    <div class="row" style="background: #009588; color: #ffffff;" id="pricingsection">
      <div class="col-md-8 wow fadeInUp" data-wow-duration="600ms">
        <p style="font-size: 25px;">
          দেশের সব থেকে কম খরচে আমাদের কাছে পাচ্ছেন অনলাইনভিত্তিক পরিপূর্ণ স্কুল ম্যানেজমেন্ট সফটওয়্যার
          <span style="font-size: 30px;"><b>Easy</b>School</span>
        </p>
        <p style="font-size: 25px; color: #FFFF00;">* আমাদের সফটওয়্যারের কোন Installation ফি নেই!</p>
        <p style="font-size: 25px; color: #FFFF00;">* সর্বনিম্ন রেটে SMS</p>
        <br/><br/>
      </div>
      <div class="col-md-4 wow fadeInUp" data-wow-duration="900ms">
        <div class="panel panel-success">
          <div class="panel-heading" style="font-size: 20px;">
            খরচের তালিকাঃ
          </div>
          <ul class="panel-body list-group" style="background: #eee; color: #555; font-size: 15px;">
            <li class="list-group-item" style="background: #eee;"><b>Easy</b>School বাৎসরিক ফিঃ ৫০০০ টাকা মাত্র</li>
            <li class="list-group-item" style="background: #eee;"><b>SMS</b>: ৩৫ পয়সা (প্রতি SMS) মাত্র</li>
          </ul>
        </div>
      </div>
    </div>
    <div class="row" style="" id="contactsection">
      <div class="col-md-6 wow fadeInUp" data-wow-duration="600ms">
        <h3><i class="fa fa-envelope-o"></i> যোগাযোগ ফর্ম</h3>
        <div class="form-group">
          <input type="text" name="" id="" class="form-control" placeholder="আপনার নাম লিখুন" required="">
        </div>
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <input type="text" name="" id="" class="form-control" placeholder="আপনার ইমেইল এড্রেস লিখুন" required="">
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <input type="text" name="" id="" class="form-control" placeholder="আপনার ফোন নম্বরটি লিখুন" required="">
            </div>
          </div>
        </div>
        <div class="form-group">
          <textarea name="" id="" class="form-control" required="" placeholder="আমাদের যা লিখতে চান..." style="resize: none; height: 100px;"></textarea>
        </div>
        <div class="form-group">
          <button type="button" class="btn btn-primary"><i class="fa fa-paper-plane-o"></i> পাঠিয়ে দিন</button>
        </div>
        <br/><br/>
      </div>
      <div class="col-md-6 wow fadeInUp" data-wow-duration="900ms">
        <h3><i class="fa fa-envelope-o"></i> যোগাযোগ</h3>
        <p style="font-size: 20px;"><i class="fa fa-map-marker"></i> বাংলাদেশ</p>
        <p style="font-size: 20px;"><i class="fa fa-phone"></i> 
          <a href="tel:+8801717480909">+8801717480909</a>, <a href="tel:+8801521550989">+8801521550989</a>
        </p>
        <p style="font-size: 20px;"><i class="fa fa-envelope"></i> <a href="mailto:info@easyschool.xyz">info@easyschool.xyz</a></p>
      </div>
    </div>
</div>
@endsection

@section('js')
    {!!Html::script('js/select2.min.js')!!}
    <script type="text/javascript">
      $(document).ready(function() {
        $('#district').select2();
        $('#upazilla').select2();
        $('#school').select2();
        $('#district').on('change', function() {
          $('#upazilla').prop('disabled', true);
          $('#school').prop('disabled', true);
          $('#gotoschoolbtn').prop('disabled', true);
          $('#upazilla').append('<option value="" selected disabled>লোড হচ্ছে...</option>');
          $('#school').find('option').remove().end().append('<option value="" selected disabled>স্কুল নির্বাচন করুন</option>');

          $.ajax({
            url: "/schools/getupazillas/api/"+$(this).val(), 
            type: "GET",
            success: function(result){
              $('#upazilla')
                  .find('option')
                  .remove()
                  .end()
                  .prop('disabled', false)
                  .append('<option value="" selected disabled>উপজেলা নির্ধারণ করুন</option>')
              ;
              for(var countupazilla = 0; countupazilla < result.length; countupazilla++) {
                //console.log(result[countupazilla]);
                $('#upazilla').append('<option value="'+result[countupazilla]+'">'+result[countupazilla]+'</option>')
              }
            }
          });
        });
        $('#upazilla').on('change', function() {
            $('#school').prop('disabled', true);
            $('#school').append('<option value="" selected disabled>লোড হচ্ছে...</option>');
            $.ajax({
              url: "/schools/getschools/api/"+$('#district').val()+'/'+$('#upazilla').val(), 
              type: "GET",
              success: function(result){
                $('#school')
                    .find('option')
                    .remove()
                    .end()
                    .prop('disabled', false)
                    .append('<option value="" selected disabled>স্কুল নির্বাচন করুন</option>')
                ;
                // console.log(result);
                if(result.length > 0) {
                    for(var countschool = 0; countschool < result.length; countschool++) {
                      $('#school').append('<option value="'+result[countschool].token+'">'+result[countschool].name+'</option>')
                    }
                } else {
                    $('#school').prop('disabled', true);
                    toastr.warning('কোন স্কুল পাওয়া যায়নি!', 'WARNING').css('width', '400px;');
                }
              }
            });
        });
        $('#school').on('change', function() {
            if($(this).val() != null) {
                $('#gotoschoolbtn').prop('disabled', false);
            }
        });
        $('#gotoschoolbtn').on('click', function() {
            window.location.href = window.location.protocol + "//" + window.location.host + "/school/" + $('#school').val();
        });
      });
    </script>
    <script>
    $(document).ready(function(){
      // Add scrollspy to <body>
      $('body').scrollspy({target: ".navbar", offset: 50});

      // Add smooth scrolling on all links inside the navbar
      $("#app-navbar-collapse a").on('click', function(event) {
        // Make sure this.hash has a value before overriding default behavior
        if (this.hash !== "") {
          // Prevent default anchor click behavior
          event.preventDefault();

          // Store hash
          var hash = this.hash;

          // Using jQuery's animate() method to add smooth page scroll
          // The optional number (800) specifies the number of milliseconds it takes to scroll to the specified area
          $('html, body').animate({
            scrollTop: $(hash).offset().top
          }, 800, function(){
       
            // Add hash (#) to URL when done scrolling (default click behavior)
            window.location.hash = hash;
          });
        }  // End if
      });
    });
    </script>
@endsection
