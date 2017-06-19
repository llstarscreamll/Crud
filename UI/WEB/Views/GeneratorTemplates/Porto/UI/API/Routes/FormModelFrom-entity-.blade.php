<?= "<?php\n" ?>

$router->get('{{ str_slug($crud->tableName, $separator = "-") }}/form-model', [
    'uses'  => '{{ $crud->entityName() }}Controller@formModel',
    'middleware' => [
      'auth:api',
    ],
]);
