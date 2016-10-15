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

Route::group(
    [
        'prefix' => 'crudGenerator',
        'middleware' => ['web', 'auth'],
        'namespace' => 'llstarscreamll\CrudGenerator\App\Http\Controllers',
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
