<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Station extends Model
{
    protected $table = 'stations';
    public $timestamps = false;
    protected $casts = [
        'id' => 'integer',
        'name' => 'string',
        'description' => 'string'
    ];
    protected $fillable = [
        'name',
        'description'
    ];

    public function ships() {
        return $this->belongsToMany(Ship::class,'ships_stations');
    }
}
