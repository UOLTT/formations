<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Device extends Model
{
    protected $table = "devices";
    public $timestamps = true;
    protected $hidden = ['user_id','updated_at'];
    protected $fillable = [
        'user_id',
        'used',
        'token'
    ];
    protected $casts = [
        'id' => 'integer',
        'user_id' => 'integer',
        'used' => 'boolean',
        'token' => 'string'
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }
}
