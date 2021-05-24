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

    /**
     * Добавить в друзья (а именно отправить заявку в друзья)
     */
    public function addToFriend($username)
    {
        /**
         * Находим в бд пользователя по username'у и получаем его
         */
        $user = User::where('username', $username)->first();

        /**
         * Если пользователь не найден, то перенаправить на домашнюю страницу с сообщением
         */
        if (!$user) {
            return redirect()->route('homePage')
                ->with('info', 'Пользователь с таким именем не найден');
        }

        if (Auth::user()->hasFriendRequestsPending($user)
            || $user->hasFriendRequestsPending(Auth::user())) {
            return redirect()->route('showProfile', ['username' => $user->username])
                ->with('info', 'Запрос в друзья отправлен');
        }

        if (Auth::user()->isFriendWith($user)) {
            return redirect()->route('showProfile', ['username' => $user->username])
                ->with('info', 'Пользователь уже в друзьях');
        }

        Auth::user()->addFriend($user);

        return redirect()->route('showProfile', ['username' => $username])
            ->with('info', 'Запрос в друзья отправлен');
    }

    /**
     * Принять заявку в друзья
     */
    public function acceptFriendRequest($username)
    {
        $user = User::where('username', $username)->first();

        if (!$user) {
            return redirect()->route('homePage')
                ->with('info', 'Пользователь с таким именем не найден');
        }

        if (!Auth::user()->hasFriendRequestReceived($user)) {
            return redirect()->route('homePage');
        }

        Auth::user()->acceptFriendRequest($user);

        return redirect()->route('showProfile', ['username' => $username])
            ->with('info', 'Запрос в друзья принят');
    }

}
