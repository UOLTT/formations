<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Squad extends Model
{

    public $timestamps = true;
    protected $table = 'squads';

    public function fleet() {
        return $this->belongsTo(Fleet::class);
    }

    public function users() {
        return $this->hasMany(User::class,'squad_id','id');
    }

}
