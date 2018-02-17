<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Author extends Model
{
    public function posts()
    {
        return $this->hasMany('App\Post');
    }

    public function comments()
    {
        return $this->hasManyThrough('App\Comment', 'App\Post');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
