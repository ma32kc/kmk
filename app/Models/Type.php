<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Type extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
    ];

    public function characters()
    {
        return $this->belongsToMany(Character::class, 'character_type');
    }
}
