<?php

use Illuminate\Support\Facades\Route;

Route::group(['namespace' => 'Api'], function () {
	Route::group(['prefix' => 'login'], function () {
		Route::post('/', 'AuthController@login');
	});
	Route::group(['prefix' => 'product', 'middleware' => ['auth:api']], function () {
		Route::get('/', 'ProductController@index');
		Route::post('store', 'ProductController@store');
		Route::get('show/{id}', 'ProductController@show');
		Route::post('update/{id}', 'ProductController@update');
		Route::get('delete/{id}', 'ProductController@delete');
	});
	Route::group(['prefix' => 'user', 'middleware' => ['auth:api']], function () {
		Route::get('/', 'UserController@index');
		Route::post('store', 'UserController@store');
		Route::get('show/{id}', 'UserController@show');
		Route::post('update/{id}', 'UserController@update');
		Route::get('delete/{id}', 'UserController@delete');
	});
	Route::group(['prefix' => 'shop'], function () {
		Route::post('store', 'ShopController@store');
	});
	Route::group(['prefix' => 'frontend'], function () {
		Route::get('products', 'ProductController@index');
	});
});