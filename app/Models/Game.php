<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'release_year', 'price', 'platform_id', 'photo'];

    public function platform()
    {
        return $this->belongsTo(Platform::class);
    }
}
