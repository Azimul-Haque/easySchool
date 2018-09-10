<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Setting;

class SettingController extends Controller
{
    public function __construct(){
        $this->middleware('role:headmaster');
    }

    public function edit()
    {
        $settings = Setting::find(1);
        return view('settings.edit')->withSettings($settings);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'currentsession' => 'required',
            'classes' => 'required',
        ]);

        $settings = Setting::find(1);
        $settings->currentsession = $request->currentsession;
        $settings->classes = implode (", ", $request->classes);
        
        $settings->save();

        return redirect()->route('settings.edit')
                        ->with('success','Settings updated successfully!');
    }
}
