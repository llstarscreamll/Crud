<?= "<?php\n" ?>

$router->post('{{ str_slug($gen->tableName, $separator = "-") }}/create', [
    'uses'  => 'Controller@create{{ $gen->entityName() }}',
    'middleware' => [
      'api.auth',
    ],
]);
