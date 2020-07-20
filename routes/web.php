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

Auth::routes();
Route::get('/home', 'HomeController@index')->name('home');

//ログイン一般ユーザー
Route::group(['prefix' => 'timeline',['middleware' => 'auth']], function () {
    Route::get('/','User\TimelineController@index');
    Route::post('/','User\TimelineController@post');
    Route::get('detail/{id}','User\TimelineController@show')->name('postdetail');
    Route::post('detail','User\CommentController@comment');
    Route::get('mypage/{id}','User\PagesController@show')->name('mypage');
    Route::get('mypage/editmypage/{id}','User\PagesController@edit');
    Route::post('mypage/editmypage','User\PagesController@update');
    Route::get('followings/{id}', 'User\FollowsController@showFollowings')->name('followings');
    Route::get('followers/{id}', 'User\FollowsController@showFollowers')->name('followers');
    Route::post('follow/{id}', 'User\FollowsController@store')->name('follow');
    Route::delete('unfollow/{id}', 'User\FollowsController@destroy')->name('unfollow');
    
  
    Route::post('like/{id}','User\LikesController@store')->name('like');
    Route::delete('unlike/{id}','User\LikesController@destroy')->name('unlike');
});
