<?php

namespace App\Http\Controllers\API\v4;

use App\Device;
use App\Http\Controllers\API\ApiController;
use App\User;
use Illuminate\Http\Request;

class DeviceController extends ApiController
{

    public function register($token) {
        $Device = Device::with('user')
            ->where('token',$token)
            ->where('used','=',false)
            ->firstOrFail();
        $Device->used = true;
        $Device->save();
        return User::with('devices')
            ->with('organization','ships')
            ->find($Device->user_id);
    }

    public function store(Request $request) {

        $token = uniqid();

        \Auth::user()->devices()->create([
            'used' => false,
            'token' => $token
        ]);

        return response()->json([
            'token' => $token
        ]);

    }

}
