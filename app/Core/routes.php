<?php

Route::get('/', ['as' => 'home', 'uses' => 'IndexController@index']);
Route::get('/create', ['as' => 'create', 'uses' => 'IndexController@create']);