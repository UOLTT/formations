<?php

namespace App\Http\Controllers;

use \App\Device;
use \Faker\Factory as Faker;
use Illuminate\Http\Request;

class WebAppController extends Controller
{
    public function profile() {
        if (!\Auth::user()) {
            return redirect('/login');
        }
        if (Device::where('user_id',\Auth::user()->id)->count() == 0) {
            $token = "";
            foreach (range(1,6) as $int) {
                $token .= Faker::create()->randomLetter;
            }
            \Auth::user()->devices()->create(['token'=>$token,'used'=>true]);
        }else {
            $token = Device::where('user_id',\Auth::user()->id)->where('used',true)->first()->token;
        }
        return view('profile')->with('token',$token);
    }
}
