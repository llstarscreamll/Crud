<?php

$router->post('books/{id}/restore', [
    'uses'  => 'BookController@restoreBook',
    'middleware' => [
      'auth:api',
    ],
]);
