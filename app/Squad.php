<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Squad extends Model
{
    // TODO maybe add fleet admin?
    public $timestamps = true;
    protected $table = 'squads';
    protected $fillable = ['fleet_id','name','status_id','formation_id','squad_leader'];
    protected $casts = [
        'id' => 'integer',
        'fleet_id' => 'integer',
        'formation_id' => 'integer',
        'squad_leader' => 'integer',
        'status_id' => 'integer',
        'name' => 'string'
    ];

    public function fleet() {
        return $this->belongsTo(Fleet::class);
    }

    public function formation() {
        return $this->belongsTo(Formation::class);
    }

    public function squad_leader() {
        return $this->belongsTo(User::class,'id','squad_leader');
    }

    public function status() {
        return $this->belongsTo(Status::class);
    }

    public function users() {
        return $this->hasMany(User::class,'squad_id','id');
    }

}
