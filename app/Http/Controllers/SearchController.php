<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;


class SearchController extends Controller
{
    public function getResult(Request $request)
    {
        /**
         * Получаем данные из поиска
         */
        $query = $request->input('query');

        /**
         * Если строка запроса пустая, то перенаправить на домашнюю страницу
         */
        if (!$query) {
            return redirect()->route('homePage');
        }

        $users = User::where('username', $query)->get();

        return view('search.result', [
            'users' => $users
        ]);
    }
}
