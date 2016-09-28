<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Squad extends Model
{

    public $timestamps = true;
    protected $table = 'squads';
    protected $fillable = ['fleet_id','name'];

    public function fleet() {
        return $this->belongsTo(Fleet::class);
    }

    public function status() {
        return $this->morphOne(Status::class,'statustable');
    }

    public function users() {
        return $this->hasMany(User::class,'squad_id','id');
    }

}
