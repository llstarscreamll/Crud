<?php

$router->get('books/form/select-list', [
    'uses'  => 'BookController@selectListFromBook',
    'middleware' => [
      'auth:api',
    ],
]);
