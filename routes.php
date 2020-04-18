<?php
use Illuminate\Http\Request;

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
    return view('mindyourteam::welcome');
});

Route::get('/home', function (Request $request) {
    return view('mindyourteam::home', [ 'user' => $request->user() ]);
    //return redirect('/wordcloud/1/create');
});

Route::get('login', 'LoginController@showLoginForm')->name('login');
Route::get('logout', 'LoginController@logout')->name('logout');
Route::post('login', 'LoginController@login')->name('authenticate');
Route::get('login/{token}', 'LoginController@withToken')->name('withtoken');

Route::middleware('auth')->group(function () {
    Route::get('wordcloud/{wordcloud}', 'WordcloudController@show')->name('wordcloud.show');
    Route::get('wordcloud/{wordcloud}/create', 'WordcloudController@form')->name('wordcloud.form');
    Route::post('wordcloud/{wordcloud}', 'WordcloudController@contribute')->name('wordcloud.contribute');
    
    Route::get('product/{productplan}', 'ProductController@index')->name('product');
    Route::get('topic/{product}', 'TopicController@index')->name('topic');
    Route::post('topic/{product}', 'TopicController@store')->name('topic.store');
    Route::put('topic/{topic}', 'TopicController@update')->name('topic.update');

    Route::post('publish', 'ProductplanController@publish')->name('plan.publish');

    Route::get('culture', 'CultureQuestionController@index')->name('culture');
});
