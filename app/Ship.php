<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ship extends Model
{

    public $timestamps = false;
    protected $table = 'ships';

    public function users() {
        return $this->belongsToMany(User::class,'ship_user');
    }

}
