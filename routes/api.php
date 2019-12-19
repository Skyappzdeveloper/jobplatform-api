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


Route::get('/users', 'ProductController@user');

Route::post('/v1/register', 'UserController@register');
Route::post('/v1/login', 'UserController@login');
Route::post('/v1/user_personal_detail', 'UserController@userDetail');
Route::post('/v1/user_job_detail', 'UserController@user_job_detail');
Route::post('/v1/user_joblist', 'UserController@joblist');
Route::post('/v1/user_profile', 'UserController@user_profile');
Route::post('/v1/profile', 'UserController@profile');
Route::post('/v1/checkmobile', 'UserController@checkmobile');
Route::post('/v1/changepassword', 'UserController@changepassword');
Route::post('/v1/joblist', 'UserController@joblist');
