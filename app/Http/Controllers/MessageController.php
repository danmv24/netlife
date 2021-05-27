<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Models\Message;
use App\Models\User;



class MessageController extends Controller
{

    public function showMessagePage($username)
    {
        $user = User::where('username', $username)->first();

        if (!$user) {
            return redirect()->route('homePage');
        }

        return view('messages.message', compact('username'));
    }

    public function sendMessage(Request $request, $username)
    {
        $this->validate($request, [
            'message' => 'required|max:4096'
        ]);

        $user = User::where('username', $username)->first();

        Auth::user()->messages()->create([
           'message' => $request->input('message'),
            'recipient_id' => $user->id
        ]);

        return redirect()->back();
    }
}
