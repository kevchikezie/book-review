<?php

use Illuminate\Http\Request;

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix' => '/v1', 'namespace' => 'Api'], function () {
	Route::get('/books', 'BookController@index')->name('api.books.index');
	Route::post('/books', 'BookController@store')->name('api.books.store');
	Route::put('/books/{id}', 'BookController@update')->name('api.books.update');
	Route::delete('/books/{id}', 'BookController@destroy')->name('api.books.destroy');
});
