<?= "<?php\n" ?>

$router->post('{{ str_slug($gen->tableName, $separator = "-") }}/list', [
    'uses'  => 'Controller@list{{ str_plural($gen->entityName()) }}',
    'middleware' => [
      'api.auth',
    ],
]);
