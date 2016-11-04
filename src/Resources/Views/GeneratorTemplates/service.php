<?php
/* @var $gen llstarscreamll\CrudGenerator\Providers\TestsGenerator */
/* @var $fields [] */
/* @var $request Request */
/* @var $foreign_keys [] */
?>
<?= '<?php'?>


<?=  $gen->getClassCopyRightDocBlock() ?>


namespace <?= config('modules.CrudGenerator.config.parent-app-namespace') ?>\Services;

use <?= config('modules.CrudGenerator.config.parent-app-namespace') ?>\Models\<?= $gen->modelClassName() ?>;
<?php foreach ($foreign_keys as $foreign) { ?>
<?php if (($class = $gen->getForeignKeyModelNamespace($foreign, $fields)) !== false) { ?>
use <?= $class ?>;
<?php } ?>
<?php } ?>

/**
 * Clase <?= $gen->modelClassName()."Service\n" ?>
 *
 * @author <?= config('modules.CrudGenerator.config.author') ?> <<?= config('modules.CrudGenerator.config.author_email') ?>>
 */
class <?= $gen->modelClassName() ?>Service
{
    /**
     * Las columnas a mostrar en la tabla del Index.
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
     * Obtiene datos de consulta predeterminada o lo que indique el usuario de
     * la entidad para la vista Index.
     *
     * @param  <?= config('modules.CrudGenerator.config.parent-app-namespace') ?>\Http\Requests\<?= $gen->modelClassName()."Request" ?>  $request
     *
     * @return Illuminate\Pagination\LengthAwarePaginator
     */
    public function indexSearch($request)
    {
        return <?= $gen->modelClassName() ?>::findRequested($request)
            ->select($this->getQueryColumns($request))
            ->paginate(15);
    }

    /**
     * Obtienen array de columnas a consultar en la base de datos para la tabla
     * del index.
     *
     * @param  Illuminate\Support\Collection $request
     *
     * @return array
     */
    private function getQueryColumns($request)
    {
        return array_merge(
            $request->get('table_columns', $this->defaultSelectedtableColumns),
            $this->forceQueryColumns
        );
    }

    /**
     * Obtiene los datos para la vista Index.
     *
     * @return array
     */
    public function getIndexViewData($request)
    {
        $data = [];
<?php if ($gen->areEnumFields($fields)) { ?>
        $<?= $gen->modelVariableName() ?> = new <?= $gen->modelClassName() ?>;
<?php } ?>
        $data += $this->getCreateFormData();
<?php if ($request->get('use_x_editable', false)) { ?>
        
        // obtenemos datos Json para plugin x-editable
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
                return [$key => $item];
            })->values()->toJson();
<?php } ?>
<?php } ?>
<?php } ?>
        $data['selectedTableColumns'] = $request->get(
            'table_columns',
            $this->defaultSelectedtableColumns
        );

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
<?php if ($gen->areEnumFields($fields)) { ?>
        $<?= $gen->modelVariableName() ?> = new <?= $gen->modelClassName() ?>;
<?php } ?>
<?php foreach ($foreign_keys as $foreign) { ?>
<?php if (($child_table = explode(".", $foreign->foreign_key)) && ($parent_table = explode(".", $foreign->references))) { ?>
        $data['<?= $child_table[1] ?>_list'] = <?= studly_case(str_singular($parent_table[0])) ?>::pluck('name', 'id')->all();
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
     * Obtiene los datos para la vista de detalles.
     *
     * @param  int  $id
     *
     * @return array
     */
    public function getShowViewData(int $id)
    {
        $data = array();
        $<?= $gen->modelVariableName() ?> = <?= $gen->modelClassName().'::findOrFail($id)' ?>;
        $data['<?= $gen->modelVariableName() ?>'] = <?= '$'.$gen->modelVariableName() ?>;
<?php foreach ($foreign_keys as $foreign) { ?>
<?php if (($child_table = explode(".", $foreign->foreign_key)) && ($parent_table = explode(".", $foreign->references))) { ?>
        $data['<?= $child_table[1] ?>_list'] = <?= studly_case(str_singular($parent_table[0])) ?>::where('id', $<?= $gen->modelVariableName() ?>-><?= $child_table[1] ?>)
            ->pluck('name', 'id')->all();
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
        $data['<?= $gen->modelVariableName() ?>'] = <?= $gen->modelClassName().'::findOrFail($id)' ?>;
        $data += $this->getCreateFormData();
        
        return $data;
    }

    /**
     * Guarda en base de datos nuevo registro de <?= $request->get('single_entity_name') ?>.
     *
     * @param  <?= config('modules.CrudGenerator.config.parent-app-namespace') ?>\Http\Requests\<?= $gen->modelClassName()."Request" ?>  $request
     *
     * @return <?= config('modules.CrudGenerator.config.parent-app-namespace') ?>\Models\<?= $gen->modelClassName()."\n" ?>
     */
    public function store($request)
    {
        $<?= $gen->modelVariableName() ?> = <?= $gen->modelClassName() ?>::create($request->all());
        session()->flash('success', trans('<?= $gen->getLangAccess() ?>.store_<?= $gen->snakeCaseSingular() ?>_success'));

        return $<?= $gen->modelVariableName() ?>;
    }

    /**
     * Realiza actualización de <?= $request->get('single_entity_name') ?>.
     *
     * @param  int  $id
     * @param  <?= config('modules.CrudGenerator.config.parent-app-namespace') ?>\Http\Requests\<?= $gen->modelClassName()."Request" ?>  $request
     *
     * @return  <?= config('modules.CrudGenerator.config.parent-app-namespace') ?>\Models\<?= $gen->modelClassName()."\n" ?>
     */
    public function update(int $id, $request)
    {
        $<?= $gen->modelVariableName() ?> = <?= $gen->modelClassName() ?>::findOrFail($id);

<?php if ($request->get('use_x_editable', false)) { ?>
        if ($request->isXmlHttpRequest()) {
            $data = [$request->name  => $request->value];
            $<?= $gen->modelVariableName() ?>->update($data);
            return $book;
        }

<?php } ?>
        $<?= $gen->modelVariableName() ?>->update($request->all());
        session()->flash(
            'success',
            trans('<?= $gen->getLangAccess() ?>.update_<?= $gen->snakeCaseSingular() ?>_success')
        );

        return $<?= $gen->modelVariableName() ?>;
    }

    /**
     * Realiza acción de <?= strtolower($gen->getDestroyBtnTxt()) ?> registro de <?= $request->get('single_entity_name') ?>.
     *
     * @param  array|int  $id
     * @param  <?= config('modules.CrudGenerator.config.parent-app-namespace') ?>\Http\Requests\<?= $gen->modelClassName()."Request" ?>  $request
     */
    public function destroy($id, $request)
    {
        $id = $request->has('id') ? $request->get('id') : $id;

        <?= $gen->modelClassName() ?>::destroy($id);
        session()->flash(
            'success',
            trans_choice('<?= $gen->getLangAccess() ?>.destroy_<?= $gen->snakeCaseSingular() ?>_success', count($id))
        );
    }
<?php if ($gen->hasDeletedAtColumn($fields)) { ?>

    /**
     * Realiza restauración de <?= $request->get('single_entity_name') ?>.
     *
     * @param  array|int  $id
     * @param  <?= config('modules.CrudGenerator.config.parent-app-namespace') ?>\Http\Requests\<?= $gen->modelClassName()."Request" ?>  $request
     */
    public function restore($id, $request)
    {
        $id = $request->has('id') ? $request->get('id') : $id;

        <?= $gen->modelClassName() ?>::onlyTrashed()->whereIn('id', $id)->restore();
        session()->flash(
            'success',
            trans_choice('<?= $gen->getLangAccess() ?>.restore_<?= $gen->snakeCaseSingular() ?>_success', count($id))
        );
    }
<?php } ?>
}
