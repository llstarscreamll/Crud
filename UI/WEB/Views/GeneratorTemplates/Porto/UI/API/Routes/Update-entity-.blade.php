<?= "<?php\n" ?>

$router->put('{{ str_slug($gen->tableName, $separator = "-") }}/{id}', [
    'uses'  => '{{ $gen->entityName() }}Controller@update{{ $gen->entityName() }}',
    'middleware' => [
      'auth:api',
    ],
]);
