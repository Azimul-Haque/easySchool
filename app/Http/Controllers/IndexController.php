<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\School;

class IndexController extends Controller
{
    public function index()
    {
        $schools = School::All();
        return view('index.index')->withSchools($schools);
    }
}
