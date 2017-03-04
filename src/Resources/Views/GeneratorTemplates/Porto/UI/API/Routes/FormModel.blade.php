<?= "<?php\n" ?>

$router->get('{{ str_slug($gen->tableName, $separator = "-") }}/form-model', [
    'uses'  => 'Controller@formModel',
    'middleware' => [
      'api.auth',
    ],
]);
