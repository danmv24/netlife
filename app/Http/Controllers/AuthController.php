<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class AuthController extends Controller
{
    public function getSignUp()
    {
        return view('auth.signup');
    }

    public function postSignUp(Request $request)
    {
        /**
         * Здесь хранятся данные, которые мы будем получать от пользователя
         */
        $this->validate($request, [
           'email' => 'required|unique:users|email|max:255',
           'username' => 'required|max:50',
           'password' => 'required|min:8',
        ]);

        User::create([
            'email' => $request->input('email'),
            'username' => $request->input('username'),
            'password' => bcrypt($request->input('password'))
        ]);

        return redirect()
            ->route('homePage')
            ->with('info', 'Вы успешно зарегистрировались');
    }
}
