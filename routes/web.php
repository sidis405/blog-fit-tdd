<?php


Route::get('/', function () {
    return view('welcome');
});

Route::get('/', 'PostsController@index')->name('posts.index');
Route::get('posts/create', 'PostsController@create')->name('posts.create');
Route::get('posts/{post}', 'PostsController@show')->name('posts.show');
Route::post('posts', 'PostsController@store')->name('posts.store');

Route::get('posts/{post}/edit', 'PostsController@edit')->name('posts.edit');
Route::patch('posts/{post}', 'PostsController@update')->name('posts.update');
