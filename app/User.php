<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'organization_id', 'squad_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'email', 'created_at', 'updated_at'
    ];

    protected $casts = [
        'id' => 'integer',
        'name' => 'string',
        'email' => 'string',
        'organization_id' => 'integer',
        'squad_id' => 'integer'
    ];

    public function active_ship()
    {
        return Ship::with([
            'users' => function ($query) use ($this) {
                $query->where('id',$this->active_user_ship);
            },
            'positions' => function ($query) use ($this) {
                $query->where('id',$this->active_ship_position);
            }
        ])->find($this->active_ship_id);
    }

    public function organization()
    {
        return $this->belongsTo(Organization::class);
    }

    public function ships()
    {
        return $this->belongsToMany(Ship::class, 'ship_user');
    }

}
