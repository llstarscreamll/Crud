<?php
/* @var $gen llstarscreamll\Crud\Providers\TestsGenerator */
/* @var $fields [] */
/* @var $request Request */
/* @var $foreign_keys [] */
?>
<?= '<?php'?>


<?=  $gen->getClassCopyRightDocBlock() ?>


namespace <?= config('modules.crud.config.parent-app-namespace') ?>\Services;

use <?= config('modules.crud.config.parent-app-namespace') ?>\Http\Requests\<?= $gen->modelClassName()."Request" ?>;
use <?= config('modules.crud.config.parent-app-namespace') ?>\Repositories\Contracts\<?= $gen->modelClassName() ?>Repository;
use <?= config('modules.crud.config.parent-app-namespace') ?>\Models\<?= $gen->modelClassName() ?>;
<?php foreach ($foreign_keys as $foreign) { ?>
<?php if (($class = $gen->getForeignKeyModelNamespace($foreign, $fields)) !== false) { ?>
use <?= $gen->getModelRepositoryNamespace($class) ?>;
<?php } ?>
<?php } ?>
use Illuminate\Support\Collection;

/**
 * Clase <?= $gen->modelClassName()."Service\n" ?>
 *
 * @author <?= config('modules.crud.config.author') ?> <<?= config('modules.crud.config.author_email') ?>>
 */
class <?= $gen->modelClassName() ?>Service
{
    /**
     * @var <?= config('modules.crud.config.parent-app-namespace') ?>\Repositories\Contracts\<?= $gen->modelClassName() ?>Repository
     */
    private $<?= $gen->modelVariableName() ?>Repository;
<?php foreach ($foreign_keys as $foreign) { ?>
<?php if (($class = $gen->getForeignKeyModelNamespace($foreign, $fields)) !== false) { ?>
    
    /**
     * @var <?= $gen->getModelRepositoryNamespace($class)."\n" ?>
     */
    private <?= $gen->modelVariableNameFromClass($class)."Repository;\n" ?>
<?php } ?>
<?php } ?>

    /**
     * Las columnas predeterminadas a mostrar en la tabla del Index.
     *
     * @var array
     */
    private $defaultSelectedtableColumns = [
<?php foreach ($fields as $field) { ?>
<?php if ($field->on_index_table && !$field->hidden) { ?>
        '<?= $field->name ?>',
<?php } ?>
<?php } ?>
    ];

    /**
     * Las columnas o atributos que deben ser consultados de la base de datos,
     * así el usuario no lo especifique.
     *
     * @var array
     */
    private $forceQueryColumns = [
        'id',
<?php if ($gen->hasDeletedAtColumn($fields)) { ?>
        'deleted_at'
<?php } ?>
    ];

    /**
     * Crea nueva instancia del servicio.
     *
     * @param <?= config('modules.crud.config.parent-app-namespace') ?>\Repositories\Contracts\<?= $gen->modelClassName() ?>Repository $<?= $gen->modelVariableName() ?>Repository
<?php foreach ($foreign_keys as $foreign) { ?>
<?php if (($class = $gen->getForeignKeyModelNamespace($foreign, $fields)) !== false) { ?>
     * @param <?= ($class = $gen->getModelRepositoryNamespace($class))." ".$gen->modelVariableNameFromClass($class)."\n" ?>
<?php } ?>
<?php } ?>
     */
    public function __construct(<?= $gen->modelClassName() ?>Repository $<?= $gen->modelVariableName() ?>Repository<?php foreach ($foreign_keys as $foreign) { ?>
<?php if (($class = $gen->getForeignKeyModelNamespace($foreign, $fields)) !== false) { ?>
, <?= class_basename($class = $gen->getModelRepositoryNamespace($class))." ".$gen->modelVariableNameFromClass($class) ?>
<?php } ?>
<?php } ?>)
    {
        $this-><?= $gen->modelVariableName() ?>Repository = $<?= $gen->modelVariableName() ?>Repository;
<?php foreach ($foreign_keys as $foreign) { ?>
<?php if (($class = $gen->getForeignKeyModelNamespace($foreign, $fields)) !== false) { ?>
        <?= str_replace('$', '$this->', $gen->modelVariableNameFromClass($class)).'Repository = '.$gen->modelVariableNameFromClass($class)."Repository;\n" ?>
<?php } ?>
<?php } ?>
    }

    /**
     * Obtiene datos de consulta predeterminada o lo que indique el usuario de
     * la entidad para la vista Index.
     *
     * @param  <?= config('modules.crud.config.parent-app-namespace') ?>\Http\Requests\<?= $gen->modelClassName()."Request" ?>  $request
     *
     * @return Illuminate\Pagination\LengthAwarePaginator
     */
    public function indexSearch(<?= $gen->modelClassName()."Request" ?> $request)
    {
        $search = collect($request->get('search'));
        return $this-><?= $gen->modelVariableName() ?>Repository
            ->getRequested($search, $this->getQueryColumns($search));
    }

    /**
     * Obtienen array de columnas a consultar en la base de datos para la tabla
     * del index.
     *
     * @param  Illuminate\Support\Collection $search
     *
     * @return array
     */
    private function getQueryColumns(Collection $search)
    {
        return array_merge(
            $search->get('table_columns', $this->defaultSelectedtableColumns),
            $this->forceQueryColumns
        );
    }

    /**
     * Obtiene los datos para la vista Index.
     *
     * @param  <?= config('modules.crud.config.parent-app-namespace') ?>\Http\Requests\<?= $gen->modelClassName()."Request" ?>  $request
     *
     * @return array
     */
    public function getIndexTableData(<?= $gen->modelClassName()."Request" ?> $request)
    {
        $search = collect($request->get('search'));

        $data = [];
        $data += $this->getCreateFormData();
        $data['selectedTableColumns'] = $search->get(
            'table_columns',
            $this->defaultSelectedtableColumns
        );
<?php if ($request->get('use_x_editable', false)) { ?>
<?php if ($gen->areEnumFields($fields)) { ?>

        // obtenemos datos Json para plugin x-editable
        $<?= $gen->modelVariableName() ?> = new <?= $gen->modelClassName() ?>;
<?php } ?>
<?php foreach ($foreign_keys as $foreign) { ?>
<?php if (($child_table = explode(".", $foreign->foreign_key)) && ($parent_table = explode(".", $foreign->references))) { ?>
        $data['<?= $child_table[1] ?>_list_json'] = collect($data['<?= $child_table[1] ?>_list'])
            ->map(function ($item, $key) {
                return [$key => $item];
            })->values()->toJson();
<?php } ?>
<?php } ?>
<?php foreach ($fields as $field) { ?>
<?php if ($field->type == 'enum') { ?>
        $data['<?= $field->name ?>_list_json'] = collect($data['<?= $field->name ?>_list'])
            ->map(function ($item, $key) {
                return [$key => trans('<?= $gen->modelVariableName() ?>.form-labels.<?= $field->name ?>.'.$item)];
            })->values()->toJson();
<?php } ?>
<?php } ?>
<?php } ?>

        return $data;
    }

    /**
     * Obtiene los datos para la vista de creación.
     *
     * @return array
     */
    public function getCreateFormData()
    {
        $data = [];
<?php foreach ($foreign_keys as $foreign) { ?>
<?php if (($child_table = explode(".", $foreign->foreign_key)) && ($parent_table = explode(".", $foreign->references))) { ?>
        $data['<?= $child_table[1] ?>_list'] = $this-><?= camel_case(str_singular($parent_table[0])) ?>Repository->getSelectList();
<?php } ?>
<?php } ?>
<?php foreach ($fields as $field) { ?>
<?php if ($field->type == 'enum') { ?>
        $data['<?= $field->name ?>_list'] = $this-><?= $gen->modelVariableName() ?>Repository->getEnumFieldSelectList('<?= $field->name ?>');
<?php } ?>
<?php } ?>
    
        return $data;
    }

    /**
     * Obtiene los datos para la vista de detalles.
     *
     * @param  int  $id
     *
     * @return array
     */
    public function getShowFormData(int $id)
    {
        $data = array();
        $<?= $gen->modelVariableName() ?> = $this-><?= $gen->modelVariableName() ?>Repository->find($id);
        $data['<?= $gen->modelVariableName() ?>'] = <?= '$'.$gen->modelVariableName() ?>;
<?php foreach ($foreign_keys as $foreign) { ?>
<?php if (($child_table = explode(".", $foreign->foreign_key)) && ($parent_table = explode(".", $foreign->references))) { ?>
        $data['<?= $child_table[1] ?>_list'] = $this-><?= camel_case(str_singular($parent_table[0])) ?>Repository->getSelectList(
            'id',
            'name',
            (array) $<?= $gen->modelVariableName() ?>-><?= $child_table[1]."\n" ?>
        );
<?php } ?>
<?php } ?>
<?php foreach ($fields as $field) { ?>
<?php if ($field->type == 'enum') { ?>
        $data['<?= $field->name ?>_list'] = $<?= $gen->modelVariableName() ?>->getEnumValuesArray('<?= $field->name ?>');
<?php } ?>
<?php } ?>
    
        return $data;
    }

    /**
     * Obtiene los datos para la vista de edición.
     *
     * @param  int  $id
     *
     * @return array
     */
    public function getEditFormData(int $id)
    {
        $data = array();
        $data['<?= $gen->modelVariableName() ?>'] = $this-><?= $gen->modelVariableName() ?>Repository->find($id);
        $data += $this->getCreateFormData();
        
        return $data;
    }

    /**
     * Guarda en base de datos nuevo registro de <?= $request->get('single_entity_name') ?>.
     *
     * @param  <?= config('modules.crud.config.parent-app-namespace') ?>\Http\Requests\<?= $gen->modelClassName()."Request" ?>  $request
     *
     * @return <?= config('modules.crud.config.parent-app-namespace') ?>\Models\<?= $gen->modelClassName()."\n" ?>
     */
    public function store(<?= $gen->modelClassName()."Request" ?> $request)
    {
        $<?= $gen->modelVariableName() ?> = $this-><?= $gen->modelVariableName() ?>Repository->create($request->all());
        session()->flash('success', trans('<?= $gen->getLangAccess() ?>.store_<?= $gen->snakeCaseSingular() ?>_success'));

        return $<?= $gen->modelVariableName() ?>;
    }

    /**
     * Realiza actualización de <?= $request->get('single_entity_name') ?>.
     *
     * @param  int  $id
     * @param  <?= config('modules.crud.config.parent-app-namespace') ?>\Http\Requests\<?= $gen->modelClassName()."Request" ?>  $request
     *
     * @return  <?= config('modules.crud.config.parent-app-namespace') ?>\Models\<?= $gen->modelClassName()."\n" ?>
     */
    public function update(int $id, <?= $gen->modelClassName()."Request" ?> $request)
    {
<?php if ($request->get('use_x_editable', false)) { ?>
        if ($request->isXmlHttpRequest()) {
            $data = [$request->name  => $request->value];
            $this-><?= $gen->modelVariableName() ?>Repository->update($data, $id);
            return $<?= $gen->modelVariableName() ?>;
        }

<?php } ?>
        $this-><?= $gen->modelVariableName() ?>Repository->update($request->all(), $id);
        session()->flash(
            'success',
            trans('<?= $gen->getLangAccess() ?>.update_<?= $gen->snakeCaseSingular() ?>_success')
        );

        return $<?= $gen->modelVariableName() ?>;
    }

    /**
     * Realiza acción de <?= strtolower($gen->getDestroyBtnTxt()) ?> registro de <?= $request->get('single_entity_name') ?>.
     *
     * @param  int  $id
     * @param  <?= config('modules.crud.config.parent-app-namespace') ?>\Http\Requests\<?= $gen->modelClassName()."Request" ?>  $request
     */
    public function destroy(int $id, <?= $gen->modelClassName()."Request" ?> $request)
    {
        $id = $request->has('id') ? $request->get('id') : $id;

        $this-><?= $gen->modelVariableName() ?>Repository->destroy($id);
        session()->flash(
            'success',
            trans_choice('<?= $gen->getLangAccess() ?>.destroy_<?= $gen->snakeCaseSingular() ?>_success', count($id))
        );
    }
<?php if ($gen->hasDeletedAtColumn($fields)) { ?>

    /**
     * Realiza restauración de <?= $request->get('single_entity_name') ?>.
     *
     * @param  int  $id
     * @param  <?= config('modules.crud.config.parent-app-namespace') ?>\Http\Requests\<?= $gen->modelClassName()."Request" ?>  $request
     */
    public function restore(int $id, <?= $gen->modelClassName()."Request" ?> $request)
    {
        $id = $request->has('id') ? $request->get('id') : $id;

        $this-><?= $gen->modelVariableName() ?>Repository->restore($id);
        session()->flash(
            'success',
            trans_choice('<?= $gen->getLangAccess() ?>.restore_<?= $gen->snakeCaseSingular() ?>_success', count($id))
        );
    }
<?php } ?>
}
