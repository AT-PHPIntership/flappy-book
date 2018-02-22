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

Route::get('/api-docs', function () {
    return view('api-docs');
});

Route::get('/api-doc-builders', function () {
    return view('api-doc-builders.index');
});

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::group(['namespace' => 'Admin', 'prefix' => 'admin' , 'middleware' => 'admin'], function(){
    Route::get('/', 'DashboardController@index')->name('admin.home.index');
    Route::resource('/books', 'BookController');
    Route::resource('/users', 'UserController');
    Route::get('/users/{user}/updateRole', 'UserController@updateRole');
    Route::resource('/borrows', 'BorrowController');
    Route::resource('/categories', 'CategoryController');
    Route::resource('/posts', 'PostController');
    Route::post('/borrows/{borrow}/sendmail', 'BorrowController@reminderSendMail')->name('borrows.sendmail');
    Route::resource('/qrcodes', 'QrcodeController');
});

Route::get('/login', 'Auth\LoginController@index')->name('login');
Route::post('/login', 'Auth\LoginController@login');
Route::post('/logout', 'Auth\LoginController@logout')->name('logout');
