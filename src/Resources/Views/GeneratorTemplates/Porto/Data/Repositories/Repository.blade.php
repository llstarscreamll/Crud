<?= "<?php\n" ?>

namespace App\Containers\{{ $gen->containerName() }}\Data\Repositories;

use App\Ship\Parents\Repositories\Repository;

class {{ $gen->entityName() }}Repository extends Repository
{
	/**
	 * Container name reference for set the model.
	 *
	 * @var string
	 */
	protected $container = '{{ $gen->containerName() }}';

	/**
     * @var array
     */
    protected $fieldSearchable = [
{{-- we should have a property fillable for each filed --}}
@foreach($fields as $field)
@if($field->fillable)
        '{{ $field->name }}' => 'like',
@endif
@endforeach
    ];
@if($gen->hasSoftDeleteColumn)
    /**
     * Restores a softdeleted row.
     * @param  int $id
     * @return App\Containers\{{ $gen->containerName() }}\Models\{{ $gen->entityName() }} ${{ camel_case($entityClass = $gen->entityName()) }}
     */
    public function restore(int $id)
    {
        $this->model->withTrashed()->find($id)->restore();
        return $this->model->find($id);
    }
@endif
}