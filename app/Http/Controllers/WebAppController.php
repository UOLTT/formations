<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WebAppController extends Controller
{
    public function index() {
        if (\App\Device::where('user_id',\Auth::user()->id)->count() == 0) {
            $token = "";
            foreach (range(1,6) as $int) {
                $token .= \Faker\Factory::create()->randomLetter;
            }
            \Auth::user()->devices()->create(['token'=>$token,'used'=>true]);
        }else {
            $token = \App\Device::where('user_id',\Auth::user()->id)->where('used',true)->first()->token;
        }
        return view('app')->with('token',$token);
    }
}
