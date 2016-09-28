<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ApiHit extends Model
{

    public $timestamps = true;
    protected $table = 'api_hits';
    protected $fillable = [
        'user_id','organization_id','path','query_data'
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function organization() {
        return $this->belongsTo(Organization::class);
    }

}
