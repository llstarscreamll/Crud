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
     * Crea nueva instancia de {{ $criteria }}.
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
    	$model = $model->query();

@foreach ($fields as $field)
@if (!$field->hidden)
@if ($field->type == 'tinyint')
        $this->input->has('{{ $field->name }}_true') && $model->where({{ $gen->getConditionStr($field, 'true') }});
        ($this->input->has('{{ $field->name }}_false') && !$this->input->has('{{ $field->name }}_true')) && $model->where({{ $gen->getConditionStr($field, 'false') }});
        ($this->input->has('{{ $field->name }}_false') && $this->input->has('{{ $field->name }}_true')) && $model->orWhere({{ $gen->getConditionStr($field, 'false') }});

@elseif ($field->type == 'enum' || $field->key == 'MUL' || $field->key == 'PRI')
        $this->input->has('{{ $field->name == 'id' ? 'id' : $field->name }}') && $model->whereIn({!! $gen->getConditionStr($field) !!});

@elseif ($field->type == 'date' || $field->type == 'timestamp' || $field->type == 'datetime')
        $this->input->has('{{ $field->name }}') && $model->whereBetween('{{ $field->name }}', $this->input->get('{{ $field->name }}'));

@else
        $this->input->has('{{ $field->name }}') && $model->where({!! $gen->getConditionStr($field) !!});

@endif
@endif
@endforeach
@if ($gen->hasSoftDeleteColumn)
        // trashed records
        $this->input->has('trashed') && $model->{$this->input->get('trashed')}();
@endif
        // sort resutls
        $model->orderBy($this->input->get('orderBy', '{{ $gen->hasLaravelTimestamps ? 'created_at' : 'name' }}'), $this->input->get('sortedBy', 'desc'));

        return $model;
    }
}