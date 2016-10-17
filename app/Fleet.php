<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Fleet extends Model
{
    public $timestamps = true;
    protected $table = 'fleets';
    protected $fillable = ['name','organization_id','status_id','manifesto'];
    protected $casts = [
        'id' => 'integer',
        'name' => 'string',
        'organization_id' => 'integer',
        'status_id' => 'integer',
        'manifesto' => 'string'
    ];

    public function organization() {
        return $this->belongsTo(Organization::class);
    }

    public function squads() {
        return $this->hasMany(Squad::class,'fleet_id','id');
    }

    public function status() {
        return $this->belongsTo(Status::class);
    }

}
