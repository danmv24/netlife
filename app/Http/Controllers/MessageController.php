<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MessageController extends Controller
{

    public function showMessagePage($username)
    {
        return view('messages.message', compact('username'));
    }

    public function sendMessage(Request $request, $username)
    {
        $this->validate($request, [
            'message' => 'required|max:4096'
        ]);


    }
}
