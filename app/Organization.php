<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Organization extends Model
{

    public $timestamps = true;
    protected $table = 'organizations';
    protected $fillable = ['name','domain','admin_user_id'];

    public function fleets() {
        return $this->hasMany(Fleet::class,'organization_id','id');
    }

    public function squads() {
        return $this->hasManyThrough(Squad::class,Fleet::class);
    }

}
