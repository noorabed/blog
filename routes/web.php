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
use Illuminate\Http\Request;
use App\User;
use App\Message;
Route::get('/', function () {
    return view('layouts/welcome');
});
Auth::routes();
Route::get('/logout', '\App\Http\Controllers\Auth\LoginController@logout');
Route::get('/home', 'HomeController@index')->name('home');
//user1
//Route::post('users/update', 'UserController@update')->name('users.update');
//Route::get('/user/edituser', 'UserController@edituser');
//Route::get('users/destroy/{id}', 'UserController@destroy');
//Route::get('changestate/{id}','UserController@changestate')->name('users.changestate');
Route::get('/view', 'UserController@view')->name('view');
//blog1
//Route::get('/post/create', 'BlogController@create')->name('post.create');
//Route::post('blogs.store', 'BlogController@store')->name('blogs.store');
//category 1
Route::resource('categories', 'CategoryController');
Route::get('/category/create', 'CategoryController@create')->name('category.create');
//Route::post('category/store', 'CategoryController@store')->name('category.store');
//Route::get('/category/editcategory', 'CategoryController@editcategory');
//post

Route::resource('blogs', 'BlogController');
Route::post('blogs/update/{id}', 'BlogController@update')->name('blogs.update');
Route::get('blogs/destroy/{id}', 'BlogController@destroy');
//user
Route::resource('users', 'UserController');
Route::post('users/update', 'UserController@update')->name('users.update');
Route::get('users/destroy/{id}', 'UserController@destroy');
Route::get('changestate/{id}','UserController@changestate')->name('users.changestate');
Route::get('edituserrole/{id}','UserController@edituserrole')->name('users.edituserrole');
Route::post('/user/updatetuserrole/{id}', 'UserController@updatetuserrole')->name('users.updatetuserrole');
//category
Route::resource('category/categories', 'CategoryController');
Route::get('/category/categorylist', 'CategoryController@index')->name('categories.index');
Route::post('/category/categories/update', 'CategoryController@update')->name('categories.update');
Route::get('/category/categories/destroy/{id}', 'CategoryController@destroy');
Auth::routes();
//profile
Route::resource('profile', 'ProfileController');
Route::post('user/profile/update', 'ProfileController@update')->name('user.update');
//blog frontend
Route::get('index', 'BlogController@show')->name('blogs.show');
Route::get('blog/show/{id}', 'BlogController@view')->name('blogs.view');
Route::get('/category/{category}','BlogController@category')->name('category');
//comment
Route::resource('comments', 'CommentController');
Route::post('/blog/{post}/comments', 'CommentController@store')->name('blogs.comments');
Route::get('comments/destroy/{id}', 'CommentController@destroy');
//tags
Route::get('/tag/{tag}','BlogController@tag')->name('tag');


//role
Route::resource('roles', 'RoleController');
Route::post('/user/roles/update{id}', 'RoleController@update')->name('roles.update');
Route::get('roles/destroy/{id}', 'RoleController@destroy');
//Route::post('/user/roles/update{id}', 'RoleController@updateuser')->name('roles.updateuser');
//permission
Route::resource('permissions', 'PermissionController');
Route::post('/user/permissions/update', 'PermissionController@update')->name('permissions.update');
Route::get('permissions/destroy/{id}', 'PermissionController@destroy');
Auth::routes();
//setting
Route::get('/home', 'HomeController@index')->name('home');
Route::resource('settings', 'SettingController');
Route::post('settings/update/{id}', 'SettingController@update')->name('settings.update');
//tag
Route::resource('tags', 'TagController');
Route::get('tags/destroy/{id}', 'TagController@destroy')->name('tags.dertroy');

//search
Route::get('search', 'BlogController@search')->name('blogs.search');
Route::post('blogs/fetch', 'BlogController@fetch')->name('blogs.fetch');
//action
Route::resource('logs', 'ActionControler');
Route::get('logs/destroy/{id}', 'ActionControler@destroy');

//emails
Route::get('/sendemail', 'SendEmailController@index')->name('send.index');
Route::post('/sendemail/send', 'SendEmailController@send');

Route::get('/remove', 'CommentController@remove');

Route::get('/chat', 'ChatController@index')->name('chat')->middleware('auth');
Route::get('/messages',function (){
    $messages = Message::with(['user'])->get();

    return response()->json($messages);

});

Route::post('/messages',function (){
    $user=Auth::user();
    $message=$user->messages()->Create([
        'message'=>request()->get('message')
    ]);

    broadcast(new \App\Events\MessageCreated($message,$user))->toOthers();
    return response()->json($message);
    })->middleware('auth');

