<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

use App\School;
use App\Smsrechargehistory;
use Session, Auth, Config;

class SmsController extends Controller
{
    public function __construct(){
        $this->middleware('role:superadmin', ['only' => ['getAdmin', 'rechargeSchoolSMS']]);
        //$this->middleware('permission:theSpecificPermission', ['only' => ['create', 'store', 'edit', 'delete']]);
    }

    public function getAdmin() {
        $actualbalance = 0;
        try {
            $actualbalance = number_format((float) file_get_contents('http://66.45.237.70/balancechk.php?username=01751398392&password=Bulk.Sms.Bd.123'), 2, '.', '');
            // $url = 'http://66.45.237.70/balancechk.php?username=01751398392&password=Bulk.Sms.Bd.123';
            // $url = urlencode($url);
            
            // //  Initiate curl
            // $ch = curl_init();
            // curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            // curl_setopt($ch, CURLOPT_URL,$url);
            // $result=curl_exec($ch);
            // curl_close($ch);

            $actualbalance = number_format((float) $result, 2, '.', '');
            
        } catch (\Exception $e) {
            return $e;
        }

        $schools = School::all();
        $smsrechargehistories = Smsrechargehistory::all();
        $totalsalesms = DB::table('schools')
                        ->select(DB::raw('SUM(smsbalance) as totalsms'))
                        ->first();

        return view('sms.admin')
                    ->withActualbalance($actualbalance)
                    ->withSchools($schools)
                    ->withTotalsalesms($totalsalesms)
                    ->withSmsrechargehistories($smsrechargehistories);
    }

    public function rechargeSchoolSMS(Request $request) {
        $this->validate($request, array(
          'school_id' => 'required',
          'smsamount' => 'required',
          'smsrate' => 'required'
        ));

        $school = School::find($request->school_id);
        $school->smsbalance = $school->smsbalance + $request->smsamount;
        $school->smsrate = $request->smsrate;
        $school->save();

        Session::flash('success', $request->smsamount.' টি মেসেজ যোগ করা হয়েছে!');
        return redirect()->route('sms.admin');
    }

    public function getIndex() {

        return view('sms.index');
    }

    public function getClientRecharge($smscount, $token, $tk) {
        return view('sms.clientrecharge')
                                ->withSmscount($smscount)
                                ->withTk($tk);
    }

    public function storeRechargeRequest(Request $request) 
    {
        $this->validate($request, array(
          'smscount' => 'required',
          'tk'       => 'required',
          'trx_id'   => 'required'
        ));

        $history = new Smsrechargehistory;
        $history->school_id            = Auth::user()->school->id;
        $history->smscount             = $request->smscount;
        $history->tk                   = $request->tk;
        $history->trx_id               = $request->trx_id;
        $history->activation_status    = 0;
        $history->save();

        // send sms
        $url = config('sms.url');
        $text = Auth::user()->school->name.', SMS Count: '. $request->smscount . ', Tk: ' . $request->tk . '/-, Trx ID: ' . $request->trx_id. ', easyechool.xyz';
        $data= array(
            'username'=>config('sms.username'),
            'password'=>config('sms.password'),
            'number'=>"8801751398392", // the admin number to activate SMS balance
            'message'=>"$text"
        );

        $ch = curl_init(); // Initialize cURL
        curl_setopt($ch, CURLOPT_URL,$url);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_exec($ch);
        // send sms

        Session::flash('success', 'আপনার পেমেন্ট ভেরিফাই করা হবে এবং রিচার্জ করা হবে। ধন্যবাদ। দয়া করে ঘন্টাখানিক অপেক্ষা করুন।');
        return redirect()->route('sms.index');
    }

    public function destroyRechargeReqHistory($id) {
        $history = Smsrechargehistory::find($id);
        $history->delete();

        Session::flash('success', 'Deleted!');
        return redirect()->route('sms.admin');
    }

    public function updateRechargeReqHistory($id) {
        $history = Smsrechargehistory::find($id);
        $history->activation_status = 1;
        $history->save();

        Session::flash('success', 'Activated successfully!');
        return redirect()->route('sms.admin');
    }
}
