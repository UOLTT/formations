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
        'id',
        'name',
        'username',
        'game_handle',
        'email',
        'password',
        'organization_id',
        'fleet_id',
        'squad_id',
        'station_id',
        'active_ship'
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
        'active_ship_position' => 'integer'
    ];

    public function getActiveShipAttribute($value)
    {
        $MetaData = \DB::table('ship_user')
            ->where('id',$value)
            ->first(['user_id','ship_id']);
        if (is_null($MetaData)) {
            return null;
        }
        return collect([
            'user_id' => (integer)$MetaData->user_id,
            'ship_id' => (integer)$MetaData->ship_id
        ]);
    }

    public function setActiveShipAttribute($value) {
        $this->attributes['active_ship'] = \DB::table('ship_user')
            ->where('user_id',$value->user_id)
            ->where('ship_id',$value->ship_id)
            ->firstOrFail(['id'])
            ->id;
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
