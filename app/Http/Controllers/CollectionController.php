<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class CollectionController extends Controller
{
    public function __construct() {
        $this->middleware('role:headmaster', ['except' => ['getSubmissionPage']]);
        //$this->middleware('permission:theSpecificPermission', ['only' => ['create', 'store', 'edit', 'delete']]);
    }
    
    public function index()
    {
        return view('collection.index');
    }
}
