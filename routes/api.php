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

/*Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['namespace' => 'Api'], function () {
	Route::get('users','UsersController@index');
});
*/
/*Route::get('users','Api\UsersController@index');*/

Route::post('login', 'Api\UserController@login');
Route::post('register', 'Api\UserController@register');
//Route::post('post', 'Api\PostController@save');

//After login access , because use auth
Route::group(['middleware' => 'auth:api'], function(){
	Route::post('posts', 'Api\PostController@save');//Cretae post
	Route::get('posts', 'Api\PostController@allPosts');//get all posts
	Route::put('posts','Api\PostController@update');//update post
	Route::delete('posts','Api\PostController@delete');//delete post
	Route::get('posts/{id}','Api\PostController@show');
	Route::post('searchPosts','Api\PostController@searchPosts');
	Route::post('logout','Api\UserController@logoutApi');
});