<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use Validator, Input, Redirect, Session;
use Auth;

class DashboardController extends Controller
{

    public function __construct()
    {
        
    }
    
    public function index()
    {
    	//Session::flash('success', 'Landed Succesfully!');
    	//dd(Auth::User()->can('role-list'));
        return view('dashboard');
    }
}
