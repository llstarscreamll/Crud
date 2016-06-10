<?php

namespace llstarscreamll\CrudGenerator\Providers;

use llstarscreamll\CrudGenerator\Providers\BaseGenerator;

/**
*
*/
class ViewsGenerator extends BaseGenerator
{
    /**
     * El nombre de la tabla en la base de datos.
     *
     * @var string
     */
    public $table_name;

    /**
     * Los mensajes de alerta en la operación.
     *
     * @var array
     */
    public $msg_error = array();

    /**
     * Los mensajes de info en la operación.
     *
     * @var array
     */
    public $msg_success = array();

    /**
     * La iformación dada por el usuario.
     *
     * @var Object
     */
    public $request;

    /**
     *
     */
    public function __construct($request)
    {
        $this->table_name = $request->get('table_name');
        $this->request = $request;
    }

    /**
     * Genera los ficheros para las vistas.
     *
     * @return bool
     */
    public function generate()
    {
        // no se ha creado la carpeta de las vistas?
        if (! file_exists($this->viewsDir())) {
            // entonces la creo
            mkdir($this->viewsDir());
        }

        // no se ha creado la carpeta partials de las vistas?
        if (! file_exists($this->viewsDir().'/partials')) {
            // entonces la creo
            mkdir($this->viewsDir().'/partials');
        }

        // recorro el array de vistas que debo crear
        foreach (config('llstarscreamll.CrudGenerator.config.views') as $view) {
            // TODO:
            // - Crear vista separada para la tabla del index
            // - Pasar todos los strings de las vistas a variables leidas de el
            //   archivo de idioma del paquete

            $viewFile = $this->viewsDir()."/".$view.".blade.php";

            $content = view(
                $this->templatesDir().'.views.'.$view,
                [
                'gen' => $this,
                'fields' => $this->advanceFields($this->request),
                'request' => $this->request
                ]
            );

            if (file_put_contents($viewFile, $content) === false) {
                $this->msg_error[] = "Ocurrió un error generando la vista ".$view.".";
                return false;
            }

            $this->msg_success[] = "Vista ".$view." generada correctamente.";
        }

        return true;
    }

    /**
     * Devuelve un string para la construcción de elemento de formulario HTML.
     *
     * @param  stdClass $field
     * @param  string   $table_name
     * @return string
     */
    public function getSearchInputStr($field, $table_name = null)
    {
        // selects
        if ($field->type == 'enum') {
            $output = "{!! Form::select(
                '$field->name[]',
                \$".$field->name."_list,
                Request::input('$field->name'),
                ['class' => 'form-control input-sm selectpicker', 'title' => '---', 'data-selected-text-format' => 'count > 0', 'multiple', 'form' => 'searchForm'])
            !!}\n";
            return $output;
        }

        // recorro los campos que son llave foránea
        foreach ($this->getForeignKeys($table_name) as $key => $foreign) {
            $child_table = explode(".", $foreign->foreign_key);
            $parent_table = explode(".", $foreign->references);

            
            // si el campo actual es una llave foránea
            if (strpos($child_table[1], $field->name) !== false && $field->name != 'id') {
                $output = "{!! Form::select(
                    '$field->name[]',
                    \$".$field->name."_list,
                    Request::input('$field->name'),
                    ['class' => 'form-control input-sm selectpicker', 'title' => '---', 'data-selected-text-format' => 'count > 0', 'multiple', 'form' => 'searchForm'])
                !!}\n";
                return $output;
            }
        }

        // para checkbox
        if ($field->type == 'tinyint') {
            $output = '<div>'
                      .$this->getCheckBoxSwitchHtlm(
                            $field,
                            $name = $field->name.'_true',
                            $value = 'true',
                            $data_size = 'mini',
                            $data_text = ['Si', '-'],
                            $data_color = [],
                            $form = 'searchForm'
                        )
                      .$this->getCheckBoxSwitchHtlm(
                            $field,
                            $name = $field->name.'_false',
                            $value = 'true',
                            $data_size = 'mini',
                            $data_text = ['No', '-'],
                            $data_color = ['danger', 'default'],
                            $form = 'searchForm'
                        );
            $output .= $this->endFormGroup($field);
            return $output;
        }

        $type = 'text';

        // para inputs de tipo date
        if ($field->type == 'date') {
            $type = $field->type;
        }
        // para inputs de tipo date
        if ($field->type == 'timestamp') {
            $type = 'datetime-local';
        }

        // para inputs de tipo numérico
        if (in_array($field->type, config('llstarscreamll.CrudGenerator.config.numeric-input-types'))) {
            $type = 'number';
        }

        $output = '<input type="'.$type.'" class="form-control input-sm" name="'.$field->name.'" value="{{Request::input("'.$field->name.'")}}" form="searchForm">';
        return $output;
    }

    /**
     * Devuelve un string con el tipo de campo (data-type) para el componente x-editable.
     *
     * @param  Object $field
     * @return string
     */
    public function getInputType($field)
    {
        // textarea
        if (in_array($field->type, ['text'])) {
            return 'textarea';
        }

        // dates
        if ($field->type == 'date') {
            return "date";
        }

        // date-time
        if ($field->type == 'datetime') {
            return "datetime";
        }

        // numbers
        if (in_array($field->type, ['int', 'unsigned_int']) && $field->key != 'MUL') {
            return "number";
        }

        // numbers
        if (in_array($field->type, ['int', 'unsigned_int']) && $field->key == 'MUL') {
            return "select";
        }

        // emails
        if (preg_match("/email/", $field->name)) {
            return "email";
        }

        // enums
        if ($field->type == 'enum') {
            return 'select';
        }

        // default type
        return 'text';
    }

    /**
     * [getSourceForEnum description]
     *
     * @param  [type] $field [description]
     * @return string
     */
    public function getSourceForEnum($field)
    {
        if ($field->type == 'enum' || (in_array($field->type, ['int', 'unsigned_int']) && $field->key == 'MUL')) {
            return "data-source='{!! $".$field->name."_list_json !!}'";
        }
        return "";
    }

    /**
     * Devuelve string del código de los elementos de formulario.
     *
     * @param  StdClass $field
     * @param  string   $modelName
     * @return string|bool
     */
    public function getFormInputMarkup($field, $table_name, $checkSkippedFields = false)
    {
        // $field es un campo de los que debo omitir?
        if (($field->on_create_form === false && $field->on_update_form === false) && $checkSkippedFields === false) {
            return false;
        }

        // ****************************************************************************
        // abro el contenedor
        $output = "\n<div class='form-group col-sm-6 {{\$errors->has('{$field->name}') ? 'has-error' : ''}}'>\n";
        // el label
        $output .= "{!! Form::label('{$field->name}', trans('".$this->getLangAccess()."/views.form-fields.".$field->name."')) !!}\n";
        // ****************************************************************************

        // para selects
        if ($field->type == 'enum') {
            $output .= "{!! Form::select('{$field->name}', \${$field->name}_list, null, ['class' => 'form-control', isset(\$show) ? 'disabled' : '']) !!}\n";
            $output .= $this->endFormGroup($field);
            return $output;
        }

        // para checkbox
        if ($field->type == 'tinyint') {
            $output .= "{!! Form::hidden('{$field->name}', false) !!}\n<br>".$this->getCheckBoxSwitchHtlm($field);
            $output .= $this->endFormGroup($field);
            return $output;
        }

        // recorro las llaves foraneas
        foreach ($this->getForeignKeys($table_name) as $key => $foreign) {
            $child_table = explode(".", $foreign->foreign_key);
            $parent_table = explode(".", $foreign->references);

            // si el campo actual es una llave foránea
            if (strpos($child_table[1], $field->name) !== false) {
                $output .= "{!! Form::select('{$field->name}', \${$field->name}_list, null, ['class' => 'form-control', isset(\$show) ? 'disabled' : '']) !!}\n";
                $output .= $this->endFormGroup($field);
                return $output;
            }
        }

        // para textarea
        if ($field->type == 'text') {
            $output .= "{!! Form::textarea('{$field->name}', null, ['class' => 'form-control', isset(\$show) ? 'disabled' : '']) !!}\n";
            $output .= $this->endFormGroup($field);
            return $output;
        }

        $type = 'text';

        // para inputs de tipo date
        if ($field->type == 'date') {
            $type = $field->type;
        }

        // para inputs de tipo numérico
        if ($field->type == 'int' || $field->type == 'unsigned_int' || $field->type == 'float' || $field->type == 'double') {
            $type = 'number';
        }

        // el campo
        $output .= "{!! Form::input('{$type}', '{$field->name}', null, ['class' => 'form-control', isset(\$show) ? 'disabled' : '']) !!}\n";
        $output .= $this->endFormGroup($field);
        
        return $output;
    }

    /**
     * Genera código HTML para un elemento de formulario que requiere confirmación
     * @param  stdClas $field
     * @return string      
     */
    public function getFormInputConfirmationMarkup($field)
    {
        // core condición para que no sea mostrado en formulario de sólo lectura
        $output = "\n@if(!isset(\$show))\n";
        // abro el contenedor
        $output .= "<div class='form-group col-sm-6 {{\$errors->has('{$field->name}') ? 'has-error' : ''}}'>\n";
        // el label
        $output .= "{!! Form::label('{$field->name}_confirmation', trans('".$this->getLangAccess()."/views.form-fields.".$field->name."_confirmation')) !!}\n";
        
        $output .= "{!! Form::input('text', '{$field->name}_confirmation', null, ['class' => 'form-control']) !!}\n";
        $output .= $this->endFormGroup($field);
        $output .= "@endif\n";

        return $output;
    }

    /**
     * Devuelve string html de un checkbox con las propiedades para el componente SwitchBootstrap,
     * así:
     * {!! Form::checkbox('use_faker', true, null, [
     *      'class' => 'bootstrap_switch',
     *      data-size' => 'medium',
     *      'data-on-text' => 'SI',
     *      'data-off-text' => 'NO',
     *      isset(\$show) ? 'disabled' : ''
     *  ]) !!}
     *
     * @param  stdClass $field
     * @param  string   $name      El nombre del elemento
     * @param  string   $value     El valor del atributo value
     * @param  string   $data_size El atributo data-size para SwitchBootstrap
     * @param  array    $data_text Los valores en el estado on y off
     * @param  string   $form      El nombre del formulario al que pertenece el elemento
     * @return string
     */
    public function getCheckBoxSwitchHtlm($field, $name = null, $value = 'true', $data_size = 'medium', $data_text = [], $data_color = [], $form = null)
    {
        // el formulario al que pertenece el elemento
        if ($form) {
            $form = "'form' => '$form'";
        }

        // el nombre del checkbox
        if (! $name) {
            $name = $field->name;
        }

        // los valores en el estado on y off
        $data_on_text = 'Si';
        $data_off_text = 'No';

        if (count($data_text) > 1) {
            $data_on_text = $data_text[0];
            $data_off_text = $data_text[1];
        }

        // las opciones de color en estado on y off
        $data_on_color = 'primary';
        $data_off_color = 'default';

        if (count($data_color) > 1) {
            $data_on_color = $data_color[0];
            $data_off_color = $data_color[1];
        }

        return "{!! Form::checkbox('{$name}', $value, Request::input('$name'),
                    [
                    'class' => 'bootstrap_switch',
                    'data-size' => '$data_size',
                    'data-on-text' => '$data_on_text',
                    'data-off-text' => '$data_off_text',
                    'data-on-color' => '$data_on_color',
                    'data-off-color' => '$data_off_color',
                    isset(\$show) ? 'disabled' : '',
                    $form
                    ]
                ) !!}\n\t\t\t\t";
    }

    /**
     * Cierra el los tags iniciados en getFormInputMarkup($field, $table_name).
     *
     * @param  [type] $field [description]
     * @return string
     */
    public function endFormGroup($field)
    {
        // los mensajes de error
        $output = "{!!\$errors->first('{$field->name}', '<span class=\"text-danger\">:message</span>')!!}\n";
        // cierro el contenedor
        $output .= "</div>\n";

        return $output;
    }

    /**
     * Devuelve string de la clase CSS a asociar a un input para uso del componete
     * x-editable, de momento las posibles clases son .editable, .editable-date y
     * .editable-datetime; son devueltos según el tipo de campo que tenga $field;
     * @param  stdClass $field
     * @return string
     */
    public function getInputXEditableClass($field)
    {
        // el valor por defecto
        $class = 'editable';

        if ($field->type == 'datetime') {
            $class = 'editable-datetime';
        }

        if ($field->type == 'date') {
            $class = 'editable-date';
        }

        return $class;
    }

    /**
     * Obtiene el nombre del atributo a mostrar de un modelo, si la columna no
     * tiene relación con otra tabla, devolverá sólo el nombre de la columna,
     * si tiene dicha relación devolverá el dato de la relación, esto para no
     * mostrar números que hacen referencia a registros de otra tabla, mejor
     * mostrar algo que el usuario pueda leer y entender claramente, ejemplo:
     * relation_id = ralation->name
     * deleted_by = deletedBy->name
     * @param  stdClass $field
     * @param  string $modelName
     * @return string
     */
    public function getRecordFieldData($field, $modelName)
    {
        $attr = "{$modelName}->{$field->name}";

        if ($field->relation) {
            $relation = $this->getFunctionNameRelationFromField($field);
            $attr = "{$modelName}->{$relation} ? {$modelName}->{$relation}"."->name : ''";
        }

        return $attr;
    }

    /**
     * Devuelve array de los campos presentes en el formulario de creación.
     * @return array
     */
    public function getCreateFormFields()
    {
        $fields = $this->advanceFields($this->request);
        $createFormFields = [];

        foreach ($fields as $key => $field) {
            if ($field->on_create_form) {
                $createFormFields[] = $field->name;
            }
        }

        return $createFormFields;
    }
}
