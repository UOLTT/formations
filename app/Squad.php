<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Squad extends Model
{
    // TODO maybe add fleet admin?
    public $timestamps = true;
    protected $table = 'squads';
    protected $fillable = ['fleet_id','name','status_id'];
    protected $casts = [
        'id' => 'integer',
        'fleet_id' => 'integer',
        'status_id' => 'integer',
        'name' => 'string'
    ];

    public function fleet() {
        return $this->belongsTo(Fleet::class);
    }

    public function status() {
        return $this->belongsTo(Status::class);
    }

    public function users() {
        return $this->hasMany(User::class,'squad_id','id');
    }

}
