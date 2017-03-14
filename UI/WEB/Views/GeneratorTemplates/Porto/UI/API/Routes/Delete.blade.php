<?= "<?php\n" ?>

$router->delete('{{ str_slug($gen->tableName, $separator = "-") }}/{id}', [
    'uses'  => '{{ $gen->entityName() }}Controller@delete{{ $gen->entityName() }}',
    'middleware' => [
      'api.auth',
    ],
]);
