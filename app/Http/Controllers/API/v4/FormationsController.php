<?php

namespace App\Http\Controllers\API\v4;

use App\Formation;
use App\Http\Controllers\API\ApiController;
use Illuminate\Http\Request;

class FormationsController extends ApiController
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Formation::all();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Formation::findOrFail($id);
    }

    /**
     * Serve a download of the formations image file
     *
     * @param $id
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function image($id) {
        $Formation = Formation::findOrFail($id);
        return response()
            ->download(
                storage_path('/app/formations/'.$Formation->filename),
                $Formation->filename
            );
    }

}
