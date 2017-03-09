<?= "<?php\n" ?>

$router->delete('{{ str_slug($gen->tableName, $separator = "-") }}/{id}', [
    'uses'  => 'Controller@delete{{ $gen->entityName() }}',
    'middleware' => [
      'api.auth',
    ],
]);
