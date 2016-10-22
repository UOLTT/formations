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
        'squad_id' => 'integer',
        'active_user_ship' => 'integer',
        'active_ship_id' => 'integer',
        'active_ship_position' => 'integer'
    ];

    public function active_ship()
    {
        $MetaData = \DB::table('ship_user')
            ->where('id',$this->ship_user_id)
            ->first(['user_id','ship_id']);
        $PositionID = $this->position_id;
        return Ship::with([
            'users' => function ($query) use ($MetaData) {
                $query->where('id',$MetaData->user_id);
            },
            'positions' => function ($query) use ($PositionID) {
                $query->where('id',$PositionID);
            }
        ])->find($MetaData->ship_id);
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
