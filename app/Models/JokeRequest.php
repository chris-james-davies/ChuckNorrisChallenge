<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JokeRequest extends Model
{
    protected $fillable = ['status','ip_address'];

    public function emails()
    {
        return $this->belongsToMany(Email::class);
    }
}
