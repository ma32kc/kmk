<?php

use App\Http\Controllers\AnimeController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::resource('anime', AnimeController::class)->only([
    'index', 'show'
])->missing(function (Request $request) {
    return Redirect::route('anime.index');
});