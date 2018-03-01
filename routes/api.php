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

Route::group(['namespace' => 'Api'], function(){
    Route::get('books/top-review', 'BookController@topBooksReview');    
    Route::get('books/{book}', 'BookController@show');
    Route::get('users/{user}', 'UserController@show');
    Route::get('books/{id}/reviews', 'PostController@reviews');
    Route::get('comments', 'CommentController@comments');

    Route::group(['middleware' => 'apiLogin'], function(){
        // Route::post('posts', 'PostController@store');
    });
});
