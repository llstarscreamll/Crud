<?= "<?php\n" ?>

$router->post('{{ str_slug($gen->tableName, $separator = "-") }}/delete', [
    'uses'  => 'Controller@delete{{ $gen->entityName() }}',
    'middleware' => [
      'api.auth',
    ],
]);
