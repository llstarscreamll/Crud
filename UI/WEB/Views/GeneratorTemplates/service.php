<?php
/* @var $crud App\Containers\Crud\Providers\TestsGenerator */
/* @var $fields [] */
/* @var $request Request */
/* @var $foreign_keys [] */
?>
<?= '<?php'?>


<?=  $crud->getClassCopyRightDocBlock() ?>


namespace <?= config('modules.crud.config.parent-app-namespace') ?>\Services;

use <?= config('modules.crud.config.parent-app-namespace') ?>\Http\Requests\<?= $crud->modelClassName()."Request" ?>;
use <?= config('modules.crud.config.parent-app-namespace') ?>\Repositories\Contracts\<?= $crud->modelClassName() ?>Repository;
use <?= config('modules.crud.config.parent-app-namespace') ?>\Models\<?= $crud->modelClassName() ?>;
<?php $crud->namespacesAdded = []; ?>
<?php foreach ($foreign_keys as $foreign) { ?>
<?php if (($class = $crud->getForeignKeyModelNamespace($foreign, $fields)) !== false) { ?>
use <?= $crud->getModelRepositoryNamespace($class) ?>;
<?php } ?>
<?php } ?>
use Illuminate\Support\Collection;

/**
 * Clase <?= $crud->modelClassName()."Service\n" ?>
 *
 * @author <?= config('modules.crud.config.author') ?> <<?= config('modules.crud.config.author_email') ?>>
 */
class <?= $crud->modelClassName() ?>Service
{
    /**
     * @var <?= config('modules.crud.config.parent-app-namespace') ?>\Repositories\Contracts\<?= $crud->modelClassName() ?>Repository
     */
    private $<?= $crud->modelVariableName() ?>Repository;
<?php $crud->namespacesAdded = []; ?>
<?php foreach ($foreign_keys as $foreign) { ?>
<?php if (($class = $crud->getForeignKeyModelNamespace($foreign, $fields)) !== false) { ?>
    
    /**
     * @var <?= $crud->getModelRepositoryNamespace($class)."\n" ?>
     */
    private <?= $crud->modelVariableNameFromClass($class)."Repository;\n" ?>
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
<?php if ($crud->hasDeletedAtColumn($fields)) { ?>
        'deleted_at'
<?php } ?>
    ];

    /**
     * Crea nueva instancia del servicio.
     *
     * @param <?= config('modules.crud.config.parent-app-namespace') ?>\Repositories\Contracts\<?= $crud->modelClassName() ?>Repository $<?= $crud->modelVariableName() ?>Repository
<?php $crud->namespacesAdded = []; ?>
<?php foreach ($foreign_keys as $foreign) { ?>
<?php if (($class = $crud->getForeignKeyModelNamespace($foreign, $fields)) !== false) { ?>
     * @param <?= ($class = $crud->getModelRepositoryNamespace($class))." ".$crud->modelVariableNameFromClass($class)."\n" ?>
<?php } ?>
<?php } ?>
     */
    public function __construct(<?= $crud->modelClassName() ?>Repository $<?= $crud->modelVariableName() ?>Repository<?php $crud->namespacesAdded = []; ?><?php foreach ($foreign_keys as $foreign) { ?>
<?php if (($class = $crud->getForeignKeyModelNamespace($foreign, $fields)) !== false) { ?>
, <?= class_basename($class = $crud->getModelRepositoryNamespace($class))." ".$crud->modelVariableNameFromClass($class) ?>
<?php } ?>
<?php } ?>)
    {
        $this-><?= $crud->modelVariableName() ?>Repository = $<?= $crud->modelVariableName() ?>Repository;
<?php $crud->namespacesAdded = []; ?>
<?php foreach ($foreign_keys as $foreign) { ?>
<?php if (($class = $crud->getForeignKeyModelNamespace($foreign, $fields)) !== false) { ?>
        <?= str_replace('$', '$this->', $crud->modelVariableNameFromClass($class)).'Repository = '.$crud->modelVariableNameFromClass($class)."Repository;\n" ?>
<?php } ?>
<?php } ?>
    }

    /**
     * Obtiene datos de consulta predeterminada o lo que indique el usuario de
     * la entidad para la vista Index.
     *
     * @param  <?= config('modules.crud.config.parent-app-namespace') ?>\Http\Requests\<?= $crud->modelClassName()."Request" ?>  $request
     *
     * @return Illuminate\Pagination\LengthAwarePaginator
     */
    public function indexSearch(<?= $crud->modelClassName()."Request" ?> $request)
    {
        $search = collect($request->get('search'));
        return $this-><?= $crud->modelVariableName() ?>Repository
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
     * @param  <?= config('modules.crud.config.parent-app-namespace') ?>\Http\Requests\<?= $crud->modelClassName()."Request" ?>  $request
     *
     * @return array
     */
    public function getIndexTableData(<?= $crud->modelClassName()."Request" ?> $request)
    {
        $search = collect($request->get('search'));

        $data = [];
        $data += $this->getCreateFormData();
        $data['selectedTableColumns'] = $search->get(
            'table_columns',
            $this->defaultSelectedtableColumns
        );
<?php if ($request->get('use_x_editable', false)) { ?>
<?php if ($crud->areEnumFields($fields)) { ?>

        // obtenemos datos Json para plugin x-editable
        $<?= $crud->modelVariableName() ?> = new <?= $crud->modelClassName() ?>;
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
                return [$key => trans('<?= $crud->modelVariableName() ?>.form-labels.<?= $field->name ?>.'.$item)];
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
        $data['<?= $field->name ?>_list'] = $this-><?= $crud->modelVariableName() ?>Repository->getEnumFieldSelectList('<?= $field->name ?>');
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
        $<?= $crud->modelVariableName() ?> = $this-><?= $crud->modelVariableName() ?>Repository->find($id);
        $data['<?= $crud->modelVariableName() ?>'] = <?= '$'.$crud->modelVariableName() ?>;
<?php foreach ($foreign_keys as $foreign) { ?>
<?php if (($child_table = explode(".", $foreign->foreign_key)) && ($parent_table = explode(".", $foreign->references))) { ?>
        $data['<?= $child_table[1] ?>_list'] = $this-><?= camel_case(str_singular($parent_table[0])) ?>Repository->getSelectList(
            'id',
            'name',
            (array) $<?= $crud->modelVariableName() ?>-><?= $child_table[1]."\n" ?>
        );
<?php } ?>
<?php } ?>
<?php foreach ($fields as $field) { ?>
<?php if ($field->type == 'enum') { ?>
        $data['<?= $field->name ?>_list'] = $<?= $crud->modelVariableName() ?>->getEnumValuesArray('<?= $field->name ?>');
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
        $data['<?= $crud->modelVariableName() ?>'] = $this-><?= $crud->modelVariableName() ?>Repository->find($id);
        $data += $this->getCreateFormData();
        
        return $data;
    }

    /**
     * Guarda en base de datos nuevo registro de <?= $request->get('single_entity_name') ?>.
     *
     * @param  <?= config('modules.crud.config.parent-app-namespace') ?>\Http\Requests\<?= $crud->modelClassName()."Request" ?>  $request
     *
     * @return <?= config('modules.crud.config.parent-app-namespace') ?>\Models\<?= $crud->modelClassName()."\n" ?>
     */
    public function store(<?= $crud->modelClassName()."Request" ?> $request)
    {
        $input = null_empty_fields($request->all());
        $<?= $crud->modelVariableName() ?> = $this-><?= $crud->modelVariableName() ?>Repository->create($input);
        session()->flash('success', trans('<?= $crud->getLangAccess() ?>.store_<?= $crud->snakeCaseSingular() ?>_success'));

        return $<?= $crud->modelVariableName() ?>;
    }

    /**
     * Realiza actualización de <?= $request->get('single_entity_name') ?>.
     *
     * @param  int  $id
     * @param  <?= config('modules.crud.config.parent-app-namespace') ?>\Http\Requests\<?= $crud->modelClassName()."Request" ?>  $request
     *
     * @return  <?= config('modules.crud.config.parent-app-namespace') ?>\Models\<?= $crud->modelClassName()."\n" ?>
     */
    public function update(int $id, <?= $crud->modelClassName()."Request" ?> $request)
    {
<?php if ($request->get('use_x_editable', false)) { ?>
        if ($request->isXmlHttpRequest()) {
            $data = [$request->name  => $request->value];
            $<?= $crud->modelVariableName() ?> = $this-><?= $crud->modelVariableName() ?>Repository->update($data, $id);
            return $<?= $crud->modelVariableName() ?>;
        }

<?php } ?>
        $input = null_empty_fields($request->all());
        $<?= $crud->modelVariableName() ?> = $this-><?= $crud->modelVariableName() ?>Repository->update($input, $id);
        session()->flash(
            'success',
            trans('<?= $crud->getLangAccess() ?>.update_<?= $crud->snakeCaseSingular() ?>_success')
        );

        return $<?= $crud->modelVariableName() ?>;
    }

    /**
     * Realiza acción de <?= strtolower($crud->getDestroyBtnTxt()) ?> registro de <?= $request->get('single_entity_name') ?>.
     *
     * @param  int  $id
     * @param  <?= config('modules.crud.config.parent-app-namespace') ?>\Http\Requests\<?= $crud->modelClassName()."Request" ?>  $request
     */
    public function destroy(int $id, <?= $crud->modelClassName()."Request" ?> $request)
    {
        $id = $request->has('id') ? $request->get('id') : $id;

        $this-><?= $crud->modelVariableName() ?>Repository->destroy($id);
        session()->flash(
            'success',
            trans_choice('<?= $crud->getLangAccess() ?>.destroy_<?= $crud->snakeCaseSingular() ?>_success', count($id))
        );
    }
<?php if ($crud->hasDeletedAtColumn($fields)) { ?>

    /**
     * Realiza restauración de <?= $request->get('single_entity_name') ?>.
     *
     * @param  int  $id
     * @param  <?= config('modules.crud.config.parent-app-namespace') ?>\Http\Requests\<?= $crud->modelClassName()."Request" ?>  $request
     */
    public function restore(int $id, <?= $crud->modelClassName()."Request" ?> $request)
    {
        $id = $request->has('id') ? $request->get('id') : $id;

        $this-><?= $crud->modelVariableName() ?>Repository->restore($id);
        session()->flash(
            'success',
            trans_choice('<?= $crud->getLangAccess() ?>.restore_<?= $crud->snakeCaseSingular() ?>_success', count($id))
        );
    }
<?php } ?>
}
