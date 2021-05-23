<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use App\Models\User;

class ProfileController extends Controller
{
    public function showProfile($username)
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

    public function getEditProfile()
    {
        /**
         * Возвращает страницу с редактированием профиля
         */

        return view('profile.edit');
    }

    public function postEditProfile(Request $request)
    {
        $this->validate($request, [
            'username'=> 'alpha_dash|max:50'
        ]);

        Auth::user()->update([
            'username' => $request->input('username')
        ]);

        return redirect()->route('homePage')->with('info', 'Профиль был успешно обновлён');
    }
}
