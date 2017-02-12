<?= "<?php\n" ?>

$router->post('{{ str_slug($gen->tableName, $separator = "-") }}/update', [
    'uses'  => 'Controller@update{{ $gen->entityName() }}',
    'middleware' => [
      'api.auth',
    ],
]);
