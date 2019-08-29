@extends('adminlte::page')

@section('title', 'Easy School')

@section('css')
	<link rel="stylesheet" type="text/css" href="{{ asset('css/KBmapmarkers.css') }}">
	<style type="text/css">
		.KBmap__markerTitle{
			font-family: Arial;
			color: #56270c;
		}
		.KBmap__mapContainer{
			height: 90vh;
			max-height: 100vh;
		}
		.KBmap__mapHolder{
			height: 100%;
			-webkit-box-shadow: 0px 0px 15px 3px rgba(0, 0, 0, 0.15);
			box-shadow: 0px 0px 15px 3px rgba(0, 0, 0, 0.15);
		}
		.KBmap__mapHolder img{
		    width: auto;
    		height: 100%;
		}
	</style>
@stop

@section('content_header')
    <h1>ম্যাপ</h1>
@stop

@section('content')
	<div class="row">
	  <div class="col-md-8">
	    <section class="KBmap" id="KBtestmap" style="">
        <div class="KBmap__mapContainer"><div class="KBmap__mapHolder"><img src="/images/districts.png" alt="mapa"></div></div>
	    </section>
	  </div>
	  <div class="col-md-4">
	    <button class="btn btn-primary btn-sm" id="changeCords">Test</button>
	  </div>
	</div>
@stop

@section('js')
{{-- <script type="text/javascript" src="{{ asset('js/jquery-3.3.1.slim.min.js') }}"></script> --}}
<script type="text/javascript" src="{{ asset('js/KBmapmarkers.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/KBmapmarkersCords.js') }}"></script>
<script type="text/javascript">
  $(function(){
   // $('a[title]').tooltip();
   // $('button[title]').tooltip();
  });

  var json2 =
  {
  	@foreach($districts as $district)
  	"mapMarker{{ $district->id }}": {
  		"cordX": "{{ $district->cordx }}",
  		"cordY": "{{ $district->cordy }}",
  		"icon": "/images/map-marker.svg",
  		"modal": {
  			"title": "{{ $district->name }}",
  			"content": "<p>ফাইলঃ <a href='/images/districts.png' target='_blank' download>⭳ ডাউনলোড</a></p>"
  		}
  	},
  	@endforeach
  };

  // (function($) {

  //   $(document).ready(function(){

  //     createKBmap('KBtestmap', '/images/districts.png');

  //     KBtestmap.importJSON(json2);

  //     KBtestmap.showAllMapMarkers();

  //   });

  // })(jQuery);

  var myData = {};
  var json = {};
  $('#changeCords').click(function() {
  	for(var i=0; i<10; i++) {
  		var obj = { 
  	        cordX: Math.floor(Math.random() * 100),
  	        cordY: Math.floor(Math.random() * 100),
  	        icon: "/images/map-marker.svg",
  	        modal: {
  	        	"title": "Test"+i,
  	        	"content": "<p>ফাইলঃ <a href='/images/districts.png' target='_blank' download>⭳ ডাউনলোড</a></p>"
  	        }
  	    };
  	    myData['mapMarker'+i] = obj;
  	}
  	json = myData;
  	console.log(json);
  	createKBmap('KBtestmap', '/images/districts.png');

  	KBtestmap.importJSON(json);

  	KBtestmap.showAllMapMarkers();
  });


  
</script>
@stop