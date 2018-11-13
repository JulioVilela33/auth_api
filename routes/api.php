<?php

use Illuminate\Http\Request;

Route::post('login', 'AuthController@login');
Route::post('register', 'AuthController@register');