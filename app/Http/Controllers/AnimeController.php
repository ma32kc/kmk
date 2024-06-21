<?php

namespace App\Http\Controllers;

use App\Models\Anime;
use App\Http\Requests\StoreAnimeRequest;
use App\Http\Requests\UpdateAnimeRequest;

class AnimeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $animes = Anime::all();
        dd($animes);
    }

    /**
     * Display the specified resource.
     */
    public function show(Anime $anime)
    {
        dd($anime);
    }
}
