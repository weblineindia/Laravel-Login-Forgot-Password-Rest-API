<?php

header('Access-Control-Allow-Origin:*');
header('Access-Control-Allow-Methods:  POST, GET, OPTIONS, PUT, DELETE');
header('Access-Control-Allow-Headers:  Content-Type, X-Auth-Token, Origin, Authorization');
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


//Routes for User
Route::group(['namespace' => 'Api\admin', 'middleware' => 'ipcheck'], function () {

    //Auth
    Route::post('login', 'UserController@login');
    Route::post('forgot-password', 'UserController@forgotPassword');
});