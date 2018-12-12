<div id="myCarousel" class="carousel slide" data-ride="carousel">
    <!-- Indicators -->
    <ol class="carousel-indicators">
      <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
      <li data-target="#myCarousel" data-slide-to="1"></li>
      <li data-target="#myCarousel" data-slide-to="2"></li>
    </ol>

    <!-- Wrapper for slides -->
    <div class="carousel-inner">

      <div class="item active">
        <img src="{{ asset('images/slider/1.jpg') }}" alt="শিক্ষার্থী ভর্তি প্রক্রিয়া" style="width:100%;">
        <div class="carousel-caption">
          {{-- <h3>শিক্ষার্থী ভর্তি প্রক্রিয়া</h3>
          <p>সম্পূর্ণ ভর্তি প্রক্রিয়া (অনলাইন আবেদন, মেধা তালিকা প্রস্তুতি এবং চূড়ান্ত ভর্তি)</p> --}}
        </div>
      </div>

      <div class="item">
        <img src="{{ asset('images/slider/2.jpg') }}" alt="শিক্ষার্থী ব্যবস্থাপনা" style="width:100%;">
        <div class="carousel-caption">
          {{-- <h3>শিক্ষার্থী ব্যবস্থাপনা</h3>
          <p>শিক্ষার্থী ব্যবস্থাপনা (হাজিরা খাতা, বেতন আদায় রেজিস্টার, টটলিস্টসহ ইত্যাদি তালিকা তৈরি)</p> --}}
        </div>
      </div>
    
      <div class="item">
        <img src="{{ asset('images/slider/3.jpg') }}" alt="রেজাল্ট জেনারেশন সিস্টেম" style="width:100%;">
        <div class="carousel-caption">
          {{-- <h3>রেজাল্ট জেনারেশন সিস্টেম</h3>
          <p>নম্বর প্রদান, ট্যাব্যুলেশন শিট, মার্কশিট ও ফলাফল তৈরি</p> --}}
        </div>
      </div>
  
    </div>

    <!-- Left and right controls -->
    <a class="left carousel-control" href="#myCarousel" data-slide="prev">
      <span class="glyphicon glyphicon-chevron-left"></span>
      <span class="sr-only">Previous</span>
    </a>
    <a class="right carousel-control" href="#myCarousel" data-slide="next">
      <span class="glyphicon glyphicon-chevron-right"></span>
      <span class="sr-only">Next</span>
    </a>
  </div>
  <br/>