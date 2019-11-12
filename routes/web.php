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

Route::get('/home', function () {
    return redirect('/wordcloud/1/create');
});

Route::get('login', 'LoginController@showLoginForm')->name('login');
Route::get('logout', 'LoginController@logout')->name('logout');
Route::post('login', 'LoginController@login')->name('authenticate');
Route::get('login/{token}', 'LoginController@withToken')->name('withtoken');

Route::middleware('auth')->group(function () {
    Route::get('wordcloud/{wordcloud}', 'WordcloudController@show')->name('wordcloud.show');
    Route::get('wordcloud/{wordcloud}/create', 'WordcloudController@form')->name('wordcloud.form');
    Route::post('wordcloud/{wordcloud}', 'WordcloudController@contribute')->name('wordcloud.contribute');
});