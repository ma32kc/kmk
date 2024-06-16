<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Character extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'anime_id',
    ];

    public function anime()
    {
        return $this->belongsTo(Anime::class);
    }

    public function types()
    {
        return $this->belongsToMany(Type::class, 'character_type');
    }

    public function statistic()
    {
        return $this->hasOne(Statistic::class);
    }

    public function image()
    {
        return $this->morphOne(Image::class, 'imageable');
    }
}
