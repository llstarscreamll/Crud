<?php

$router->get('books', [
    'uses'  => 'BookController@listAndSearchBooks',
    'middleware' => [
      'auth:api',
    ],
]);
