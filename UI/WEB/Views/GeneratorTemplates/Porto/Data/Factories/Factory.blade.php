<?= "<?php\n" ?>

@foreach($fields->unique('namespace') as $field)
@if ($field->namespace)
use {{ $field->namespace }};
@endif
@endforeach
use {{ $gen->entityModelNamespace() }};

$factory->define({{ $gen->entityName() }}::class, function (Faker\Generator $faker) {
@foreach($fields->unique('namespace') as $field)
@if ($field->namespace)
    {{ $gen->variableFromNamespace($field->namespace, $singular = false) }} = factory({{ class_basename($field->namespace) }}::class, 2)->create()->pluck('id')->toArray();
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
