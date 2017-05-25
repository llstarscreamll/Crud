<?php

$router->post('books/create', [
    'uses'  => 'BookController@createBook',
    'middleware' => [
      'auth:api',
    ],
]);
