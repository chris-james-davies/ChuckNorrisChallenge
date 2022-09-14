<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Email extends Model
{
    protected $guarded = ['id'];

    public function requests()
    {
        return $this->belongsToMany(JokeRequest::class);
    }
}
