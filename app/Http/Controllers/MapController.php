<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Mapper;

class MapController extends Controller
{
    public function test()
    {
        Mapper::map(53.381128999999990000, -1.470085000000040000);

    	return view('map.index');
    }
}
