<?= "<?php\n" ?>

$router->get('{{ str_slug($gen->tableName, $separator = "-") }}/{{ $gen->slugEntityName() }}-form-data', [
    'uses'  => 'Controller{{ "@".camel_case($gen->entityName()) }}formData',
    'middleware' => [
      'api.auth',
    ],
]);
