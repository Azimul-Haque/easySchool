<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Mapper;
use App\Districtscord;

class MapController extends Controller
{
    public function __construct()
    {
        
    }
    
    public function test()
    {
        $districts = Districtscord::where('cordx', '>', 0)->get();

    	return view('map.index')->withDistricts($districts);
    }
}
