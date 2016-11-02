<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Formation extends Model
{
    public $timestamps = true;
    protected $table = 'formations';
    protected $hidden = ['created_at','updated_at'];
    protected $fillable = ['name','description','minimum_users'];
    protected $casts = [
        'id' => 'integer',
        'name' => 'string',
        'description' => 'string',
        'minimum_users' => 'integer'
    ];
}
