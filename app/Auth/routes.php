<?php

Route::group(['prefix' => 'auth', 'as' => 'auth.'], function () {
    Route::get('login', ['as' => 'login', 'uses' => 'AuthController@getLogin']);
    Route::post('login', ['as' => 'login', 'uses' => 'AuthController@postLogin']);
    Route::get('logout', ['as' => 'logout', 'uses' => 'AuthController@getLogout']);

    Route::get('register', ['as' => 'register', 'uses' => 'AuthController@getRegister']);
    Route::post('register', ['as' => 'register', 'uses' => 'AuthController@postRegister']);

    Route::group(['prefix' => 'password', 'as' => 'password.'], function () {
        Route::get('email', ['as' => 'email', 'uses' =>'PasswordController@getEmail']);
        Route::post('email', ['as' => 'email', 'uses' => 'PasswordController@postEmail']);

        Route::get('reset/{token}', ['as' => 'reset', 'uses' => 'PasswordController@getReset']);
        Route::post('reset', ['as' => 'reset', 'uses' => 'PasswordController@postReset']);
    });
});