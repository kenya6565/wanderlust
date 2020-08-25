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


Route::get('/', 'TopController@index');
Route::get('lang/{lang}', ['as'=>'lang.switch', 'uses'=>'LanguageController@switchLang']);


//未ログイン時
Route::group(['prefix' => 'guest'], function () {
    Route::get('timeline/','Guest\TimelineController@index')->name('guest_timeline');
    Route::get('detail/{id}','Guest\TimelineController@show')->name('guest_postdetail');
    Route::get('users/{id}','Guest\PagesController@show')->name('mypage');
    Route::get('followings/{id}', 'Guest\FollowsController@showFollowings')->name('followings');
    Route::get('followers/{id}', 'Guest\FollowsController@showFollowers')->name('followers');
});



Auth::routes();
//ログイン時
Route::group(['prefix' => 'user',['middleware' => 'auth']], function () {
    Route::get('timeline/','User\TimelineController@index')->name('user_timeline');
    Route::post('/','User\TimelineController@post')->name('post');
    Route::get('detail/{id}','User\TimelineController@show')->name('user_postdetail');
    Route::post('detail','User\TimelineController@comment')->name('comment');;
    Route::get('detail/edit/{id}','User\TimelineController@edit');
    Route::post('detail/edit','User\TimelineController@update');
    Route::post('detail/{id}','User\TimelineController@delete')->name('delete');
    Route::get('users/{id}','User\PagesController@show')->name('mypage');
    Route::get('users/edit/{id}','User\PagesController@edit');
    Route::post('users/edit','User\PagesController@update');
    Route::get('followings/{id}', 'User\FollowsController@showFollowings')->name('followings');
    Route::get('followers/{id}', 'User\FollowsController@showFollowers')->name('followers');
    Route::post('follow/{id}', 'User\FollowsController@store')->name('follow');
    Route::delete('unfollow/{id}', 'User\FollowsController@destroy')->name('unfollow');
    Route::get('/search', 'User\TimelineController@search')->name('search');
    Route::post('like','User\LikesController@store')->name('like');
    Route::delete('unlike','User\LikesController@destroy')->name('unlike');
});
