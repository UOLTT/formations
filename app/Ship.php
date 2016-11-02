<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ship extends Model
{

    public $timestamps = false;
    protected $table = 'ships';
    protected $casts = [
        'id' => 'integer',
        'shipname' => 'string',
        'length' => 'integer',
        'beam' => 'integer',
        'height' => 'integer',
        'nullmass' => 'integer',
        'cargocapacity' => 'integer',
        'crew' => 'integer',
        'powerplant' => 'integer',
        'powercount' => 'integer',
        'primary' => 'integer',
        'pcount' => 'integer',
        'maneuvering' => 'integer',
        'mancount' => 'integer',
        'shield' => 'integer',
        'shieldcount' => 'integer',
        'raceenabled' => 'string',
        'price' => 'integer',
        'class' => 'string',
        'combatspeed' => 'integer',
        'combatrating' => 'integer',
        'waverank' => 'integer'
    ];

    public function stations() {
        return $this->belongsToMany(Station::class,'ships_positions');
    }

    public function users() {
        return $this->belongsToMany(User::class,'ship_user');
    }

}
