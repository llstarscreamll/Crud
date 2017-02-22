<?= "<?php\n" ?>

use {{ $gen->entityModelNamespace() }};

$factory->define({{ $gen->entityName() }}::class, function (Faker\Generator $faker) {
@foreach($fields as $field)
@if ($field->namespace)
    {{ $gen->variableFromNamespace($field->namespace, $singular = false) }} = {{ $field->namespace }}::all('id')->pluck('id')->toArray();
@endif
@endforeach

    return [
@foreach ($fields as $key => $field)
@if ($field->key !== 'PRI')
        '{{ $field->name }}' => {!! $gen->getFakeData($field, $onlyFaker = true) !!},
@endif
@endforeach
    ];
});
