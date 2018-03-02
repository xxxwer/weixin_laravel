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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::any('/', [
    'as' => 'wx_token_check',
    'uses' => 'Index\Index@wxTokenCheck'
]);

Route::any('/showAccessToken', [
    'as' => 'show_access_token',
    'uses' => 'Index\ManageApi@showAccessToken'
]);

Route::any('/showIpList', [
    'as' => 'show_ip_list',
    'uses' => 'Index\ManageApi@showWxIpList'
]);
