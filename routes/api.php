<?php

// auth.middleware

// login
Route::post('login', 'Api\LoginController')->name('api.login');
// registration
Route::post('register', 'Api\RegisterController')->name('api.register');
// me

Route::middleware('jwt.auth')->group(function () {
    Route::get('me', 'Api\MeController')->name('api.me');
});

Route::as('api')->resource('posts', 'Api\PostsController')->except('destroy', 'edit', 'create');
