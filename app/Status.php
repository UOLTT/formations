<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Status extends Model
{

    public $timestamps = false;
    protected $table = 'statuses';
    protected $fillable = ['name','description','type'];
    protected $hidden = ['type'];

}
