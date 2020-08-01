<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::group(['middleware' => 'cors'], function () {
    Route::post('/login', 'Api\SystemUserController@postLogin');

    Route::group(['middleware' => ['token.auth', 'group.permission']], function () {
        Route::post('/logout', 'Api\SystemUserController@postLogout');

        Route::get('/get-aside-menu', 'Api\SystemUserController@getAsideMenu');

        // Route::post('/upload-picture', 'Api\UploadController@uploadPicture');

        Route::group(['middleware' => 'function.permission'], function () {
            //會員列表與訂單搜尋
            Route::get('/get-members-list/{tag?}', 'Api\MemberController@getAllMemberList');
        });
    });
});
