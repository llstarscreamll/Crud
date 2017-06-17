<?= "<?php\n" ?>

$router->delete('{{ str_slug($crud->tableName, $separator = "-") }}/{id}', [
    'uses'  => '{{ $crud->entityName() }}Controller@delete{{ $crud->entityName() }}',
    'middleware' => [
      'auth:api',
    ],
]);
