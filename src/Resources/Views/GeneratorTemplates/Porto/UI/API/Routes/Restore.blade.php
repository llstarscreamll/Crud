<?= "<?php\n" ?>

$router->post('{{ str_slug($gen->tableName, $separator = "-") }}/restore', [
    'uses'  => 'Controller@restore{{ $gen->entityName() }}',
    'middleware' => [
      'api.auth',
    ],
]);
