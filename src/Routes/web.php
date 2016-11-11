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
        'prefix' => 'crud',
        'middleware' => ['web', 'auth'],
        'namespace' => 'llstarscreamll\Crud\Http\Controllers',
    ],
    function () {
        Route::get(
            '/',
            [
                'as' => 'crud.index',
                'uses' => 'GeneratorController@index'
            ]
        );

        Route::post(
            '/fire',
            [
                'as' => 'crud.generate',
                'uses' => 'GeneratorController@generate'
            ]
        );

        Route::get(
            '/showOptions',
            [
                'as' => 'crud.showOptions',
                'uses' => 'GeneratorController@showOptions'
            ]
        );
    }
);
