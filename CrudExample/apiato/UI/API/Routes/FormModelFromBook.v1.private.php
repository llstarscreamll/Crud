<?php

$router->get('books/form-model', [
    'uses'  => 'BookController@formModel',
    'middleware' => [
      'auth:api',
    ],
]);
