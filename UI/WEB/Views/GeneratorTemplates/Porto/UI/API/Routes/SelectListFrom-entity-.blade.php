<?= "<?php\n" ?>

$router->get('{{ str_slug($crud->tableName, $separator = "-") }}/form/select-list', [
    'uses'  => '{{ $crud->entityName() }}Controller{{ "@selectListFrom".$crud->entityName() }}',
    'middleware' => [
      'auth:api',
    ],
]);
