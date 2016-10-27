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
     *
     * @var string
     */
    public $table_name;
    
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
     * Genera el archivo para el Modelo de la tabla.
     *
     * @return integer|bool
     */
    public function generate()
    {
        // no se ha creado la carpeta para los modelos?
        if (! file_exists($this->modelsDir())) {
            // entonces la creo
            mkdir($this->modelsDir(), 0755, true);
        }

        $modelFile = $this->modelsDir().'/'.$this->modelClassName().".php";

        $content = view(
            $this->templatesDir().'.model',
            [
            'gen' => $this,
            'fields' => $this->advanceFields($this->request),
            'request' => $this->request
            ]
        );

        return file_put_contents($modelFile, $content);
    }

    /**
     * Devuelve string con clausula para el Query Builder de Eloquent
     *
     * @param  stdClass $field
     * @param  string   $value
     * @return string
     */
    public function getConditionStr($field, $value = null)
    {
        $columnName = $field->name == 'id' ? 'ids' : $field->name;

        // cláusula por defecto
        $string = "'{$field->name}', \$request->get('{$columnName}')";

        // para búsquedas de tipo texto
        if (in_array($field->type, ['varchar', 'text'])) {
            $string = "'{$field->name}', 'like', '%'.\$request->get('{$columnName}').'%'";
        }

        // para búsquedas en campos de tipo enum
        if ($field->type == 'enum') {
            $string = "'{$field->name}', \$request->get('$columnName')";
        }

        // para búsqueda en campos de tipo boolean
        if ($field->type == 'tinyint') {
            $string = "'{$field->name}', $value";
        }
        
        return $string;
    }

    /**
     * Devuelve la llave primaria para el modelo.
     * @param  stdClass $field
     * @return string
     */
    public function getPrimaryKey($fields)
    {
        // el valor por defecto de la llave primaria
        $primary_key = 'id';

        foreach ($fields as $field) {
            if ($field->key == 'PRI') {
                $primary_key = $field->name;
            }
        }

        return $primary_key;
    }

    /**
     * Los campos a omitir.
     *
     * @return array
     */
    public function skippedFields()
    {
        return ['id','created_at','updated_at', 'deleted_at'];
    }

    /**
     * Obtiene los valores enum de la columna indicada en el parámetro $column.
     * @param  string $column El nombre de la columna
     * @return string
     */
    public function getMysqlTableColumnEnumValues($column)
    {
        return \DB::select( \DB::raw("SHOW COLUMNS FROM {$this->getDatabaseTablesPrefix()}$this->table_name WHERE Field = '$column'") )[0]->Type;
    }

    /**
     * Devuelve string del prefijo de las tablas de la base de datos.
     * @return string El nombre del driver de la conexión a la base de datos.
     */
    public static function getDatabaseTablesPrefix()
    {
        return config('database.connections.'.config('database.default').'.prefix');
    }
}
