<?php


Route::get('/', 'TodosController@home');
Route::get('/todos', 'TodosController@index')->name('home');
Route::post('/todos', 'TodosController@store');
Route::get('/todos/{todo}', 'TodosController@show');
Route::put('/todos/{todo}', 'TodosController@update');
Route::delete('/todos/{todo}', 'TodosController@destroy');
Route::get('/todos/{todo}/items', 'TodosController@getItemsByTodo');

Route::post('/items', 'ItemsController@store');
Route::put('/items/{item}', 'ItemsController@update');
Route::delete('/items/{item}', 'ItemsController@destroy');
