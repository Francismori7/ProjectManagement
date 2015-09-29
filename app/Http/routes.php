<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

use App\Repositories\Contracts\UserRepository;
use App\User;

Route::get('/', ['as' => 'home', 'uses' => 'IndexController@index']);
Route::get('/create', ['as' => 'create', 'uses' => 'IndexController@create']);