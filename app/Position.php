<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Position extends Model
{
    public $timestamps = false;
    protected $table = 'positions';
    protected $fillable = ['formation_id','description','x-offset','y-offset','z-offset'];
    protected $casts = [
        'id' => 'integer',
        'formation_id' => 'integer',
        'description' => 'string',
        'x-offset' => 'float',
        'y-offset' => 'float',
        'z-offset' => 'float'
    ];

    public function formation() {
        return $this->belongsTo(Formation::class);
    }
}
