<?= "<?php\n" ?>

$router->get('{{ str_slug($gen->tableName, $separator = "-") }}/form-data/{{ $gen->slugEntityName() }}', [
    'uses'  => 'Controller{{ "@".camel_case($gen->entityName()) }}formData',
    'middleware' => [
      'api.auth',
    ],
]);
