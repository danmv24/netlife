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

        $sent_by_me = Message::where('auth_id', Auth::user()->id)
                    ->where('recipient_id', $user->id);

        $conversation = Message::where('auth_id', $user->id)
                        ->where('recipient_id', Auth::user()->id)
                        ->union($sent_by_me)
                        ->orderBy('created_at', 'asc')
                        ->get();

        return view('messages.message', [
            'username' => $username,
            'conversation' => $conversation
        ]);
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
