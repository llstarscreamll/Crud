<?php

$router->get('books/{id}', [
    'uses'  => 'BookController@getBook',
    'middleware' => [
      'auth:api',
    ],
]);
