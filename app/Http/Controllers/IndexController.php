<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\School;
use App\Upazilla;
use Artisan, Session, Redirect;
use Mail;

class IndexController extends Controller
{
    public function index()
    {
        $districts = Upazilla::orderBy('id', 'asc')->groupBy('district')->get()->pluck('district');
        $schools = School::orderBy('id', 'ASC')->get();
        return view('index.index')
                    ->withSchools($schools)
                    ->withDistricts($districts);
    }

    // clear configs, routes and serve
    public function clear()
    {
        // Artisan::call('config:cache');
        // Artisan::call('route:cache');
        // Artisan::call('optimize');
        // Artisan::call('cache:clear');
        // Artisan::call('view:clear');
        // Artisan::call('key:generate');
        Session::flush();
        echo 'Config and Route Cached. All Cache Cleared';
    }

    public function emailContactForm(Request $request)
    {
        $this->validate($request, [
            'name'         => 'required',
            'email'   => 'required',
            'phone'   => 'required',
            'message'   => 'required',
            'contact_sum_result_hidden'   => 'required',
            'contact_sum_result'   => 'required',
        ]);

        if($request->contact_sum_result_hidden == $request->contact_sum_result) {
            // send a email to the receipient
            $data = ['to_email'   => 'orbachinujbuk@gmail.com',
                    'from_email'  => $request->email,
                    'subject'     => 'EasySchool | Contact Form Message',
                    'name'      => $request->name,
                    'phone'       => $request->phone,
                    'bodyMessage' => $request->message];

            Mail::send('emails.contact', $data, function ($message) use ($data) {
                $message->from($data['from_email']);
                $message->sender('info@easyschool.xyz', 'EasySchool');
            
                $message->to($data['to_email']);
                // $message->cc('blog@humansofthakurgaon.org');
                //$message->bcc('john@johndoe.com', 'John Doe');
            
                $message->replyTo($data['from_email']);
                $message->subject($data['subject']);
                $message->priority(3);
            
                //$message->attach('pathToFile');
            });
            // send a email to the receipient
                                      
            //redirect
            return Redirect::to('/#contactsection')->with('success', 'আপনার বার্তা আমাদের কাছে পৌঁছেছে। ধন্যবাদ!');
        } else {
            return Redirect::to('/#contactsection')->with('warning', 'যোগফল ভুল হয়েছে! আবার চেষ্টা করুন।');
        }
    }


}
