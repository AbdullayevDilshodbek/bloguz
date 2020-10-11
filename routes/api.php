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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::group(['namespace' => 'App\Http\Controllers'],
    function (){
        Route::get('categorys', 'CategoryController@getAll');
        Route::get('search_category', 'CategoryController@findCategory');
        Route::get('blogs','BlogController@getAll');
        Route::get('findBlog','BlogController@findBlogByCategory');
        Route::apiResource('grade','GradeController')->only('store', 'index');
        Route::get('comments', 'CommentController@getAll');
        Route::get('onlyComment','CommentController@OnlyComment');
    });
Route::group([
    'namespace' => 'App\Http\Controllers',
    'middleware' => 'auth:api'
], function (){
    Route::apiResource('category', 'CategoryController')->except('index','show');
    Route::apiResource('blog','BlogController')->except('index');
    Route::apiResource('comment', 'CommentController')->except('index','show','destroy');
    Route::put('createDiscuss','CommentController@createDiscuss');
});
