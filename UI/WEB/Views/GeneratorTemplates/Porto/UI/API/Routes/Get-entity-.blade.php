<?= "<?php\n" ?>

$router->get('{{ str_slug($crud->tableName, $separator = "-") }}/{id}', [
    'uses'  => '{{ $crud->entityName() }}Controller@get{{ $crud->entityName() }}',
    'middleware' => [
      'auth:api',
    ],
]);
