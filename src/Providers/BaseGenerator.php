<?php

namespace llstarscreamll\CrudGenerator\Providers;

/**
* 
*/
class BaseGenerator
{
    /**
     * Devuelve los campos o columnas de la tabla especificada.
     * @param  string $table El nombre de la tabla en la base de datos.
     * @return array
     */
    public static function fields($table)
    {
        $columns = \DB::select('show fields from '.$table);
        $tableFields = array(); // el valor a devolver

        foreach ($columns as $column) {
            $column = (array)$column;
            $field = new \stdClass();
            $field->name = $column['Field'];
            $field->defValue = $column['Default'];
            $field->required = $column['Null'] == 'NO';
            $field->key = $column['Key'];

            // longitud del campo
            $field->maxLength = 0;// get field and type from $res['Type']
            // el tipo del campo
            $type_length = explode("(", $column['Type']);
            $field->type = $type_length[0];

            if (count($type_length) > 1) { // en ocaciones no hay "("

                $field->maxLength = (int)$type_length[1];

                if ($field->type == 'enum') { // enum tiene valores como 'Masculino','Femenino')

                    // como el valor de $type_lenght[1] es algo como Masculino','Femenino')
                    // obtengo sólo los valores que me interesan: Masculino y Femenino
                    $matches = explode("'", $type_length[1]);

                    foreach ($matches as $match) {
                        if ($match && $match != "," && $match != ")") {
                            $field->enumValues[] = $match;
                        }
                    }
                }
            }

            // everything decided for the field, add it to the array
            $tableFields[$field->name] = $field;
        }

        return $tableFields;
    }

    /**
     * Devuelve array con los campos que son feraneos (foreign key) de la tabla en questión
     * y a que tabla apunta la llave foranea.
     * @param  string $tableName El nombre de la tabla.
     * @return array
     */
    public function getForeignKeys($tableName)
    {
        $results = \DB::select("select
            concat(table_name, '.', column_name) as 'foreign_key',  
            concat(referenced_table_name, '.', referenced_column_name) as 'references'
            from
                information_schema.key_column_usage
            where
                referenced_table_name is not null
            and table_schema = 'test'"
        );

        $data = [];

        foreach ($results as $key => $result) {
            if (strpos($result->foreign_key, $tableName.'.') !== false) {
                $data[] = $result;
            }
        }

        return $data;
    }

    /**
     * Los campos a omitir.
     * @return array
     */
    public function skippedFields()
    {
        return ['id','created_at','updated_at', 'deleted_at'];
    }

    /**
     * Verifica si el campo dado está dentro de los campos a omitir.
     * @param  string  $fieldName
     * @return bool
     */
    public function isGuarded($fieldName)
    {
        return in_array($fieldName, $this->skippedFields());
    }

    /**
     * Devuelve string con el prefijo de nombre de ruta para la app, por ejemplo:
     * - books = book
     * - book_author = book-author
     * @return string
     */
    public function route()
    {
        return str_slug(str_replace("_", " ", str_singular($this->table_name)));
    }

    /**
     * Devuelve el nombre de la clase del controlador.
     * @return string
     */
    public function controllerClassName()
    {
        return studly_case(str_singular($this->table_name))."Controller";
    }

    /**
     * Devuelve el path completo a la carpeta de las vistas.
     * @return string
     */
    public function viewsDir()
    {
        return base_path('resources/views/'.$this->viewsDirName());
    }

    /**
     * Devuelve el nombre de la carpeta donde serán guardadas las vistas.
     * @return string
     */
    public function viewsDirName()
    {
        return str_singular($this->table_name);
    }

    /**
     * Devuelve el path donde guardará el controllador.
     * @return string
     */
    public function controllersDir()
    {
        return app_path('Http/Controllers');
    }

    /**
     * Devuelve el path donde se guardará el modelo.
     * @return string
     */
    public function modelsDir()
    {
        return app_path();
    }

    /**
     * Devuelve el nombre que tendrá la clase del modelo.
     * @return string
     */
    public function modelClassName()
    {
        return studly_case(str_singular($this->table_name));
    }

    /**
     * Devulve el nombre de la variable del modelo generado.
     * @return string
     */
    public function modelVariableName()
    {
        return camel_case(str_singular($this->table_name));
    }

    /**
     * Devuelve el nombre de la entidad en singular iniciando las primeras letras de cada palabra
     * con mayúscula, aplica sólo al inglés.
     * @return string
     */
    public function titleSingular()
    {
        return ucwords(str_singular(str_replace("_", " ", $this->table_name)));
    }

    /**
     * Devuelve el nombre de la entidad en plural iniciando las primeras letras de cada palabra
     * con mayúscula, aplica sólo al inglés.
     * @return string
     */
    public function titlePlural()
    {
        return ucwords(str_replace("_", " ", $this->table_name));
    }

    /**
     * Devulve el valor del archivo de configuración a donde se debe hacer referencia para usar
     * los templates para generar los respectivos archivos.
     * @return string
     */
    public function templatesDir()
    {
        return config('llstarscreamll.CrudGenerator.config.templates');
    }
}
