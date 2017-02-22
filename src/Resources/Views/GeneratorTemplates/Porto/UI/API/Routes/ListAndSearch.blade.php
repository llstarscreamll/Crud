<?= "<?php\n" ?>

$router->get('{{ str_slug($gen->tableName, $separator = "-") }}', [
    'uses'  => 'Controller@listAndSearch{{ str_plural($gen->entityName()) }}',
    'middleware' => [
      'api.auth',
    ],
]);
