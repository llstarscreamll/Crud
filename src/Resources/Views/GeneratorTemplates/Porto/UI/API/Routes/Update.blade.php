<?= "<?php\n" ?>

$router->put('{{ str_slug($gen->tableName, $separator = "-") }}/{id}', [
    'uses'  => 'Controller@update{{ $gen->entityName() }}',
    'middleware' => [
      'api.auth',
    ],
]);
