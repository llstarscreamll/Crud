<?= "<?php\n" ?>

namespace App\Containers\{{ $crud->containerName() }}\Data\Repositories;

use Illuminate\Http\Request;
use App\Ship\Parents\Repositories\Repository;
use App\Ship\Criterias\Eloquent\TrashedCriteria;

/**
 * {{ $crud->entityName() }}Repository Class.
 * 
 * @author [name] <[<email address>]>
 */
class {{ $crud->entityName() }}Repository extends Repository
{
	/**
	 * Container name reference for set the model.
	 *
	 * @var string
	 */
	protected $container = '{{ $crud->containerName() }}';

	/**
     * @var array
     */
    protected $fieldSearchable = [
@foreach($fields as $field)
@if($field->fillable)
        '{{ $field->name }}' => 'like',
@endif
@if ($field->namespace && $field->fillable)
        '{{ $crud->relationNameFromField($field) }}.name' => 'like',
@endif
@endforeach
    ];
@if($crud->hasSoftDeleteColumn)
    
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
     * @return App\Containers\{{ $crud->containerName() }}\Models\{{ $crud->entityName() }} ${{ camel_case($entityClass = $crud->entityName()) }}
     */
    public function restore(int $id)
    {
        $this->model->withTrashed()->find($id)->restore();
        return $this->model->find($id);
    }
@endif
}