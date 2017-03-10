<?php
/* @var $gen App\Containers\Crud\Providers\TestsGenerator */
/* @var $fields [] */
/* @var $request Request */
?>
<?='<?php'?>


<?= $gen->getClassCopyRightDocBlock() ?>


namespace <?= config('modules.crud.config.parent-app-namespace') ?>\Repositories\Criterias;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;
use Illuminate\Support\Collection;

/**
 * Class <?= $gen->getRepositoryCriteriaName()."\n" ?>
 *
 * @author <?= config('modules.crud.config.author') ?> <<?= config('modules.crud.config.author_email') ?>>
 */
class <?= $gen->getRepositoryCriteriaName() ?> implements CriteriaInterface
{
    /**
     * @var Illuminate\Support\Collection
     */
    private $input;

    /**
     * Crea nueva instancia de <?= $gen->getRepositoryCriteriaName() ?>.
     *
     * @param  Request $request
     */
    public function __construct(Collection $input)
    {
        $this->input = $input;
    }

    /**
     * Apply criteria in query repository
     *
     * @param <?= $gen->modelClassName() ?> $model
     * @param RepositoryInterface $repository
     *
     * @return Illuminate\Database\Eloquent\Builder
     */
    public function apply($model, RepositoryInterface $repository)
    {
        $model = $model->query();

        // buscamos basados en los datos que señale el usuario
<?php foreach ($fields as $field) { ?>
<?php if (!$field->hidden) { ?>
<?php if ($field->type == 'tinyint') { ?>
        $this->input->get('<?= $field->name ?>_true') && $model->where(<?= $gen->getConditionStr($field, 'true') ?>);
        ($this->input->get('<?= $field->name ?>_false') && !$this->input->has('<?= $field->name ?>_true')) && $model->where(<?= $gen->getConditionStr($field, 'false') ?>);
        ($this->input->get('<?= $field->name ?>_false') && $this->input->has('<?= $field->name ?>_true')) && $model->orWhere(<?= $gen->getConditionStr($field, 'false') ?>);

<?php } elseif ($field->type == 'enum' || $field->key == 'MUL' || $field->key == 'PRI') { ?>
<?php $name = $field->name == 'id' ? 'ids' : $field->name ?>
        $this->input->get('<?= $name ?>') && $model->whereIn(<?= $gen->getConditionStr($field) ?>);

<?php } elseif ($field->type == 'date' || $field->type == 'timestamp' || $field->type == 'datetime') { ?>
        $this->input->get('<?= $field->name ?>')['informative'] && $model->whereBetween('<?= $field->name ?>', [
            $this->input->get('<?= $field->name ?>')['from'],
            $this->input->get('<?= $field->name ?>')['to']
        ]);

<?php } else { ?>
        $this->input->get('<?= $field->name ?>') && $model->where(<?= $gen->getConditionStr($field) ?>);

<?php } ?>
<?php } ?>
<?php } ?>
<?php if ($gen->hasDeletedAtColumn($fields)) { ?>
        // registros en papelera
        $this->input->has('trashed_records') && $model->{$this->input->get('trashed_records')}();
<?php } ?>
        // ordenamos los resultados
        $model->orderBy($this->input->get('sort', '<?= $gen->hasLaravelTimestamps($fields) ? 'created_at' : 'name' ?>'), $this->input->get('sortType', 'desc'));

        return $model;
    }
}
