<?= "<?php\n" ?>

$router->post('{{ str_slug($crud->tableName, $separator = "-") }}/{id}/restore', [
    'uses'  => '{{ $crud->entityName() }}Controller@restore{{ $crud->entityName() }}',
    'middleware' => [
      'auth:api',
    ],
]);
