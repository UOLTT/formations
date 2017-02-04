<?php

namespace App\Http\Controllers\API\v4;

use App\Http\Controllers\API\ApiController;
use App\Ship;
use App\Http\Requests;

class ShipsController extends ApiController
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
        return Ship::with('users')->findOrFail($id);
    }
}
