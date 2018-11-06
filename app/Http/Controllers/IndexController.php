<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\School;
use Artisan;

class IndexController extends Controller
{
    public function index()
    {
        $schools = School::All();
        return view('index.index')->withSchools($schools);
    }

    // clear configs, routes and serve
    public function clear()
    {
        Artisan::call('config:cache');
        Artisan::call('route:cache');
        Artisan::call('cache:clear');
        Artisan::call('view:clear');
        echo 'Config and Route Cached. All Cache Cleared';
    }
}
