<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Screen\AsSource;

class Category extends Model
{
    use AsSource;
    use HasFactory;

    protected $fillable = [
        'title',
    ];

    public function animes()
    {
        return $this->belongsToMany(Anime::class, 'anime_category');
    }
}
