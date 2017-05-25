<?php

$router->put('books/{id}', [
    'uses'  => 'BookController@updateBook',
    'middleware' => [
      'auth:api',
    ],
]);
