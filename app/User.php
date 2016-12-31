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
        'fleet_id' => 'integer',
        'organization_id' => 'integer',
        'squad_id' => 'integer',
        'active_user_ship' => 'integer',
        'active_ship_id' => 'integer',
        'active_ship_position' => 'integer',
        'ship_user_id' => 'integer'
    ];

    public function active_ship()
    {
        $MetaData = \DB::table('ship_user')
            ->where('id',$this->ship_user_id)
            ->first(['user_id','ship_id']);
        $StationID = $this->station_id;
        return Ship::with([
            'users' => function ($query) use ($MetaData) {
                $query->find($MetaData->user_id);
            },
            'positions' => function ($query) use ($StationID) {
                $query->find($StationID);
            }
        ])->find($MetaData->ship_id);
    }

    public function devices() {
        return $this->hasMany(Device::class);
    }

    public function fleet() {
        return $this->belongsTo(Fleet::class);
    }

    public function organization()
    {
        return $this->belongsTo(Organization::class);
    }

    public function squad() {
        return $this->belongsTo(Squad::class);
    }

    public function ships()
    {
        return $this->belongsToMany(Ship::class, 'ship_user');
    }

}
