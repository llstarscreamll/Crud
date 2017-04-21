<?= "<?php\n" ?>

$router->get('{{ str_slug($gen->tableName, $separator = "-") }}/{id}', [
    'uses'  => '{{ $gen->entityName() }}Controller@get{{ $gen->entityName() }}',
    'middleware' => [
      'auth:api',
    ],
]);
