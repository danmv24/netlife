<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Models\User;

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
}
