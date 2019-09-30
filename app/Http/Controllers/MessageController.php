<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Message;

class MessageController extends Controller
{
    public function index()
    {
        $message = Message::with(['user'])->get();

        return response()->json($message);
    }
    public function store(Request $request)
    {
        $message = $request->user()->messages()->create([
            'message' => $request->message
        ]);
           // dd($message);
        return response()->json($message);
    }
}
