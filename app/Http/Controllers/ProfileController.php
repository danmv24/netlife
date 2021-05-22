<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class ProfileController extends Controller
{
    public function getProfile($username)
    {
        /**
         * Ищеем пользователя, у которого логин равен username
         */
        $user = User::where('username', $username)->first();

        /**
         * Если пользователь не найден, то отображаем 404 ошибку
         */
        if (!$user) {
            abort(404);
        }

        return view('profile.index', compact('user'));
    }
}
