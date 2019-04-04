<?php
use Illuminate\Http\Request;

Route::get('test1', 'PostsController@index')->name('api.test1');
Route::get('test2', 'PostsController@index')->name('api.test2');

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
