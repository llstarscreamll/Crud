<?= "<?php\n" ?>

$router->get('{{ str_slug($gen->tableName, $separator = "-") }}/form-data', [
    'uses'  => '{{ $gen->entityName() }}Controller{{ "@".camel_case($gen->entityName()) }}formData',
    'middleware' => [
      'auth:api',
    ],
]);
