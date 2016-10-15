<?php

namespace llstarscreamll\CrudGenerator\Providers;

/**
*
*/
class BaseGenerator
{
    /**
     * El comodín para marcar el inicio y final de los nombres de las tablas
     * cuando se consulta cuales son las llaves foréneas que hay en toda la
     * base de datos.
     * @var string
     */
    private $query_wildcard = '#';

    /**
     * Devuelve los campos o columnas de la tabla especificada.
     *
     * @param  string $table El nombre de la tabla en la base de datos.
     * @return array
     */
    public static function fields($table)
    {
        $columns = \DB::select('desc '.config('database.connections.mysql.prefix').$table);
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
     * Devuelve los campos de la entidad con datos mas específicos sobre cada una.
     *
     * @param  Request $request
     * @return array
     */
    public function advanceFields($request)
    {
        $fields = array();

        foreach ($request->get('field') as $field_data) {
            $field = new \stdClass();
            $field->name = $field_data['name'];
            $field->label = $field_data['label'];
            $field->type = $field_data['type'];
            $field->required = isset($field_data['required']);
            $field->defValue = $field_data['defValue'];
            $field->key = $field_data['key'];
            $field->maxLength = $field_data['maxLength'];
            $field->namespace = $field_data['namespace'];
            $field->relation = $field_data['relation'];
            $field->fillable = isset($field_data['fillable']);
            $field->hidden = isset($field_data['hidden']);
            $field->on_create_form = isset($field_data['on_create_form']);
            $field->on_update_form = isset($field_data['on_update_form']);
            $field->testData = empty($field_data['testData']) ? 'null' : $field_data['testData'];
            $field->testDataUpdate = empty($field_data['testDataUpdate']) ? 'null' : $field_data['testDataUpdate'];
            $field->validation_rules = $field_data['validation_rules'];

            // everything decided for the field, add it to the array
            $fields[$field->name] = $field;
        }

        return $fields;
    }

    /**
     * Devuelve array con los campos que son feraneos (foreign key) de la tabla en questión
     * y a que tabla apunta la llave foranea.
     *
     * @param  string $tableName El nombre de la tabla.
     * @return array
     */
    public function getForeignKeys($tableName)
    {
        $results = \DB::select(
            "select
            concat('$this->query_wildcard', table_name, '$this->query_wildcard.', column_name) as 'foreign_key',  
            concat(referenced_table_name, '.', referenced_column_name) as 'references'
            from
                information_schema.key_column_usage
            where
                referenced_table_name is not null
            and table_schema = '".config('database.connections.'.env('DB_CONNECTION', 'mysql').'.database')."'"
        );

        $data = [];
        
        $prefix = config('database.connections.'.env('DB_CONNECTION', 'mysql').'.prefix');
        $full_table_name = "";

        foreach ($results as $key => $result) {

            $full_table_name = $this->query_wildcard;
            $full_table_name .= $prefix;
            $full_table_name .= $tableName;
            $full_table_name .= $this->query_wildcard.'.';

            if (strpos($result->foreign_key, $full_table_name) !== false) {
                $data[] = $this->cleanTablePrefix($result);
            }

        }

        return $data;
    }

    /**
     * Limpia el prefijo de los nombres de las tablas de la base de datos, se espera el resultado de la consulta
     * ejecutada en la función getForeignKeys($tableName), así que para el array:
     * ["foreign_key": "#prefix_table_employee_session#.employee_id", "references": "prefix_table_employees.id"]
     *
     * Se debe devolver lo siguiente:
     * ["foreign_key": "employee_session.employee_id", "references": "employees.id"]
     * @param  array
     * @return array
     */
    public function cleanTablePrefix($data)
    {
        $prefix = config('database.connections.'.env('DB_CONNECTION', 'mysql').'.prefix');
        $data_clean = new \stdClass();

        foreach ($data as $key => $item) {
            
            // realizamos la limpieza de las tablas
            if (strpos($item, $prefix) !== false) {

                // quitamos el prefijo de la base de datos
                $str = str_replace($prefix, '', $item);
                // quitamos los comodines que delimitan el nombre de la tabla
                $data_clean->{$key} = str_replace($this->query_wildcard, '', $str);
                
            } else {
                $data_clean->{$key} = $item;
            }

        }

        return $data_clean;
    }

    /**
     * Obtiene string con la clase con el namespace digitado por el usuario de un campo con
     * una llave foránea.
     * @param  array    $foreign
     * @param  stdClass $fields
     * @return string|bool
     */
    public function getForeignKeyModelNamespace($foreign, $fields)
    {
        foreach ($fields as $key => $field) {
            if ($field->name == explode(".", $foreign->foreign_key)[1]) {
                return $field->namespace;
            }
        }

        return false;
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
     * Verifica si el campo dado está dentro de los campos a omitir.
     *
     * @param  string $fieldName
     * @return bool
     */
    public function isGuarded($fieldName)
    {
        return in_array($fieldName, $this->skippedFields());
    }

    /**
     * Revisa si está presente la columna 'deleted_at' en los campos dados en el parámetro.
     *
     * @param  stdClass $fields
     * @return boolean
     */
    public function hasDeletedAtColumn($fields)
    {
        foreach ($fields as $key => $field) {
            if ($field->name == 'deleted_at') {
                return true;
            }
        }

        return false;
    }

    /**
     * Revisa si hay algún campo de tipo 'tinyint' en los campos dados en el parámetro.
     *
     * @param  stdClass $fields
     * @return boolean
     */
    public function hasTinyintTypeField($fields)
    {
        foreach ($fields as $key => $field) {
            if ($field->type == 'tinyint') {
                return true;
            }
        }

        return false;
    }

    /**
     * Devuelve string con el prefijo de nombre de ruta para la app, por ejemplo:
     * - books = book
     * - book_author = book-author
     *
     * @return string
     */
    public function route()
    {
        //return str_slug(str_replace("_", " ", str_singular($this->table_name)));
        return str_slug(str_replace("_", " ", $this->table_name));
    }

    /**
     * Devuelve el nombre de la clase del controlador.
     *
     * @return string
     */
    public function controllerClassName()
    {
        return studly_case(str_singular($this->table_name))."Controller";
    }

    /**
     * Devuelve el path completo a la carpeta de las vistas.
     *
     * @return string
     */
    public function viewsDir()
    {
        return base_path('resources/views/'.$this->viewsDirName());
    }

    /**
     * Devuelve el nombre de la carpeta donde serán guardadas las vistas.
     *
     * @return string
     */
    public function viewsDirName()
    {
        return $this->camelCasePlural();
    }

    /**
     * Devuelve el path donde guardará el controllador.
     *
     * @return string
     */
    public function controllersDir()
    {
        return app_path('Http/Controllers');
    }

    /**
     * Devuelve el path donde se guardará el modelo.
     *
     * @return string
     */
    public function modelsDir()
    {
        return app_path().'/Models';
    }

    /**
     * Devuelve el nombre que tendrá la clase del modelo.
     *
     * @return string
     */
    public function modelClassName()
    {
        return studly_case(str_singular($this->table_name));
    }

    /**
     * Devulve el nombre de la variable del modelo generado en singular.
     *
     * @return string
     */
    public function modelVariableName()
    {
        return camel_case(str_singular($this->table_name));
    }

    /**
     * Devulve el nombre de la variable del modelo generado en plural.
     *
     * @return string
     */
    public function modelSingularVariableName()
    {
        return camel_case($this->table_name);
    }

    /**
     * Devuelve el nombre de la entidad en singular iniciando las primeras letras de cada palabra
     * con mayúscula, aplica sólo al inglés.
     *
     * @return string
     */
    public function titleSingular()
    {
        return ucwords(str_singular(str_replace("_", " ", $this->table_name)));
    }

    /**
     * Devuelve el nombre de la entidad en plural iniciando las primeras letras de cada palabra
     * con mayúscula, aplica sólo al inglés.
     *
     * @return string
     */
    public function titlePlural()
    {
        return ucwords(str_replace("_", " ", $this->table_name));
    }

    /**
     * Devuelve el path a donde hay que buscar las plantillas para generar los archivos.
     *
     * @return string
     */
    public function templatesDir()
    {
        return config('modules.CrudGenerator.config.templates');
    }

    /**
     * Devuelve el nombre de la entidad en camelCase y en plural.
     *
     * @return string
     */
    public function camelCasePlural()
    {
        return camel_case(str_replace("_", " ", str_plural($this->table_name)));
    }

    /**
     * Devuelve el nombre de la entidad en StudlyCase y en plural.
     *
     * @return string
     */
    public function studlyCasePlural()
    {
        return studly_case(str_plural($this->table_name));
    }

    /**
     * Devuelve el nombre de la entidad en snake_case y en singular.
     *
     * @return string
     */
    public function snakeCaseSingular()
    {
        return snake_case(str_singular($this->table_name));
    }

    /**
     * Devuelve string para acceder a los ficheros de lengauje con la función translate().
     *
     * @return string
     */
    public function getLangAccess()
    {
        return lcfirst($this->modelClassName());
    }

    /**
     * Obtiene el nombre del modelo separados por guiones (-) en minúscula.
     *
     * @return string
     */
    public function getDashedModelName()
    {
        return lcfirst(str_replace("_", "-", $this->table_name));
    }

    /**
     * Devuelve el nombre para un campo de formulario modificando el string dado en el parámetro
     * para las validaciones, así:
     * parametro = 'El nombre', devolverá  'Nombre'
     *
     * @param  $label
     * @return string
     */
    public function getFormFieldName($label)
    {
        $string = ucwords(str_replace("el ", "", strtolower($label)));
        $string = ucwords(str_replace("los ", "", strtolower($string)));
        $string = ucwords(str_replace("la ", "", strtolower($string)));
        $string = ucwords(str_replace("las ", "", strtolower($string)));

        return $string;
    }

    /**
     * Revisa si hay algún campo de tipo "date" en $fields
     * @param  stdClass  $fields
     * @return boolean
     */
    public function hasDateFields($fields)
    {
        foreach ($fields as $key => $field) {
            if ($field->type == 'date') {
                return true;
            }
        }

        return false;
    }

    /**
     * Revisa si hay algún campo de tipo "datetime" en $fields
     * @param  stdClass  $fields
     * @return boolean
     */
    public function hasDateTimeFields($fields)
    {
        foreach ($fields as $key => $field) {
            if ($field->type == 'datetime' || $field->type == 'timestamp') {
                return true;
            }
        }

        return false;
    }

    /**
     * Revisa si hay campos de tipo select con base a el objeto $fields dado.
     * @param  stdClass  $fields
     * @return boolean
     */
    public function hasSelectFields($fields)
    {
        foreach ($fields as $key => $field) {
            if ($field->type == 'enum' || $field->key == 'MUL') {
                return true;
            }
        }

        return false;
    }

    /**
     * Obtiene el nombre de la función para la relación del modelo a partir
     * del nombre del campo que tiene es llave foránea y teniendo en cuenta
     * el tipo de relación, por ejemplo:
     * relation_id = relation|relations
     * deleted_by = deletedBy
     * @param  stdClass $field
     * @return string
     */
    public function getFunctionNameRelationFromField($field)
    {
        $function = camel_case(str_replace('_id', '', $field->name));

        // nombre en singular
        if (in_array($function, ['belongsTo', 'hasOne'])) {
            $function = str_singular($function);
        }

        // nombre en plural
        if (in_array($function, ['hasMany', 'belongsToMany'])) {
            $function = str_plural($function);
        }

        return $function;
    }

    /**
     * Obtiene el nombre de la función para la relación del modelo a partir
     * del namespace de la clase con la que se va a relacionar y dependiendo
     * también del tipo de relación, por ejemplo:
     * App\Models\Relations = relation || relations
     * @param  stdClass $field
     * @return string
     */
    public function getFunctionNameRelationFromNamespace($field)
    {
        $function = camel_case(substr($field->namespace, (strrpos($field->namespace, '\\')+1)));

        // nombre en singular
        if (in_array($function, ['belongsTo', 'hasOne'])) {
            $function = str_singular($function);
        }

        // nombre en plural
        if (in_array($function, ['hasMany', 'belongsToMany'])) {
            $function = str_plural($function);
        }

        return $function;
    }

    /**
     * Devuelve string con el nombre de la clase sin el namespace.
     * @param  stdClass $field
     * @return string
     */
    public function getRelationClassFromNamespace($field)
    {
        return substr($field->namespace, (strrpos($field->namespace, '\\')+1));
    }

    /**
     * Obtiene el nombre de la clase que hace de seeder de un tabla con base al namespace
     * de un modelo, por ejemplo:
     * App\Models\User = UsersTableSeeder
     * @return string
     */
    public function getTableSeederClassName($field)
    {
        return str_plural($this->getRelationClassFromNamespace($field)).'TableSeeder';
    }

    /**
     * Determina si un campo es obligatorio o no según las reglas de validación dadas en el mismo.
     * @param  stdClass  $field
     * @return boolean
     */
    public function isTheFieldRequired($field)
    {
        return strpos($field->validation_rules, 'required') !== false;
    }
}
