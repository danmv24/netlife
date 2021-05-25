<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Status;
use Auth;

class HomeController extends Controller
{
    public function index()
    {
        if (Auth::check()) {
            /**
             * Выводить те записи, которые принадлежат
             * авторизованному пользователю
             */
            $statuses = Status::where(function ($query) {
               return $query->where('user_id', Auth::user()->id)
                   ->orWhereIn('user_id', Auth::user()->friends()->pluck('id'));
            })->orderBy('created_at', 'desc')
            ->paginate(10);

            return view('feed.index', [
                'statuses' => $statuses
            ]);
        }
        /**
         * Возвращает домашнюю страницу
         */
        return view('home');
    }


}
