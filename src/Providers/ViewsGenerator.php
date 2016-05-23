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
     * @var string
     */
    public $table_name;

    /**
     * Los mensajes de alerta en la operación.
     * @var array
     */
    public $msg_error = array();

    /**
     * Los mensajes de info en la operación.
     * @var array
     */
    public $msg_success = array();

    /**
     * La iformación dada por el usuario.
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

            $content = view($this->templatesDir().'.views.'.$view, [
                'gen' => $this,
                'fields' => $this->advanceFields($this->request),
                'request' => $this->request
            ]);

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
     * @param  stdClass $field
     * @param  string $table_name
     * @return string
     */
    public function getSearchInputStr($field, $table_name = null)
    {
        // selects
        if ($field->type == 'enum') {
            $output = "{!! Form::select('".$field->name."', array_merge(['' => '---'], \$".$field->name."_list), null, ['class' => 'form-control input-sm']) !!}";
            return $output;
        }

        // para checkbox
        if ($field->type == 'tinyint') {
            $output = $this->getCheckBoxSwitchHtlm($field, $data_size = 'small');
            $output .= $this->endFormGroup($field);
            return $output;
        }

        // recorro las llaves foraneas
        foreach ($this->getForeignKeys($table_name) as $key => $foreign) {
            $child_table = explode(".", $foreign->foreign_key);
            $parent_table = explode(".", $foreign->references);

            
            // si el campo actual es una llave foránea
            if (strpos($child_table[1], $field->name) !== false && $field->name != 'id') {
                $output = "{!! Form::select('{$field->name}', array_merge(['' => '---'], \$".$field->name."_list), null, ['class' => 'form-control input-sm']) !!}";
                return $output;
            }
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

        $output = '<input type="'.$type.'" class="form-control input-sm" name="'.$field->name.'" value="{{Request::input("'.$field->name.'")}}">';
        return $output;
    }

    /**
     * Devuelve un string con el tipo de campo para el formulario html.
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
        if (in_array($field->type, ['int', 'unsigned_int'])) {
            return "number";
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
     * @param  [type] $field [description]
     * @return string
     */
    public function getSourceForEnum($field)
    {
        if ($field->type == 'enum') {
            // "[{'Male':'Male'},{'Female':'Female'}]"

            $items = [];
            foreach ($field->enumValues as $value) {
                $items[] = "{'$value':'$value'}";
            }
            return 'data-source="['.join(',', $items).']"';
        }
        return "";
    }

    /**
     * Devuelve string del código de los elementos de formulario.
     * @param  StdClass $field
     * @param  string $modelName
     * @return string|bool
     */
    public function getFormInputMarkup($field, $table_name, $checkSkippedFields = false)
    {
        // $field es un campo de los que debo omitir?
        if (in_array($field->name, $this->skippedFields()) && $checkSkippedFields === false) {
            return false;
        }

        // ****************************************************************************
        // abro el contenedor
        $output = "<div class='form-group col-sm-6 {{\$errors->has('{$field->name}') ? 'has-error' : ''}}'>\n";
        // el label
        $output .= "{!! Form::label('{$field->name}', trans('".$this->getLangAccess()."/views.form-fields.".$field->name."')) !!}\n";
        // ****************************************************************************

        // para selects
        if ($field->type == 'enum') {
            //return "{!! \llstarscreamll\CrudGenerator\Form::select( '{$field->name}', [ '".join("', '",$field->enumValues)."' ] ){$modelStr}->show() !!}";
            $output .= "{!! Form::select('{$field->name}', \${$field->name}_list, null, ['class' => 'form-control', isset(\$show) ? 'disabled' : '']) !!}\n";
            $output .= $this->endFormGroup($field);
            return $output;
        }

        // para checkbox
        if ($field->type == 'tinyint') {
            $output .= "<br>{!! Form::hidden('{$field->name}', false) !!}".$this->getCheckBoxSwitchHtlm($field);
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
     * Devuelve string html de un checkbox con las propiedades para el componente SwitchBootstrap,
     * así:
     * {!! Form::checkbox('use_faker', true, null, [
     *      'class' => 'bootstrap_switch',
     *      data-size' => 'medium',
     *      'data-on-text' => 'SI',
     *      'data-off-text' => 'NO',
     *      isset(\$show) ? 'disabled' : ''
     *  ]) !!}
     * @param stdClass $field
     * @param string $data_size El atributo data-size para SwitchBootstrap
     * @return string
     */
    public function getCheckBoxSwitchHtlm($field, $data_size = 'medium')
    {
        return "{!! Form::checkbox('{$field->name}', true, null, [
                'class' => 'bootstrap_switch',
                'data-size' => '$data_size',
                'data-on-text' => 'SI',
                'data-off-text' => 'NO',
                isset(\$show) ? 'disabled' : ''
            ]) !!}\n";
    }

    /**
     * Cierra el los tags iniciados en getFormInputMarkup($field, $table_name).
     * @param  [type] $field [description]
     * @return string
     */
    public function endFormGroup($field)
    {
        // los mensajes de error
        $output = "{!!\$errors->first('{$field->name}', '<span class=\"text-danger\">:message</span>')!!}";
        // cierro el contenedor
        $output .= "\n</div>";

        return $output;
    }
}
