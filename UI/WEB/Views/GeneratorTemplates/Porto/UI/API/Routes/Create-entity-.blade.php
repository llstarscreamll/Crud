<?= "<?php\n" ?>

$router->post('{{ str_slug($crud->tableName, $separator = "-") }}/create', [
    'uses'  => '{{ $crud->entityName() }}Controller@create{{ $crud->entityName() }}',
    'middleware' => [
      'auth:api',
    ],
]);
