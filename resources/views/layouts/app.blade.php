<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-69084535-2"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());

      gtag('config', 'UA-69084535-2');
    </script>
    <!-- Google Tag Manager -->
    <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
    new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
    j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
    'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
    })(window,document,'script','dataLayer','GTM-KR9XJZP');</script>
    <!-- End Google Tag Manager -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" sizes="192x192" href="{{ asset('images/icon.png') }}">
    <meta name="google-site-verification" content="nhnhLU8mlJ-zxpw7sA0qVmtpwr_SM35a9xLIspLsJiw" />
    <title>@yield('title')</title>
    
    {{-- meta tags --}}
    @include('partials._meta')
    {{-- meta tags --}}

    <!-- Fonts -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css" integrity="sha384-XdYbMnZ/QjLh6iI4ogqCTaIjrFk87ip+ekIjefZch0Y+PvJ8CDYtEs1ipDmPorQ+" crossorigin="anonymous">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato:100,300,400,700">

    <!-- Styles -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
    {{-- <link href="{{ elixir('css/app.css') }}" rel="stylesheet"> --}}
    {!!Html::style('css/select2.min.css')!!}
    <link rel="stylesheet" type="text/css" href="{{ asset('css/public.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/animate.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/dist/css/AdminLTE.min.css') }}">
    <style type="text/css">
      #featuresection {padding-top:60px;}
      #pricingsection {padding-top:60px;}
      #contactsection {padding-top:60px;}
    </style>
    @yield('css')
</head>
<!--Start of Tawk.to Script-->
<script type="text/javascript">
var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
(function(){
var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
s1.async=true;
s1.src='https://embed.tawk.to/5c12972c7a79fc1bddf0d445/default';
s1.charset='UTF-8';
s1.setAttribute('crossorigin','*');
s0.parentNode.insertBefore(s1,s0);
})();
</script>
<!--End of Tawk.to Script-->
<body id="app-layout" style="min-height: 500px;">
    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-KR9XJZP"
    height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->
    <nav class="navbar navbar-default navbar-fixed-top">
        <div class="container-fluid">
            <div class="navbar-header">

                <!-- Collapsed Hamburger -->
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                    <span class="sr-only">Toggle Navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>

                <!-- Branding Image -->
                <a class="navbar-brand" href="{{ url('/') }}">
                    <img src="{{ asset('images/icon.png') }}" class="img-circle school-thumnail">
                    <b>Easy</b>School
                </a>
            </div>

            <div class="collapse navbar-collapse" id="app-navbar-collapse">
                <!-- Left Side Of Navbar -->
                <ul class="nav navbar-nav">
                    @if(Request::url() == url('/'))
                    <li><a href="#featuresection"><i class="fa fa-tags"></i> ফিচার</a></li>
                    <li><a href="#pricingsection"><i class="fa fa-diamond"></i> খরচ</a></li>
                    <li><a href="#contactsection"><i class="fa fa-envelope-o"></i> যোগাযোগ</a></li>
                    @else
                    <li><a href="{{ url('/#featuresection') }}"><i class="fa fa-tags"></i> ফিচার</a></li>
                    <li><a href="{{ url('/#pricingsection') }}"><i class="fa fa-diamond"></i> খরচ</a></li>
                    <li><a href="{{ url('/#contactsection') }}"><i class="fa fa-envelope-o"></i> যোগাযোগ</a></li>
                    @endif
                </ul>
                

                <!-- Right Side Of Navbar -->
                <ul class="nav navbar-nav navbar-right">
                    <!-- Authentication Links -->
                    @if (Auth::check())
                        <li><a href="{{ url('/dashboard') }}"><i class="fa fa-tachometer"></i> ড্যাশবোর্ড</a></li>
                    @endif
                    @if (Auth::guest())
                        <li><a href="{{ url('/login') }}"><i class="fa fa-sign-in"></i> লগইন</a></li>
                    @else
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                <i class="fa fa-user"></i> {{ Auth::user()->name }} <span class="caret"></span>
                            </a>

                            <ul class="dropdown-menu" role="menu">
                                <li><a href="{{ url('/logout') }}"><i class="fa fa-btn fa-sign-out"></i>Logout</a></li>
                            </ul>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </nav>
    
    @yield('content')

    <footer class="container-fluid footer">
      <div class="row">
        <div class="col-md-4 wow fadeInUp" data-wow-duration="300ms">
            <a href="{{ url('/') }}"><i class="fa fa-home"></i> নীড় পাতা</a><br/>
            <a href="{{ url('/#pricingsection') }}"><i class="fa fa-diamond"></i> খরচ</a><br/>
            <a href="{{ url('/#contactsection') }}"><i class="fa fa-envelope-o"></i> যোগাযোগ</a><br/>
            <a href="{{ url('/login') }}"><i class="fa fa-sign-in"></i> লগইন</a>
        </div>
        <div class="col-md-4 wow fadeInUp" data-wow-duration="600ms">
            <h5>আপনার ইমেইল অথবা ফোন নম্বরটি দিন</h5>
            <div class="form-inline">
                <input type="" name="" class="form-control">
                <button class="btn btn-success">সাবস্ক্রাইব</button>
            </div>
            <br/>
        </div>
        <div class="col-md-4">
            {{-- social icons --}}
            <p class="wow fadeInUp" data-wow-duration="900ms">
                <a href="https://www.facebook.com/easyschool.xyz" class="fa fa-social fa-facebook facebook-footer"></a>
                <a href="#!" class="fa fa-social fa-twitter twitter-footer"></a>
                <a href="#!" class="fa fa-social fa-google google-footer"></a>
                <a href="#!" class="fa fa-social fa-linkedin linkedin-footer"></a>
                <a href="#!" class="fa fa-social fa-youtube youtube-footer"></a>
                <a href="#!" class="fa fa-social fa-instagram instagram-footer"></a>
            </p>
            <br/><br/>
            <p class="wow fadeInUp" data-wow-duration="1200ms">
                &copy; @php echo date('Y'); @endphp <b>Easy</b>School.XYZ, All Rights Reserved.
            </p>
        </div>
      </div>
    </footer>
    <!-- JavaScripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.3/jquery.min.js" integrity="sha384-I6F5OKECLVtK/BL+8iSLDEHowSAfUo76ZL9+kGAgTRdiByINKJaqTPH/QVNS1VDb" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
    <script src="{{ asset('js/wow.min.js') }}"></script>
    <script>
      new WOW().init();
    </script>
    @yield('js')
    @include('partials._messages')
    <script type="text/javascript">
      $(window).scroll(function() {
        if ($(document).scrollTop() > 20) {
          $('nav').addClass('shrink');
        } else {
          $('nav').removeClass('shrink');
        }
      });
    </script>
</body>
</html>
