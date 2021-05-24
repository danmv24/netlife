<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        /**
         * Возвращает домашнюю страницу
         */
        return view('feed.index');
    }
}
