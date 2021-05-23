<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use App\Models\User;

class AuthController extends Controller
{
    public function getSignUp()
    {
        /**
         * Возвращает страницу с регистрацией
         */
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

        /**
         * Добавление полученных данных в бд
         */
        User::create([
            'email' => $request->input('email'),
            'username' => $request->input('username'),
            'password' => bcrypt($request->input('password'))
        ]);

        /**
         * Перенаправление на домашнюю страницу
         */
        return redirect()
            ->route('homePage')
            ->with('info', 'Вы успешно зарегистрировались');
    }

    public function getLogIn()
    {
        /**
         * Возвращает страницу входа
         */
        return view('auth.login');
    }

    public function postLogIn(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|max:255',
            'password' => 'required|min:8',
        ]);
        /**
         * Проверка данных при входе
         */
        if (!Auth::attempt($request->only(['email', 'password']), $request->has('remember'))) {
            return redirect()->back()->with('info', 'Неправильный логин или пароль!!!'); // Вернуться на ту страницу, откуда пользователь "пришёл"
        }

        return redirect()->route('homePage')->with('info', 'Вход выполнен успешно!');
    }

    public function getLogOut()
    {
        /**
         * Выйти из аккаунта
         */
        Auth::logout();

        return redirect()->route('homePage');
    }
}
