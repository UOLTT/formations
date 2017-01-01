<?php

namespace App\Http\Controllers\API\v4;

use App\Ship;
use App\Http\Controllers\Controller;
use App\Http\Requests;

class ShipsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Ship::all();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Ship::with('stations','users')->findOrFail($id);
    }
}
