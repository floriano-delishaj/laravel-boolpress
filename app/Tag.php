<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    public static function truncate()
    {
    }

    public function posts() {
        return $this->belongsToMany('App\Post');
    }
}
