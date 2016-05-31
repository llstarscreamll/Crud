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

Route::get(
    'crudGenerator/',
    [
    'as'    => 'crudGenerator.index',
    'uses'    => 'llstarscreamll\CrudGenerator\App\Http\Controllers\GeneratorController@index'
    ]
);

Route::post(
    'crudGenerator/',
    [
    'as'    => 'crudGenerator.generate',
    'uses'    => 'llstarscreamll\CrudGenerator\App\Http\Controllers\GeneratorController@generate'
    ]
);

Route::get(
    'showOptions/',
    [
    'as'    => 'crudGenerator.showOptions',
    'uses'    => 'llstarscreamll\CrudGenerator\App\Http\Controllers\GeneratorController@showOptions'
    ]
);
