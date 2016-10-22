<?php
/* @var $gen llstarscreamll\CrudGenerator\Providers\TestsGenerator */
/* @var $fields [] */
/* @var $test [] */
/* @var $request Request */
?>
<?='<?php'?>


<?= $gen->getClassCopyRightDocBlock() ?>


namespace Page\Functional\{{$gen->studlyCasePlural()}};

use FunctionalTester;
@foreach($fields as $field)
@if($field->namespace !== "" && class_basename($field->namespace) !== 'User')
use {!! $field->namespace !!};
@endif
@endforeach

class {{$test}} extends Index
{
    /**
     * El link de acceso a la edición del registro.
     *
     * @var array
     */
    static $linkToEdit = 'Editar';
    static $linkToEditElem = '{{config('modules.CrudGenerator.uimap.edit-link-access-selector')}}';
    
    /**
     * El título de la página.
     *
     * @var string
     */
    static $title = 'Actualizar';

    /**
     * El selector del formulario de edición.
     *
     * @var string
     */
    static $form = 'form[name=edit-{{$gen->getDashedModelName()}}-form]';

    /**
     * Mensaje de éxito al actualizar un registro.
     *
     * @var array
     */
    static $msgSuccess = '{{ $gen->getUpdateSuccessMsg() }}';
    static $msgSuccessElem = '{{ config('modules.CrudGenerator.uimap.alert-success-selector') }}';

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

        foreach (static::${{$gen->modelVariableName()}}Data as $key => $value) {
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
@foreach($fields as $field)
@if($field->on_update_form)
            '{{$field->name}}' => {!! $field->namespace == '' ? $field->testDataUpdate : class_basename($field->namespace)."::all(['id'])->last()->id" !!},
@endif
@if(strpos($field->validation_rules, 'confirmed'))
            '{{$field->name}}_confirmation' => {!!$field->testDataUpdate!!},
@endif
@endforeach
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