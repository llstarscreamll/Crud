<?php
/* @var $crud App\Containers\Crud\Providers\TestsGenerator */
/* @var $fields [] */
/* @var $test [] */
/* @var $request Request */
?>
<?='<?php'?>


<?= $crud->getClassCopyRightDocBlock() ?>


namespace Page\Functional\<?= $crud->studlyCasePlural() ?>;

use FunctionalTester;
<?php foreach ($fields as $field) { ?>
<?php if ($field->namespace !== "" && class_basename($field->namespace) !== 'User') { ?>
use {!! $field->namespace !!};
<?php } ?>
<?php } ?>

class <?= $test ?> extends Index
{
    /**
     * El link de acceso a la edición del registro.
     *
     * @var array
     */
    public static $linkToEdit = 'Editar';
    public static $linkToEditElem = '<?= config('modules.crud.uimap.edit-link-access-selector') ?>';
    
    /**
     * El título de la página.
     *
     * @var string
     */
    public static $title = 'Editar';

    /**
     * El selector del formulario de edición.
     *
     * @var string
     */
    public static $form = 'form[name=edit-<?= $crud->getDashedModelName() ?>-form]';

    /**
     * Mensaje de éxito al actualizar un registro.
     *
     * @var array
     */
    public static $msgSuccess = '<?=  $crud->getUpdateSuccessMsg()  ?>';
    public static $msgSuccessElem = '<?=  config('modules.crud.uimap.alert-success-selector')  ?>';

    public function __construct(FunctionalTester $I)
    {
        parent::__construct($I);
    }

    /**
     * Devuelve array con los datos que deben estar presentes en el formulario
     * de edición antes de la operación de actualización.
     *
     * @return array
     */
    public static function getUpdateFormData()
    {
        $data = array();

        foreach (static::$<?= $crud->modelVariableName() ?>Data as $key => $value) {
            if (in_array($key, static::$editFormFields)) {
                $data[$key] = $value;
            }
            if (in_array($key, static::$fieldsThatRequieresConfirmation)){
                $data[$key.'_confirmation'] = '';
            }
        }

        return $data;
    }

    /**
     * Devuelve array con datos para actualización de registro en formulario de
     * edición.
     *
     * @return array
     */
    public static function getDataToUpdateForm()
    {
        $data = array();

        $data = [
<?php foreach ($fields as $field) { ?>
<?php if ($field->on_update_form) { ?>
<?php if ($field->type == 'tinyint') { ?>
<?php if ($field->testData == 'false' || $field->testData == '0') { ?>
            '<?= $field->name ?>' => '0',
<?php } elseif ($field->testData == 'true' || $field->testData == '1') { ?>
            '<?= $field->name ?>' => true,
<?php } ?>
<?php } else { ?>
            '<?= $field->name ?>' => {!! $field->namespace == '' ? $field->testDataUpdate : class_basename($field->namespace)."::all(['id'])->last()->id" !!},
<?php } ?>
<?php } ?>
<?php if (strpos($field->validation_rules, 'confirmed')) { ?>
            '<?= $field->name ?>_confirmation' => {!!$field->testDataUpdate!!},
<?php } ?>
<?php } ?>
        ];

        return $data;
    }

    /**
     * Obtiene array de datos del registro actualizado para comprobarlos en la
     * vista de sólo lectura (show).
     *
     * @return  array
     */
    public static function getUpdatedDataToShowForm()
    {
        $data = static::getDataToUpdateForm();

        // los campos ocultos no deben ser mostrados en la vista de sólo lectura
        foreach (static::$hiddenFields as $key => $value) {
            unset($data[$value]);
            if (in_array($key, static::$fieldsThatRequieresConfirmation)) {
                unset($data[$value.'_confirmation']);
            }
        }

        return $data;
    }
}