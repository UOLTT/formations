<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Organization extends Model
{

    public $timestamps = true;
    protected $table = 'organizations';

    public function fleets() {
        return $this->hasMany(Fleet::class,'organization_id','id');
    }

    public function squads() {
        return $this->hasManyThrough(Squad::class,Fleet::class);
    }

}
