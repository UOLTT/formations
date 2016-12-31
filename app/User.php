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
        'active_ship_position' => 'integer',
    ];

    public function getActiveShipAttribute($value)
    {
        $MetaData = \DB::table('ship_user')
            ->where('id',$value)
            ->first(['user_id','ship_id']);
        return collect([
            'user_id' => (integer)$MetaData->user_id,
            'ship_id' => (integer)$MetaData->ship_id
        ]);
    }

    // TODO write the ActiveShip setter mutator

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
