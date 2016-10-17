<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:api');

Route::group(['namespace'=>'API'], function() {

    Route::group(['namespace'=>'v4','prefix'=>'v4'], function() {

        Route::resource('/fleets',FleetsController::class,['except'=>['create','edit']]);
        Route::resource('/organizations',OrganizationsController::class,['except'=>['create','edit']]);

    });

});
