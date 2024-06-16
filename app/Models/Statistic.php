<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Statistic extends Model
{
    use HasFactory;

    protected $fillable = [
        'kiss', 'merry', 'kill', 'character_id',
    ];

    public function character()
    {
        return $this->belongsTo(Character::class);
    }
}
