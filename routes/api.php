<?php

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Origin, Content-Type, Accept, Authorization, X-Request-With, X-Socket-Id');
header('Access-Control-Allow-Credentials: true');

/*Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});*/

Route::group(['prefix'=>'auth'], function () {
   Route::post('register', 'AuthController@register');
   Route::post('login', 'AuthController@login');
   Route::post('logout', 'AuthController@logout');
   Route::post('refresh', 'AuthController@refresh');
   Route::post('me', 'AuthController@me');
});

Route::group(['middleware'=>'my-jwt'], function (){
    Route::apiResource('clients', 'ClientController');
    Route::apiResource('contacts', 'ContactController');
    Route::post('file', 'FileController@parseImport');
});

