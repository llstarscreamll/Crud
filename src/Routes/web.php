<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Route::group(
    [
        'prefix' => 'crudGenerator',
        'middleware' => ['web', 'auth'],
        'namespace' => 'llstarscreamll\CrudGenerator\Http\Controllers',
    ],
    function () {
        Route::get(
            '/',
            [
                'as' => 'crudGenerator.index',
                'uses' => 'GeneratorController@index'
            ]
        );

        Route::post(
            '/fire',
            [
                'as' => 'crudGenerator.generate',
                'uses' => 'GeneratorController@generate'
            ]
        );

        Route::get(
            '/showOptions',
            [
                'as' => 'crudGenerator.showOptions',
                'uses' => 'GeneratorController@showOptions'
            ]
        );
    }
);
