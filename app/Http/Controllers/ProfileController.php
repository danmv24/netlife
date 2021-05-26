<?php

namespace App\Http\Controllers;

use Auth;
use Faker\Provider\Image;
use Illuminate\Http\Request;
use App\Models\User;
use Intervention\Image\Facades\Image as Imag;

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

        $statuses = $user->statuses()->notReply()->get();

        return view('profile.index', [
            'user' => $user,
            'statuses' => $statuses,
            'authUserIsFriend' => Auth::user()->isFriendWith($user)
        ]);
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

    public function uploadAvatar(Request $request, $username)
    {
        $user = User::where('username', $username)->first();

        if (!Auth::user()->id === $user->id) {
            return redirect()->route('home');
        }

        if ($request->hasFile('avatar')) {
            $user->clearAvatars($user->id); // перед загрузкой аватарки удалить текущую аватарку

            $avatar = $request->file('avatar');
            $filename = time() . '.' . $avatar->getClientOriginalExtension();

            Imag::make($avatar)->resize(300, 300)
            ->save(public_path($user->avatarsPath($user->id)) . $filename);

            $user = Auth::user();
            $user->avatar = $filename;
            $user->save();
        }

        return redirect()->back();
    }
}
