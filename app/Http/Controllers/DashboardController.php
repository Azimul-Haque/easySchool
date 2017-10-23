<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use Validator, Input, Redirect, Session;

class DashboardController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index()
    {
    	Session::flash('success', 'Landed Succesfully!');
        return view('dashboard');
    }
}
