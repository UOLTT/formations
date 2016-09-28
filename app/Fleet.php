<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Fleet extends Model
{

    public $timestamps = true;
    protected $table = 'fleets';

    public function organization() {
        return $this->belongsTo(Organization::class);
    }

    public function squads() {
        return $this->hasMany(Squad::class,'fleet_id','id');
    }

}
