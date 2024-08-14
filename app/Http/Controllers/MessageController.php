<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Events\SendMessageEvent;

class MessageController extends Controller
{
    public function index()
    {
        return view('message');
    } // function index

    public function sendMessage(Request $request)
    {
        $message = $request->message;

        event(new SendMessageEvent(
            message: $message,
            notif: 'Task has been add',
        ));

        return response()->json(['message' => 'Task has been add'], 200);
    } // sendMessage
}
