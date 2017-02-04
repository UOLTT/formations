<?php

namespace App\Http\Controllers\API\v4;

use App\Device;
use App\Http\Controllers\API\ApiController;
use App\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class DeviceController extends ApiController
{
    public function register($token) {
        $Device = Device::with('user')
            ->where('token',$token)
            ->where('used','=',false)
            ->first();
        if (is_null($Device)) {
            return response([
                'error' => "No query results for model [App\\Fleet] ".$token,
                'status_code' => 404
            ],404);        }
        $Device->used = true;
        $Device->save();
        return User::with('devices')
            ->with('organization','ships')
            ->find($Device->user_id);
    }
}
