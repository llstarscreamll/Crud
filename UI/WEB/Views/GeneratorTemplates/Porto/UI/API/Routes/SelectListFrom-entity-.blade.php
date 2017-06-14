<?= "<?php\n" ?>

$router->get('{{ str_slug($gen->tableName, $separator = "-") }}/form/select-list', [
    'uses'  => '{{ $gen->entityName() }}Controller{{ "@selectListFrom".$gen->entityName() }}',
    'middleware' => [
      'auth:api',
    ],
]);
