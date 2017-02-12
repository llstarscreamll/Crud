<?= "<?php\n" ?>

$router->post('{{ str_slug($gen->tableName, $separator = "_") }}/create', [
    'uses'  => 'Controller@createAdmin',
    'middleware' => [
      'api.auth',
    ],
]);