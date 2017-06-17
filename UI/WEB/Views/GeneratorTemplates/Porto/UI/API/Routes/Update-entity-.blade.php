<?= "<?php\n" ?>

$router->put('{{ str_slug($crud->tableName, $separator = "-") }}/{id}', [
    'uses'  => '{{ $crud->entityName() }}Controller@update{{ $crud->entityName() }}',
    'middleware' => [
      'auth:api',
    ],
]);
