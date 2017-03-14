<?= "<?php\n" ?>

$router->get('{{ str_slug($gen->tableName, $separator = "-") }}/form-model/{model}', [
    'uses'  => '{{ $gen->entityName() }}Controller@formModel',
    'middleware' => [
      'api.auth',
    ],
]);
