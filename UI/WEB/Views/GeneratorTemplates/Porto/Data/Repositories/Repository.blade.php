<?= "<?php\n" ?>

namespace App\Containers\{{ $gen->containerName() }}\Data\Repositories;

use Illuminate\Http\Request;
use App\Ship\Parents\Repositories\Repository;
use App\Ship\Features\Criterias\Eloquent\TrashedCriteria;

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
@foreach($fields as $field)
@if($field->fillable)
        '{{ $field->name }}' => 'like',
@endif
@if ($field->namespace && $field->fillable)
        '{{ $gen->relationNameFromField($field) }}.name' => 'like',
@endif
@endforeach
    ];
@if($gen->hasSoftDeleteColumn)
    
    /**
     * Push the parent and Trashed criterias.
     */
    public function boot()
    {
        parent::boot();
        $this->pushCriteria(new TrashedCriteria(app(Request::class)->get('trashed', '')));
    }

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