<?php

namespace App\Http\Controllers\API;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ApiController extends Controller
{

    function buildFailedValidationResponse(Request $request, array $errors)
    {
        return response([
            'error' => 'Form validation failed',
            'problems' => $errors
        ],400);
    }

}