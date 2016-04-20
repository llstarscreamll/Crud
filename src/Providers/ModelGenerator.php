<?php

namespace llstarscreamll\CrudGenerator\Providers;

use llstarscreamll\CrudGenerator\Providers\BaseGenerator;

/**
* 
*/
class ModelGenerator extends BaseGenerator
{
    /**
     * El nombre de la tabla en la base de datos.
     * @var string
     */
    public $table_name;

    /**
     * 
     */
    public function __construct($table_name)
    {
        $this->table_name = $table_name;
    }

    /**
     * Genera el archivo para el Modelo de la tabla.
     * @return integer|bool
     */
    public function generate()
    {
        $modelFile = $this->modelsDir().'/'.$this->modelClassName().".php";

        $content = view($this->templatesDir().'.model', [
            'gen' => $this,
            'fields' => $this->fields($this->table_name)
        ]);

        return file_put_contents($modelFile, $content);
    }

    /**
     * Devuelve string de validación de datos de un campo de la base de datos
     * para el modelo.
     * @param  Object $field
     * @return string
     */
    public function getValidationRule($field)
    {
        // skip certain fields
        if (in_array($field->name, $this->skippedFields())) {
            return "";
        }

        $rules = [];
        // required fields
        if ($field->required) {
            $rules[] = "required";
        }

        // strings
        if (in_array($field->type, ['varchar', 'text'])) {
            $rules[] = "string";
            if ($field->maxLength) {
                $rules[] = "max:".$field->maxLength;
            }
        }

        // dates
        if (in_array($field->type, ['date', 'datetime'])) {
            $rules[] = "date";
        }

        // numbers
        if (in_array($field->type, ['int', 'unsigned_int'])) {
            $rules [] = "integer";
        }

        // emails
        if (preg_match("/email/", $field->name)) {
            $rules[] = "email";
        }

        // enums
        if ($field->type == 'enum') {
            $rules [] = "in:".join(",", $field->enumValues);
        }

        return "'".$field->name."' => '".join("|", $rules)."',";
    }

    /**
     * Verifica si hay campos de tipo enum en el array dado.
     * @param  array $fields
     * @return bool
     */
    public function areEnumFields($fields)
    {
        foreach ($fields as $key => $field) {
            if ($field->type == 'enum') {
                return true;
            }
        }

        return false;
    }

    /**
     * Devuelve string con clausula para el Query Builder de Eloquent
     * @param  [type] $field [description]
     * @return [type]        [description]
     */
    public function getConditionStr($field)
    {
        if (in_array($field->type, ['varchar', 'text'])) {
            return "'{$field->name}','like','%'.\Request::input('{$field->name}').'%'";
        }
        return "'{$field->name}',\Request::input('{$field->name}')";
    }

    /**
     * Los campos a omitir.
     * @return array
     */
    public function skippedFields()
    {
        return ['id','created_at','updated_at', 'deleted_at'];
    }
}
