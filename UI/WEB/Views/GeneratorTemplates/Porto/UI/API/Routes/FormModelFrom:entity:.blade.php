<?= "<?php\n" ?>

$router->get('{{ str_slug($gen->tableName, $separator = "-") }}/form-model', [
    'uses'  => '{{ $gen->entityName() }}Controller@formModel',
    'middleware' => [
      'auth:api',
    ],
]);
