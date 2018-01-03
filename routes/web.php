<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/', function () {
    return view('welcome');
});

Route::group(['namespace'=>'Admin', 'prefix'=>'admin'], function(){
    Route::get('/', function () {
        return view('backend.home.index');
    });
    Route::resource('/books', 'BookController');
});
Route::get('/admin/books', function(){
		return view('backend.books.create');
});
