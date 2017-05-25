<?php

$router->delete('books/{id}', [
    'uses'  => 'BookController@deleteBook',
    'middleware' => [
      'auth:api',
    ],
]);
