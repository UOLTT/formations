<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Formation extends Model
{
    public $timestamps = true;
    protected $table = 'formations';
    protected $hidden = ['filename','created_at','updated_at'];
    protected $fillable = ['name','description','minimum_users','filename'];
    protected $casts = [
        'id' => 'integer',
        'name' => 'string',
        'description' => 'string',
        'minimum_users' => 'integer'
    ];

    public function positions() {
        return $this->hasMany(Position::class);
    }

}
