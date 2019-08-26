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
        Mapper::map(23.777176, 90.399452, ['zoom' => 7.5]);
        Mapper::marker(25.9948918,88.3330153);

    	return view('map.index');
    }
}
