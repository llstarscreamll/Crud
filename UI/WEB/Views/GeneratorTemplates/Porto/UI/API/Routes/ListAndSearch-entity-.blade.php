<?= "<?php\n" ?>

$router->get('{{ str_slug($crud->tableName, $separator = "-") }}', [
    'uses'  => '{{ $crud->entityName() }}Controller@listAndSearch{{ str_plural($crud->entityName()) }}',
    'middleware' => [
      'auth:api',
    ],
]);
