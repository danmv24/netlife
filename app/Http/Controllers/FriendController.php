<?php

namespace App\Http\Controllers;

use Auth;
use App\Models\User;
use Illuminate\Http\Request;

class FriendController extends Controller
{
    public function showFriend()
    {
        $friends = Auth::user()->friends();

        return view('friends.index', [
            'friends' => $friends
        ]);
    }

    public function showRequest()
    {
        $requests = Auth::user()->friendRequests();

        return view('friends.all_requests', [
            'requests' => $requests
        ]);
    }

}
