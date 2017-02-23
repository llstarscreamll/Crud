<?= "<?php\n" ?>

$router->get('{{ str_slug($gen->tableName, $separator = "-") }}/{id}', [
    'uses'  => 'Controller@get{{ $gen->entityName() }}',
    'middleware' => [
      'api.auth',
    ],
]);
