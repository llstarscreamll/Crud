<?= "<?php\n" ?>

namespace App\Containers\{{ $crud->containerName() }}\Data\Criterias;

use Prettus\Repository\Contracts\RepositoryInterface as PrettusRepositoryInterface;
use App\Ship\Parents\Criterias\Criteria;

/**
 * {{ $criteria = str_replace('.php', '', $crud->criteriaFile('Advanced-entity-Search')) }} Class.
 * 
 * @author [name] <[<email address>]>
 */
class {{ $criteria }} extends Criteria
{
	private $input;

    /**
     * Create new {{ $criteria }} instance.
     *
     * @param  Request $request
     */
    public function __construct($input)
    {
        $this->input = $input;
    }

	/**
     * @param $model
     * @param PrettusRepositoryInterface $repository
     *
     * @return Illuminate\Database\Eloquent\Builder
     */
	public function apply($model, PrettusRepositoryInterface $repository)
    {
@foreach ($fields as $field)
@if (!$field->hidden)
@if ($field->type == 'tinyint')
        $model = $this->input->has('{{ $field->name }}_true')
            ? $model->where({{ $crud->getConditionStr($field, 'true') }})
            : $model;

        $model = $this->input->has('{{ $field->name }}_false' && !$this->input->has('{{ $field->name }}_true')
            ? $model->where({{ $crud->getConditionStr($field, 'false') }})
            : $model;

        $model = $this->input->has('{{ $field->name }}_false') && $this->input->has('{{ $field->name }}_true')
            ? $model->orWhere({{ $crud->getConditionStr($field, 'false') }})
            : $model;

@elseif ($field->type == 'enum' || $field->key == 'MUL' || $field->key == 'PRI')
        $model = $this->input->has('{{ $field->name == 'id' ? 'id' : $field->name }}')
            ? $model->whereIn({!! $crud->getConditionStr($field) !!})
            : $model;

@elseif ($field->type == 'date' || $field->type == 'timestamp' || $field->type == 'datetime')
        $model = $this->input->has('{{ $field->name }}')
            ? $model->whereBetween('{{ $field->name }}', $this->input->get('{{ $field->name }}'))
            : $model;

@else
        $model = $this->input->has('{{ $field->name }}')
            ? $model->where({!! $crud->getConditionStr($field) !!})
            : $model;

@endif
@endif
@endforeach
        // sort results
        $model->orderBy($this->input->get('orderBy', '{{ $crud->hasLaravelTimestamps ? 'created_at' : 'name' }}'), $this->input->get('sortedBy', 'desc'));

        return $model;
    }
}