<?= "<?php\n" ?>

namespace App\Containers\{{ $gen->containerName() }}\Data\Criterias\{{ $gen->entityName() }};

use App\Containers\{{ $gen->containerName() }}\Data\Criterias\{{ $gen->entityName() }};
use Prettus\Repository\Contracts\RepositoryInterface as PrettusRepositoryInterface;
use App\Ship\Parents\Criterias\Criteria;

/**
 * {{ $criteria = str_replace('.php', '', $gen->criteriaFile('Advanced:entity:Search')) }} Class.
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
            ? $model->where({{ $gen->getConditionStr($field, 'true') }})
            : $model;

        $model = $this->input->has('{{ $field->name }}_false' && !$this->input->has('{{ $field->name }}_true')
            ? $model->where({{ $gen->getConditionStr($field, 'false') }})
            : $model;

        $model = $this->input->has('{{ $field->name }}_false') && $this->input->has('{{ $field->name }}_true')
            ? $model->orWhere({{ $gen->getConditionStr($field, 'false') }})
            : $model;

@elseif ($field->type == 'enum' || $field->key == 'MUL' || $field->key == 'PRI')
        $model = $this->input->has('{{ $field->name == 'id' ? 'id' : $field->name }}')
            ? $model->whereIn({!! $gen->getConditionStr($field) !!})
            : $model;

@elseif ($field->type == 'date' || $field->type == 'timestamp' || $field->type == 'datetime')
        $model = $this->input->has('{{ $field->name }}')
            ? $model->whereBetween('{{ $field->name }}', $this->input->get('{{ $field->name }}'))
            : $model;

@else
        $model = $this->input->has('{{ $field->name }}')
            ? $model->where({!! $gen->getConditionStr($field) !!})
            : $model;

@endif
@endif
@endforeach
        // sort results
        $model->orderBy($this->input->get('orderBy', '{{ $gen->hasLaravelTimestamps ? 'created_at' : 'name' }}'), $this->input->get('sortedBy', 'desc'));

        return $model;
    }
}