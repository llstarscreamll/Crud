<?= "<?php\n" ?>

$router->get('{{ str_slug($gen->tableName, $separator = "-") }}', [
    'uses'  => '{{ $gen->entityName() }}Controller@listAndSearch{{ str_plural($gen->entityName()) }}',
    'middleware' => [
      'auth:api',
    ],
]);
