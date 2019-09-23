<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendMail;

class SendEmailController extends Controller
{
    function index()
    {
        return view('emails.send_email');
    }
    function send(Request $request)
    {
        //send to user mail
        $this->validate($request, [
            'name'     =>  'required',
            'email'  =>  'required|email',
            'message' =>  'required'
        ]);

        $data = array(
            'name'      =>  $request->name,
            'message'   =>   $request->message
        );

        \Mail::to('blog@blog.info')->send(new SendMail($data));
        return back()->with('success', 'Thanks for Your emails!');

    }

}
