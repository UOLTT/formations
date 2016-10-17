<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Organization extends Model
{

    public $timestamps = true;
    protected $table = 'organizations';
    protected $fillable = ['name','domain','admin_user_id','status_id','manifesto'];
    protected $casts = [
        'id' => 'integer',
        'name' => 'string',
        'domain' => 'string',
        'admin_user_id' => 'integer',
        'status_id' => 'integer',
        'manifesto' => 'string'
    ];

    public function administrator() {
        return $this->hasOne(User::class,'id','admin_user_id');
    }

    public function fleets() {
        return $this->hasMany(Fleet::class,'organization_id','id');
    }

    public function squads() {
        return $this->hasManyThrough(Squad::class,Fleet::class);
    }

    public function status() {
        return $this->belongsTo(Status::class);
    }

    public function users() {
        return $this->hasMany(User::class);
    }

}
