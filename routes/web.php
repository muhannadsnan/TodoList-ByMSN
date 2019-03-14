<?php

Route::get('/todos', 'TodosController@index')->name('home');
Route::post('/todos', 'TodosController@store');
Route::get('/todos/{todo}', 'TodosController@show');
Route::put('/todos/{todo}', 'TodosController@edit');
Route::delete('/todos/{todo}', 'TodosController@destroy');

Route::post('/items', 'ItemsController@store');
Route::put('/items/{item}', 'ItemsController@edit');
Route::delete('/items/{item}', 'ItemsController@destroy');
