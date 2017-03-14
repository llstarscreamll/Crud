<?= "<?php\n" ?>

$router->post('{{ str_slug($gen->tableName, $separator = "-") }}/create', [
    'uses'  => '{{ $gen->entityName() }}Controller@create{{ $gen->entityName() }}',
    'middleware' => [
      'api.auth',
    ],
]);
