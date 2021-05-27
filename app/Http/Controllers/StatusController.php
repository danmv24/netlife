<?php

namespace App\Http\Controllers;

use App\Models\Status;
use Illuminate\Http\Request;
use Auth;

class StatusController extends Controller
{
    public function createPost(Request $request)
    {
        $this->validate($request, [
            'status' => 'required|max:1024'
        ]);

        Auth::user()->statuses()->create([
            'body' => $request->input('status')
        ]);

        return redirect()->route('homePage')->with('info', 'Запись успешно опубликована');
    }

    public function reply(Request $request, $feedId)
    {
        $this->validate($request, [
           "reply-{$feedId}" => 'required|max:1024'
        ]);

        $status = Status::notReply()->find($feedId);

        if (!$status) {
            return redirect()->route('homePage');
        }

        if (!Auth::user()->isFriendWith($status->user)
            && Auth::user()->id !== $status->user->id) {
            return redirect()->route('homePage');
        }

        $reply = new Status();
        $reply->body = $request->input("reply-{$status->id}");
        $reply->user()->associate(Auth::user());

        $status->replies()->save($reply);

        return redirect()->back();
    }
}
