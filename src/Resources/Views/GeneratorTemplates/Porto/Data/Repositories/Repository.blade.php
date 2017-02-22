<?= "<?php\n" ?>

namespace App\Containers\{{ $gen->containerName() }}\Data\Repositories;

use App\Ship\Parents\Repositories\Repository;

class {{ $gen->entityName() }}Repository extends Repository
{
	/**
     * @var array
     */
    protected $fieldSearchable = [
{{-- we should have a property fillable for each filed --}}
@foreach($fields as $field)
@if($field->fillable)
        '{{ $field->name }}',
@endif
@endforeach
    ];
}