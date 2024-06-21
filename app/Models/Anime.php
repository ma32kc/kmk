<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Screen\AsSource;

class Anime extends Model
{
    use AsSource;
    use HasFactory;

    protected $fillable = [
        'title',
    ];

    public function characters()
    {
        return $this->hasMany(Character::class);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'anime_category');
    }

    public function image()
    {
        return $this->morphOne(Image::class, 'imageable');
    }
}
