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
    return view('layouts/welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/view', 'UserController@view')->name('view');
/**Route::get('image', function () {
    return view('layouts.create');
});*/

Route::resource('blogs', 'BlogController');
Route::post('blogs/update', 'BlogController@update')->name('blogs.update');
Route::get('blogs/destroy/{id}', 'BlogController@destroy');
//Route::get('/layouts/create', 'BlogController@create')->name('layouts.create');
//Route::post('blogs.store', 'BlogController@store')->name('blogs.store');
Route::get('/layouts/show', 'BlogController@show')->name('blogs.show');
Route::resource('categories', 'CategoryController');
Route::get('/category/create', 'CategoryController@create')->name('category.create');
Route::post('category/store', 'CategoryController@store')->name('category.store');
Route::get('/category/categorylist', 'CategoryController@index')->name('categories.index');
Route::get('/category/editcategory', 'CategoryController@editcategory');
Route::resource('users', 'UserController');
Route::get('/layouts/edituser', 'UserController@edituser');
Route::get('changestate/{id}','UserController@changestate')->name('users.changestate');


Auth::routes();


Route::get('/home', 'HomeController@index')->name('home');
Route::get('/profile', 'ProfileController@index');
