<?php

namespace llstarscreamll\Crud\Providers;

use stdClass;

class ViewsGenerator extends BaseGenerator
{
    /**
     * El nombre de la tabla en la base de datos.
     *
     * @var string
     */
    public $table_name;

    /**
     * La iformación dada por el usuario.
     *
     * @var object
     */
    public $request;

    /**
     * Crea nueva instancia de ViewsGenerator.
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
        if (!file_exists($this->viewsDir())) {
            // entonces la creo
            mkdir($this->viewsDir(), 0755, true);
        }

        // no se ha creado la carpeta partials de las vistas?
        if (!file_exists($this->viewsDir().'/partials')) {
            // entonces la creo
            mkdir($this->viewsDir().'/partials', 0755, true);
        }

        // recorro el array de vistas que debo crear
        foreach (config('modules.crud.config.views') as $view) {
            $viewFile = $this->viewsDir().'/'.$view.'.blade.php';

            $content = view(
                $this->templatesDir().'.views.'.$this->request->get('UI_theme').'.'.$view,
                [
                'gen' => $this,
                'fields' => $this->advanceFields($this->request),
                'request' => $this->request,
                ]
            );

            if (file_put_contents($viewFile, $content) === false) {
                session()->push('error', 'Ocurrió un error generando la vista '.$view.'.');
            }
        }

        session()->push('success', 'Vistas generadas correctamente');

        return true;
    }

    /**
     * Construye el setup de clase helper UI para construir los campos del
     * formulario de búsqueda.
     *
     * @param stdClass $field
     *
     * @return string
     */
    public function getSearchUISetup(stdClass $field)
    {
        $type = empty($field->key) ? "'$field->type'" : "'$field->key'";
        $name = ", '$field->name'";
        $value = null;
        $data = null;
        $attr = null;

        if ($field->key == 'MUL' || $field->type == 'enum') {
            $value = ", ''";
            $data = ", \${$field->name}_list";
        }

        $output = '{!! UI::searchField(';
        $output .= "{$type}"; // tipo de dato del campo
        $output .= "{$name}"; // nombre del campo
        $output .= "{$value}"; // valor predeterminado del campo
        $output .= "{$data}"; // datos del campo, por ejemplo para selects
        $output .= "{$attr}"; // atributos para el campo
        $output .= ") !!}\n";

        return $output;
    }

    /**
     * Devuelve un string para la construcción de elemento de formulario HTML.
     *
     * @param stdClass $field
     * @param string   $table_name
     *
     * @return string
     */
    public function getSearchInputStr(stdClass $field, string $table_name = null)
    {
        // selects
        if ($field->type == 'enum') {
            return $this->buildSelectPicker($field, true, false, true);
        }

        // recorro los campos que son llave foránea
        foreach ($this->getForeignKeys($table_name) as $key => $foreign) {
            $child_table = explode('.', $foreign->foreign_key);
            $parent_table = explode('.', $foreign->references);

            // si el campo actual es una llave foránea
            if (strpos($child_table[1], $field->name) !== false && $field->name != 'id') {
                return $this->buildSelectPicker($field, true, false, true);
            }
        }

        // para checkbox
        if ($field->type == 'tinyint') {
            // genero el checkbox con base al componente elegido por el usuario
            if ($this->request->get('checkbox_component_on_index_table') == 'BootstrapSwitch') {
                $output = $this->generateSearchCheckBoxesBootstrapSwitch($field);
            } elseif ($this->request->get('checkbox_component_on_index_table') == 'iCheck') {
                $output = $this->generateSearchCheckBoxesiCheck($field);
            }

            $output .= "\n";

            return $output;
        }

        $type = 'text';

        // para inputs de tipo date
        if ($field->type == 'date' || $field->type == 'timestamp' || $field->type == 'datetime') {
            return $this->generateDatesSearchFields($field);
        }

        // para inputs de tipo numérico
        if (in_array($field->type, config('modules.crud.config.numeric-input-types'))) {
            $type = 'number';
        }

        $fieldName = $field->name == 'id' ? 'ids[]' : $field->name;

        if ($field->name == 'id') {
            $output = "
                {!! Form::select(
                    '$fieldName',
                    (\$ids_list = Request::get('ids', null)) ? array_combine(\$ids_list, \$ids_list) : [],
                    Request::get('ids') ? Request::get('ids') : null,
                    [
                        'data-placeholder' => '',
                        'class' => 'form-control select2-ids',
                        'style' => 'width: 100px;',
                        'form' => 'searchForm',
                        'multiple',
                    ])
                !!}\n";
        } else {
            $output = "{!! Form::input('$type', '$fieldName', Request::input('$field->name'), ['form' => 'searchForm', 'class' => 'form-control']) !!}\n";
        }

        return $output;
    }

    /**
     * Contruye un select con atributos para SelectPicker.
     *
     * @param stdClass $field
     * @param bool     $multiple
     * @param bool     $withDisabledFeature
     *
     * @return string
     */
    public function buildSelectPicker(
        stdClass $field,
        bool $multiple = true,
        bool $withDisabledFeature = false,
        bool $searchForm = false
    ) {
        $name = $multiple ? $field->name.'[]' : $field->name;

        $output = '{!! Form::select(';
        $output .= "\n\t\t'$name',";
        $output .= "\n\t\t\${$field->name}_list,";
        $output .= "\n\t\tRequest::input('$field->name'),";
        $output .= "\n\t\t[";
        $output .= "\n\t\t\t'class' => 'form-control selectpicker',";
        $output .= "\n\t\t\t'data-live-search' => 'false',";
        $output .= "\n\t\t\t'data-size' => '5',";
        $output .= "\n\t\t\t'title' => '---',";
        $output .= "\n\t\t\t'data-selected-text-format' => 'count > 0',";
        if ($multiple) {
            $output .= "\n\t\t\t'multiple',";
        }
        if ($withDisabledFeature) {
            $output .= "\n\t\t\tisset(\$show) ? 'disabled' : null,";
        }
        if ($searchForm) {
            $output .= "\n\t\t\t'form' => 'searchForm'";
        }
        $output .= "\n\t\t]";
        $output .= "\n\t) !!}\n";

        return $output;
    }

    /**
     * Genera los campos de búsqueda de fechas, hace uso de un componente
     * frontend, por ejemplo Bootstrap DateRangePicker, un campo informativo,
     * otro con la fecha inicial y otro con la fecha final de búsqueda.
     *
     * @param stdClass $field
     *
     * @return string
     */
    public function generateDatesSearchFields($field)
    {
        // campo informativo donde se concatena la fecha de inicio y fin para la búsqueda
        $output = "{!! Form::input('text', '$field->name[informative]', Request::input('$field->name')['informative'], ['form' => 'searchForm', 'class' => 'form-control']) !!}";
        // campo donde se guarda la fecha de inicio de la búsqueda
        $output .= "\n\t\t{!! Form::input('hidden', '$field->name[from]', Request::input('$field->name')['from'], ['form' => 'searchForm']) !!}";
        // campo donde se guarda la fecha de final de la búsqueda
        $output .= "\n\t\t{!! Form::input('hidden', '$field->name[to]', Request::input('$field->name')['to'], ['form' => 'searchForm']) !!}\n";

        return $output;
    }

    /**
     * Genera el html de los checkbox para el formulario de búsqueda en la tabla del index
     * con base al componente BootstrapSwitch.
     *
     * @param stdClass $field
     *
     * @return string
     */
    public function generateSearchCheckBoxesBootstrapSwitch($field)
    {
        return '<div>'
            .$this->generateCheckBoxBootstrapSwitchHtlm(
                $field,
                $name = $field->name.'_true',
                $value = 'true',
                $data_size = 'mini',
                $data_text = ['Si', '-'],
                $data_color = [],
                $form = 'searchForm'
            ).
            $this->generateCheckBoxBootstrapSwitchHtlm(
                $field,
                $name = $field->name.'_false',
                $value = 'true',
                $data_size = 'mini',
                $data_text = ['No', '-'],
                $data_color = ['danger', 'default'],
                $form = 'searchForm'
            );
    }

    /**
     * Genera el html de los checkbox para el formulario de búsqueda en la tabla
     * del index con base al componente iCheck.
     *
     * @param stdClass $field
     *
     * @return string
     */
    public function generateSearchCheckBoxesiCheck($field)
    {
        return $this->generateCheckBoxiCheckHtlm($field, $name = $field->name.'_true', $value = 'true', $class = 'icheckbox_square-blue', $form = 'searchForm').
               "\n\t\t".
               $this->generateCheckBoxiCheckHtlm($field, $name = $field->name.'_false', $value = 'true', $class = 'icheckbox_square-red', $form = 'searchForm');
    }

    /**
     * Devuelve un string con el tipo de campo (data-type) para el componente
     * x-editable.
     *
     * @param stdClass $field
     *
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
            return 'date';
        }

        // date-time
        if ($field->type == 'datetime') {
            return 'datetime';
        }

        // numbers
        if (in_array($field->type, ['int', 'unsigned_int']) && $field->key != 'MUL') {
            return 'number';
        }

        // numbers
        if (in_array($field->type, ['int', 'unsigned_int']) && $field->key == 'MUL') {
            return 'select';
        }

        // emails
        if (preg_match('/email/', $field->name)) {
            return 'email';
        }

        // enums
        if ($field->type == 'enum') {
            return 'select';
        }

        // default type
        return 'text';
    }

    /**
     * [getSourceForEnum description].
     *
     * @param stdClass $field
     *
     * @return string
     */
    public function getSourceForEnum(stdClass $field)
    {
        if ($field->type == 'enum' || (in_array($field->type, ['int', 'unsigned_int']) && $field->key == 'MUL')) {
            return '$'.$field->name.'_list_json';
        }

        return '';
    }

    /**
     * Devuelve string del código de los elementos de formulario.
     *
     * @param StdClass $field
     * @param string   $modelName
     * @param bool     $checkSkippedFields
     *
     * @return string|bool
     */
    public function getFormInputMarkup(
        stdClass $field,
        string $table_name,
        bool $checkSkippedFields = false
    ) {
        // $field es un campo de los que debo omitir?
        if (($field->on_create_form === false && $field->on_update_form === false) && $checkSkippedFields === false) {
            return false;
        }

        // abro el contenedor
        $output = "\n<div class='form-group col-sm-6 {{ \$errors->has('{$field->name}') ? 'has-error' : null }}'>\n";

        // el label
        $output .= "\t{!! Form::label('{$field->name}', trans('".$this->getLangAccess().'.form-labels.'.$field->name."')) !!}\n";

        // para selects
        if ($field->type == 'enum') {
            $output .= "\t".$this->buildSelectPicker($field, false, true);
            $output .= $this->endFormGroup($field);

            return $output;
        }

        // recorro las llaves foraneas
        foreach ($this->getForeignKeys($table_name) as $key => $foreign) {
            $child_table = explode('.', $foreign->foreign_key);
            $parent_table = explode('.', $foreign->references);

            // si el campo actual es una llave foránea
            if (strpos($child_table[1], $field->name) !== false) {
                $output .= "\t".$this->buildSelectPicker($field, false, true);
                $output .= $this->endFormGroup($field);

                return $output;
            }
        }

        // para checkbox
        if ($field->type == 'tinyint') {
            $output .= "\t<br>\n\t{!! Form::hidden('{$field->name}', '0') !!}\n\t".$this->generateCheckBoxBootstrapSwitchHtlm($field);
            $output .= $this->endFormGroup($field);

            return $output;
        }

        // para textarea
        if ($field->type == 'text') {
            $output .= "\t{!! Form::textarea('{$field->name}', null, ['class' => 'form-control', isset(\$show) ? 'disabled' : null]) !!}\n";
            $output .= $this->endFormGroup($field);

            return $output;
        }

        $type = 'text';

        // para campos de tipo fecha
        if ($field->type == 'date') {
            $type = 'date';
        }

        // para campos de tipo fecha y hora
        if ($field->type == 'datetime' || $field->type == 'timestamp') {
            $type = 'datetime-local';
        }

        // para inputs de tipo numérico
        if ($field->type == 'int' || $field->type == 'unsigned_int' || $field->type == 'float' || $field->type == 'double') {
            $type = 'number';
        }

        // si el usuario desea usar el componente Bootstrap DateTimePicker en los campos
        // de fecha, cambio el campo a tipo text
        if (($type == 'datetime-local' || $type == 'date') && $this->request->has('use_DateTimePicker_on_form_fields')) {
            $type = 'text';
        }

        // el campo
        $output .= "\t{!! Form::input('{$type}', '{$field->name}', null, ['class' => 'form-control', isset(\$show) ? 'disabled' : null]) !!}\n";
        $output .= $this->endFormGroup($field);

        return $output;
    }

    /**
     * Genera código HTML para un elemento de formulario que requiere confirmación.
     *
     * @param stdClas $field
     *
     * @return string
     */
    public function getFormInputConfirmationMarkup(stdClass $field)
    {
        // core condición para que no sea mostrado en formulario de sólo lectura
        $output = "\n@if(!isset(\$show))\n";
        // abro el contenedor
        $output .= "<div class='form-group col-sm-6 {{ \$errors->has('{$field->name}') ? 'has-error' : null }}'>\n";
        // el label
        $output .= "\t{!! Form::label('{$field->name}_confirmation', trans('".$this->getLangAccess().'.form-labels.'.$field->name."_confirmation')) !!}\n";
        // el campo
        $output .= "\t{!! Form::input('text', '{$field->name}_confirmation', null, ['class' => 'form-control']) !!}\n";
        $output .= $this->endFormGroup($field);
        $output .= "@endif\n";

        return $output;
    }

    /**
     * Genera el html de un checkbox con algunas propiedades para user el componente SwitchBootstrap,
     * aquí el sitio web de SwitchBootstrap:
     * http://www.bootstrap-switch.org/.
     *
     * @param stdClass $field
     * @param string   $name      El nombre del elemento
     * @param string   $value     El valor del atributo value
     * @param string   $data_size El atributo data-size para SwitchBootstrap
     * @param array    $data_text Los valores en el estado on y off
     * @param string   $form      El nombre del formulario al que pertenece el elemento
     *
     * @return string
     */
    public function generateCheckBoxBootstrapSwitchHtlm(
        stdClass $field,
        $name = null,
        string $value = '1',
        string $data_size = 'medium',
        array $data_text = [],
        array $data_color = [],
        string $form = null
    ) {
        // el formulario al que pertenece el elemento
        if ($form) {
            $form = "'form' => '$form'";
        }

        // el nombre del checkbox
        if (!$name) {
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

        $output = '{!! Form::checkbox(';
        $output .= "\n\t\t'{$name}',";
        $output .= "\n\t\t$value,";
        $output .= "\n\t\tnull,";
        $output .= "\n\t\t[";
        $output .= "\n\t\t\t'class' => 'bootstrap_switch',";
        $output .= "\n\t\t\t'data-size' => '$data_size',";
        $output .= "\n\t\t\t'data-on-text' => '$data_on_text',";
        $output .= "\n\t\t\t'data-off-text' => '$data_off_text',";
        $output .= "\n\t\t\t'data-on-color' => '$data_on_color',";
        $output .= "\n\t\t\t'data-off-color' => '$data_off_color',";
        $output .= "\n\t\t\tisset(\$show) ? 'disabled' : null,";

        $output .= $form ? "\n\t\t$form" : null;
        $output .= "\n\t\t]";
        $output .= ")\n\t!!}\n";

        return $output;
    }

    /**
     * Genera el html para generar un checkbox que haga uso del componente iCheck,
     * aquí el sitio web de iCheck:
     * http://icheck.fronteed.com/.
     *
     * @param stdClass $field
     * @param string   $name  El nombre del elemento
     * @param string   $value El valor del atributo value
     * @param string   $form  El nombre del formulario al que pertenece el elemento
     *
     * @return string
     */
    public function generateCheckBoxiCheckHtlm(stdClass $field, $name = null, $value = true, $class = null, $form = null)
    {
        // el formulario al que pertenece el elemento
        if ($form) {
            $form = "'form' => '$form'";
        }

        // el nombre del checkbox
        if (!$name) {
            $name = $field->name;
        }

        $checkbox = '<label>';
        $checkbox .= "\n\t\t\t{!! Form::checkbox('$name', $value, Request::input('$name'), ['class' => '$class', $form]) !!}";
        $checkbox .= "\n\t\t</label>";

        return $checkbox;
    }

    /**
     * Cierra el los tags iniciados en getFormInputMarkup($field, $table_name).
     *
     * @param stdClass $field
     *
     * @return string
     */
    public function endFormGroup(stdClass $field)
    {
        // los mensajes de error
        $output = "\n\t{!! \$errors->first('{$field->name}', '<span class=\"text-danger\">:message</span>') !!}\n";
        // cierro el contenedor
        $output .= "</div>\n";

        return $output;
    }

    /**
     * Devuelve string de la clase CSS a asociar a un input para uso del componete
     * x-editable, de momento las posibles clases son .editable, .editable-date y
     * .editable-datetime; son devueltos según el tipo de campo que tenga $field;.
     *
     * @param stdClass $field
     *
     * @return string
     */
    public function getInputXEditableClass(stdClass $field)
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
     * deleted_by = deletedBy->name.
     *
     * @param stdClass $field
     * @param string   $modelName
     *
     * @return string
     */
    public function getRecordFieldData(stdClass $field, $modelName)
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
     *
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
