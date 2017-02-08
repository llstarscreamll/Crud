<?php

namespace llstarscreamll\Crud\Providers;

use stdClass;

/**
 *
 */
class BaseGenerator
{
    /**
     * El comodín para marcar el inicio y final de los nombres de las tablas
     * cuando se consulta cuales son las llaves foréneas que hay en toda la
     * base de datos.
     *
     * @var string
     */
    private $query_wildcard = '#';

    /**
     * Array de namespaces añadidos.
     *
     * @var array
     */
    public $namespacesAdded = [];

    /**
     * Devuelve los campos o columnas de la tabla especificada.
     *
     * @param string $table El nombre de la tabla en la base de datos.
     *
     * @return array
     */
    public static function fields($table)
    {
        $prefix = config(str_replace(':conection', env('DB_CONNECTION'), 'database.connections.:conection.prefix'));
        $columns = \DB::select('desc '.$prefix.$table);
        $tableFields = array(); // el valor a devolver

        foreach ($columns as $column) {
            $column = (array) $column;
            $field = new \stdClass();
            $field->name = $column['Field'];
            $field->defValue = $column['Default'];
            $field->required = $column['Null'] == 'NO';
            $field->key = $column['Key'];

            // longitud del campo
            $field->maxLength = 0;// get field and type from $res['Type']
            // el tipo del campo
            $type_length = explode('(', $column['Type']);
            $field->type = $type_length[0];

            if (count($type_length) > 1) { // en ocaciones no hay "("

                $field->maxLength = (int) $type_length[1];

                if ($field->type == 'enum') { // enum tiene valores como 'Masculino','Femenino')

                    // como el valor de $type_lenght[1] es algo como Masculino','Femenino')
                    // obtengo sólo los valores que me interesan: Masculino y Femenino
                    $matches = explode("'", $type_length[1]);

                    foreach ($matches as $match) {
                        if ($match && $match != ',' && $match != ')') {
                            $field->enumValues[] = $match;
                        }
                    }
                }
            }

            $tableFields[$field->name] = $field;
        }

        return $tableFields;
    }

    /**
     * Devuelve los campos de la entidad con datos mas específicos sobre cada una.
     *
     * @param Request $request
     *
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
            $field->on_index_table = isset($field_data['on_index_table']);
            $field->on_create_form = isset($field_data['on_create_form']);
            $field->on_update_form = isset($field_data['on_update_form']);
            $field->testData = empty($field_data['testData']) ? '""' : $field_data['testData'];
            if ($field->name == "deleted_at" && empty($field_data['testData'])) {
                $field->testData = 'null';
            }
            $field->testDataUpdate = empty($field_data['testDataUpdate']) ? '""' : $field_data['testDataUpdate'];
            if ($field->name == "deleted_at" && empty($field_data['testDataUpdate'])) {
                $field->testDataUpdate = 'null';
            }
            $field->validation_rules = $field_data['validation_rules'];

            $fields[$field->name] = $field;
        }

        $this->fields = $fields;

        return $fields;
    }

    /**
     * Devuelve array con los campos que son feraneos (foreign key) de la tabla en questión
     * y a que tabla apunta la llave foranea.
     *
     * @param string $tableName El nombre de la tabla.
     *
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
        $full_table_name = '';

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
     * ["foreign_key": "#prefix_table_employee_session#.employee_id", "references": "prefix_table_employees.id"].
     *
     * Se debe devolver lo siguiente:
     * ["foreign_key": "employee_session.employee_id", "references": "employees.id"]
     *
     * @param array
     *
     * @return array
     */
    public function cleanTablePrefix($data)
    {
        // TODO: y que pasa si no se ha configurado prefijos para las tablas?
        $prefix = config('database.connections.'.env('DB_CONNECTION', 'mysql').'.prefix');

        // si ningún prefijo hay para las tablas, pongo uno sólo porque no haya
        // problemas dentro del ciclo en la función str_replace()
        if (empty($prefix)) {
            $prefix = '!!!';
        }

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
     *
     * @param array    $foreign
     * @param stdClass $fields
     *
     * @return string|bool
     */
    public function getForeignKeyModelNamespace($foreign, $fields)
    {
        $namespace = '';
        $coincidences = 0;

        foreach ($fields as $key => $field) {
            if ($field->name == explode('.', $foreign->foreign_key)[1]) {
                $namespace = $field->namespace;
                array_push($this->namespacesAdded, $namespace);
            }
        }

        foreach ($this->namespacesAdded as $added) {
            if ($added === $namespace) {
                $coincidences++;
            }
        }

        //dd($this->namespacesAdded, $coincidences);

        return empty($namespace) || $coincidences > 1 ? false : $namespace;
    }

    /**
     * Obtiene string con el namespace del repositorio de un modelo.
     *
     * @param string $model El modelo.
     *
     * @return string
     */
    public function getModelRepositoryNamespace($model)
    {
        $modelName = class_basename($model);

        if (str_contains($model, 'llstarscreamll\\Core')) {
            $repo = "llstarscreamll\\Core\\Contracts\\".$modelName."Repository";
            if (interface_exists($repo)) {
                return $repo;
            }
        }

        $repo = config('modules.crud.config.parent-app-namespace').
            "\\Repositories\\Contracts\\".
            $modelName.
            "Repository";

        return $repo;
    }

    /**
     * Los campos a omitir.
     *
     * @return array
     */
    public function skippedFields()
    {
        return ['id', 'created_at', 'updated_at', 'deleted_at'];
    }

    /**
     * Verifica si el campo dado está dentro de los campos a omitir.
     *
     * @param string $fieldName
     *
     * @return bool
     */
    public function isGuarded($fieldName)
    {
        return in_array($fieldName, $this->skippedFields());
    }

    /**
     * Revisa si está presente la columna 'deleted_at' en los campos dados en el parámetro.
     *
     * @param stdClass $fields
     *
     * @return bool
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
     * @param stdClass $fields
     *
     * @return bool
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
     * - book_author = book-author.
     *
     * @return string
     */
    public function route()
    {
        //return str_slug(str_replace("_", " ", str_singular($this->table_name)));
        return str_slug(str_replace('_', ' ', $this->table_name));
    }

    /**
     * Devuelve el nombre de la clase del controlador.
     *
     * @return string
     */
    public function controllerClassName()
    {
        return studly_case(str_singular($this->table_name)).'Controller';
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
        return app_path('Models');
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
     * Devuelve el variable en singular con base en el nombre de una clase.
     *
     * @param string $class El nombre de la clase con namespace
     *
     * @return string La variable
     */
    public function modelVariableNameFromClass(string $class, string $variant = 'singular')
    {
        $name = camel_case(str_singular(class_basename($class)));

        if ($variant == 'plural') {
            $name = camel_case(str_plural(class_basename($class)));
        }

        return '$'.$name;
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
     * Devulve el nombre de la variable del modelo generado en plural.
     *
     * @return string
     */
    public function modelPluralVariableName()
    {
        return camel_case(str_plural($this->table_name));
    }

    /**
     * Devuelve el nombre de la entidad en singular iniciando las primeras letras de cada palabra
     * con mayúscula, aplica sólo al inglés.
     *
     * @return string
     */
    public function titleSingular()
    {
        return ucwords(str_singular(str_replace('_', ' ', $this->table_name)));
    }

    /**
     * Devuelve el nombre de la entidad en plural iniciando las primeras letras de cada palabra
     * con mayúscula, aplica sólo al inglés.
     *
     * @return string
     */
    public function titlePlural()
    {
        return ucwords(str_replace('_', ' ', $this->table_name));
    }

    /**
     * Devuelve el path a donde hay que buscar las plantillas para generar los archivos.
     *
     * @return string
     */
    public function templatesDir()
    {
        return config('modules.crud.config.templates');
    }

    /**
     * Devuelve el nombre de la entidad en camelCase y en plural.
     *
     * @return string
     */
    public function camelCasePlural()
    {
        return camel_case(str_replace('_', ' ', str_plural($this->table_name)));
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
        return lcfirst(str_replace('_', '-', $this->table_name));
    }

    /**
     * Devuelve el nombre para un campo de formulario modificando el string dado en el parámetro
     * para las validaciones, así:
     * parametro = 'El nombre', devolverá  'Nombre'.
     *
     * @param $label
     *
     * @return string
     */
    public function getFormFieldName($label)
    {
        $string = ucfirst(str_replace('el ', '', strtolower($label)));
        $string = ucfirst(str_replace('los ', '', strtolower($string)));
        $string = ucfirst(str_replace('la ', '', strtolower($string)));
        $string = ucfirst(str_replace('las ', '', strtolower($string)));

        return $string;
    }

    /**
     * Revisa si hay algún campo de tipo "date" en $fields.
     *
     * @param stdClass $fields
     *
     * @return bool
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
     * Revisa si hay algún campo de tipo "datetime" en $fields.
     *
     * @param stdClass $fields
     *
     * @return bool
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
     *
     * @param stdClass $fields
     *
     * @return bool
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
     * deleted_by = deletedBy.
     *
     * @param stdClass $field
     *
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
     * App\Models\Relations = relation || relations.
     *
     * @param stdClass $field
     *
     * @return string
     */
    public function getFunctionNameRelationFromNamespace($field)
    {
        $function = camel_case(substr($field->namespace, (strrpos($field->namespace, '\\') + 1)));

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
     *
     * @param stdClass $field
     *
     * @return string
     */
    public function getRelationClassFromNamespace($field)
    {
        return substr($field->namespace, (strrpos($field->namespace, '\\') + 1));
    }

    /**
     * Obtiene el nombre de la clase que hace de seeder de un tabla con base al namespace
     * de un modelo, por ejemplo:
     * App\Models\User = UsersTableSeeder.
     *
     * @return string
     */
    public function getTableSeederClassName($field)
    {
        return str_plural($this->getRelationClassFromNamespace($field)).'TableSeeder';
    }

    /**
     * Determina si un campo es obligatorio o no según las reglas de validación dadas en el mismo.
     *
     * @param stdClass $field
     *
     * @return bool
     */
    public function isTheFieldRequired($field)
    {
        return strpos($field->validation_rules, 'required') !== false;
    }

    /**
     * Devuelve el DocBlock de CopyRight de el código generado.
     *
     * @return string
     */
    public function getViewCopyRightDocBlock()
    {
        $link = config('modules.crud.config.link');
        $author = config('modules.crud.config.author');
        $license = config('modules.crud.config.license');
        $copyRight = config('modules.crud.config.copyright');
        $authorEmail = config('modules.crud.config.author_email');
        $package = !empty($this->request->get('is_part_of_package'))
            ? $this->request->get('is_part_of_package')
            : $this->request->get('plural_entity_name');

        return
        "Este archivo es parte de {$package}.\n".
        "    (c) $author <$authorEmail>\n".
        "    Licensed under $license.\n\n".

        "    @package    {$package}\n".
        "    @version    0.1\n".
        "    @author     $author\n".
        "    @license    $license\n".
        "    @copyright  $copyRight\n".
        "    @link       $link\n";
    }

    public function getClassCopyRightDocBlock()
    {
        $link = config('modules.crud.config.link');
        $author = config('modules.crud.config.author');
        $license = config('modules.crud.config.license');
        $copyRight = config('modules.crud.config.copyright');
        $authorEmail = config('modules.crud.config.author_email');
        $package = !empty($this->request->get('is_part_of_package'))
            ? $this->request->get('is_part_of_package')
            : $this->request->get('plural_entity_name');

        return
        "/**\n".
        " * Este archivo es parte de {$package}.\n".
        " * (c) $author <$authorEmail>\n".
        " * Licensed under $license.\n *\n".

        " * @package    {$package}\n".
        " * @version    0.1\n".
        " * @author     $author\n".
        " * @license    $license\n".
        " * @copyright  $copyRight\n".
        " * @link       $link\n".
        ' */';
    }

    /**
     * TODO: este método debe ser mvido a una clase que se dedique a generar
     * seeders.
     *
     * Devuelve el nombre de la variable con el método o propiedad que debe
     * generar los datos de prueba para los seeder, por ejemplo:
     *
     * - created_at = $date->toDateTimeString()
     * - slug = $faker->slug
     * - name = $faker->sentence
     *
     * @param Obejct $field
     *
     * @return string
     */
    public function getFakeDataGenerator($field, bool $onlyFaker = false)
    {
        // null para los campos de fecha de eliminación
        if ($field->name == 'deleted_at') {
            return 'null';
        }

        if ($field->type == 'timestamp' || $field->type == 'datetime') {
            return $onlyFaker ? '$faker->date(\'Y-m-d H:i:s\')' : '$date->toDateTimeString()';
        }

        if ($field->type == 'date') {
            return $onlyFaker ? '$faker->date(\'Y-m-d\')' : '$date->toDateString()';
        }

        if ($field->type == 'varchar') {
            return '$faker->sentence';
        }

        if ($field->type == 'text') {
            return '$faker->text';
        }

        if ($field->type == 'int' && $field->namespace) {
            $modelVariableName = $this->modelVariableNameFromClass($field->namespace, 'plural');

            return '$faker->randomElement('.$modelVariableName.')';
        }

        if (($field->type == 'int' || $field->type == 'bigint') && !$field->namespace) {
            return '$faker->randomNumber()';
        }

        if ($field->type == 'float' || $field->type == 'double') {
            return '$faker->randomFloat()';
        }

        if ($field->type == 'tinyint') {
            return '$faker->boolean(60)';
        }

        if ($field->type == 'enum') {
            $modelGenerator = new ModelGenerator($this->request);
            $enumValues = $modelGenerator->getMysqlTableColumnEnumValues($field->name);

            $enumValues = str_replace('enum(', '[', $enumValues);
            $enumValues = str_replace(')', ']', $enumValues);

            return "\$faker->randomElement($enumValues)";
        }

        // default
        return '$faker->';
    }

    /**
     * TODO: mover este método a una clase que se dedique a construir los
     * archivos de idioma nada más..
     * -------------------------------------------------------------------------.
     */
    public function getStoreSuccessMsg()
    {
        return $this->request->get('single_entity_name').' creado correctamente.';
    }

    /**
     * TODO: mover este método a una clase que se dedique a construir los
     * archivos de idioma nada más..
     * -------------------------------------------------------------------------.
     */
    public function getStoreErrorMsg()
    {
        return 'Error creando '.strtolower($this->request->get('single_entity_name')).'.';
    }

    /**
     * TODO: mover este método a una clase que se dedique a construir los
     * archivos de idioma nada más..
     * -------------------------------------------------------------------------.
     */
    public function getUpdateSuccessMsg()
    {
        return $this->request->get('single_entity_name').' actualizado correctamente.';
    }

    /**
     * TODO: mover este método a una clase que se dedique a construir los
     * archivos de idioma nada más..
     * -------------------------------------------------------------------------.
     */
    public function getUpdateErrorMsg()
    {
        return 'Ocurrió un error actualizando el '.strtolower($this->request->get('single_entity_name')).'.';
    }

    /**
     * TODO: mover este método a una clase que se dedique a construir los
     * archivos de idioma nada más..
     * -------------------------------------------------------------------------.
     */
    public function getDestroySuccessMsgSingle()
    {
        $msg = ucfirst(
            $this->request->get('single_entity_name')
        ).' eliminado correctamente.';

        if ($this->hasDeletedAtColumn($this->fields)) {
            $msg = 'El '.
                strtolower(
                    $this->request->get('single_entity_name')
                ).' ha sido movido a la papelera.';
        }

        return $msg;
    }

    /**
     * Obtiene texto del botón para ejecutar el método destroy del controlador
     * dependiendo si la tabla tiene la columna deleted_at o no. En singular.
     *
     * @return string
     */
    public function getDestroyBtnTxt()
    {
        $txt = $this->hasDeletedAtColumn($this->fields)
            ? 'Mover a Papelera'
            : 'Eliminar';

        return $txt;
    }

    /**
     * Obtiene texto del botón para ejecutar el método destroy del controlador
     * dependiendo si la tabla tiene la columna deleted_at o no. En plural.
     *
     * @return string
     */
    public function getDestroyManyBtnTxt()
    {
        $txt = $this->hasDeletedAtColumn($this->fields)
            ? 'Mover seleccionados a papelera'
            : 'Eliminar seleccionados';

        return $txt;
    }

    /**
     * Obtiene el nombre de la variable para los test del método destroy del
     * controlador, delete si la tabla no tiene columna deleted_at y trash si la
     * tiene.
     *
     * @return string.
     */
    public function getDestroyVariableName()
    {
        $txt = $this->hasDeletedAtColumn($this->fields)
            ? 'trash'
            : 'delete';

        return $txt;
    }

    /**
     * TODO: mover este método a una clase que se dedique a construir los
     * archivos de idioma nada más..
     * -------------------------------------------------------------------------.
     */
    public function getDestroySuccessMsgPlural()
    {
        return 'Los '.strtolower($this->request->get('plural_entity_name')).' han sido movidos a la papelera correctamente.';
    }

    /**
     * TODO: mover este método a una clase que se dedique a construir los
     * archivos de idioma nada más..
     * -------------------------------------------------------------------------.
     */
    public function getDestroyErrorMsgSingle()
    {
        return 'Ocurrió un problema moviendo el '.strtolower($this->request->get('single_entity_name')).' a la papelera.';
    }

    /**
     * TODO: mover este método a una clase que se dedique a construir los
     * archivos de idioma nada más..
     * -------------------------------------------------------------------------.
     */
    public function getDestroyErrorMsgPlural()
    {
        return 'Ocurrió un error moviendo los '.strtolower($this->request->get('plural_entity_name')).' a la papelera.';
    }

    /**
     * TODO: mover este método a una clase que se dedique a construir los
     * archivos de idioma nada más..
     * -------------------------------------------------------------------------.
     */
    public function getRestoreSuccessMsgSingle()
    {
        return 'El '.strtolower($this->request->get('single_entity_name')).' ha sido restaurado correctamente.';
    }

    /**
     * TODO: mover este método a una clase que se dedique a construir los
     * archivos de idioma nada más..
     * -------------------------------------------------------------------------.
     */
    public function getRestoreSuccessMsgPlural()
    {
        return 'Los '.strtolower($this->request->get('plural_entity_name')).' han sido restaurados correctamente.';
    }

    /**
     * TODO: mover este método a una clase que se dedique a construir los
     * archivos de idioma nada más..
     * -------------------------------------------------------------------------.
     */
    public function getRestoreErrorMsgSingle()
    {
        return 'Ocurrió un problema restaurando el '.strtolower($this->request->get('single_entity_name')).'.';
    }

    /**
     * TODO: mover este método a una clase que se dedique a construir los
     * archivos de idioma nada más..
     * -------------------------------------------------------------------------.
     */
    public function getRestoreErrorMsgPlural()
    {
        return 'Ocurrió un error restaurando los '.strtolower($this->request->get('plural_entity_name')).'.';
    }

    /**
     * TODO: mover este método a una mejor clase.
     *
     * Genera las reglas de validación para el campo.
     *
     * @param stdClass $field
     *
     * @return string
     */
    public function getValidationRules(stdClass $field, string $method = 'create')
    {
        $rules = '';

        if ($field->required &&
            $field->name !== 'id' &&
            $field->type !== 'tinyint' &&
            $method !== 'index'
        ) {
            $rules .= "'required', ";
        }

        if (in_array($field->type, $this->numericTypes()) &&
            ($field->key != 'PRI' && $field->key != 'MUL')
        ) {
            $rules .= "'numeric', ";
        }


        if (in_array($field->type, $this->numericTypes())
            && $method == 'index'
            && ($field->key == 'PRI' || $field->key == 'MUL')
        ) {
            $rules .= "'array', ";
        }

        if (in_array($field->type, $this->stringTypes())) {
            $rules .= "'string', ";
        }

        if (in_array($field->type, $this->datetimeTypes())) {
            $rules .= "'date_format:Y-m-d H:i:s', ";
        }

        if (in_array($field->type, $this->dateTypes())) {
            $rules .= "'date_format:Y-m-d', ";
        }

        if ($field->type == 'tinyint') {
            $rules .= "'boolean', ";
        }

        if ($field->type == 'enum') {
            $rules .= "'in:'.\$this->{$this->modelVariableName()}->getEnumValuesString('{$field->name}'), ";
        }

        if ($field->key == 'MUL') {
            $table = with(new $field->namespace)->getTable();
            $rules .= "'exists:$table,id', ";
        }

        if ($field->key == 'UNI') {
            $rules .= "'unique:$this->table_name,$field->name', ";
        }

        if (strpos($field->validation_rules, 'confirmed') && $method != 'index') {
            $rules .= "'confirmed', ";
        }

        // limpiamos
        $rules = trim($rules);
        $rules = trim($rules, ',');
        $rules = "[$rules]";

        return $rules;
    }

    /**
     * Devuelve array con valores de cuales son los posibles tipos de datos de
     * tipo numérico.
     *
     * @return array
     */
    public function numericTypes()
    {
        return ['int', 'double', 'float', 'bigint'];
    }

    /**
     * Devuelve array con valores de los posibles tipos de datos string.
     *
     * @return array
     */
    public function stringTypes()
    {
        return ['varchar', 'text'];
    }

    /**
     * Devuelve array con valores de cuales son los posibles tipos de datos de
     * tipo fecha y hora.
     *
     * @return array
     */
    public function datetimeTypes()
    {
        return ['datetime', 'timestamp'];
    }

    /**
     * Devuelve array con valores de cuales son los posibles tipos de datos de
     * tipo fecha.
     *
     * @return array
     */
    public function dateTypes()
    {
        return ['date'];
    }

    /**
     * Verifica si hay campos de tipo enum en el array dado.
     *
     * @param array $fields
     *
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
     * Comprueba si se está usando el paquete Core Module en esta instalación de
     * Laravel para usar las clases que dicho paquete comparte, sino para
     * añadirlas a esta instalación y dar el namespace correcto a dichos
     * ficheros.
     *
     * @return bool
     */
    public function areWeUsingCoreModule()
    {
        return (boolean) class_exists(\llstarscreamll\Core\Providers\CoreServiceProvider::class);
    }

    /**
     * Devuelve el namespace de los recursos compartidos de vistas y lenguaje
     * dependiendo de si se está usando o no el paquete Core Module, si se está
     * usando usaremos los recursos de dicho paquete, si no se usaran los de la
     * instalación actual de Laravel.
     *
     * @return string
     */
    public function solveSharedResourcesNamespace()
    {
        if ($this->areWeUsingCoreModule()) {
            return 'core::shared';
        }

        return 'shared';
    }

    /**
     * Devuelve el string para devolver la configuración del prefijo de los
     * campos de búsqueda dependiendo de si se usa o no el módulo Core.
     *
     * @return string
     */
    public function getSearchFieldsPrefixConfigString()
    {
        if ($this->areWeUsingCoreModule()) {
            return "config('modules.core.app.search-fields-prefix', 'search')";
        }

        return "config('{$this->modelVariableName()}.search-fields-prefix', 'search')";
    }

    /**
     * Optiene el tipo de dato nativo del campo, de la base de datos a PHP.
     *
     * @param stdClass $field
     *
     * @return string
     */
    public function getFieldTypeCast($field)
    {
        $stringTypes = [
            'varchar',
            'char',
            'text',
            'enum',
            'time',
        ];
        $cast = 'null';

        if (in_array($field->type, $stringTypes)) {
            $cast = 'string';
        }

        if ($field->type == 'double') {
            $cast = 'double';
        }

        if ($field->type == 'float') {
            $cast = 'float';
        }

        if ($field->type == 'tinyint') {
            $cast = 'boolean';
        }

        if ($field->type == 'int' || $field->type == 'bigint') {
            $cast = 'int';
        }

        if ($field->type == 'json') {
            $cast = 'array';
        }

        if ($field->type == 'date') {
            $cast = 'date';
        }

        if ($field->type == 'datetime' || $field->type == 'timestamp') {
            $cast = 'datetime';
        }

        return $cast;
    }

    /**
     * Devuelve string en forma de array "['value', 'value2']" con los posibles
     * valores de una columna de tipo enum de la base de datos.
     *
     * @param stdClass $field
     *
     * @return string
     */
    public function getEnumValuesArrayFormField(stdClass $field)
    {
        $modelGenerator = new ModelGenerator($this->request);
        $enumColumnQueryResult = $modelGenerator
            ->getMysqlTableColumnEnumValues($field->name);

        $values = str_replace('enum(', '', $enumColumnQueryResult);
        $values = str_replace(')', '', $values);

        return "[$values]";
    }

    /**
     * Obtiene el nombre del Critirea del repositorio.
     *
     * @return string
     */
    public function getRepositoryCriteriaName()
    {
        return 'Search'.$this->modelClassName().'Criteria';
    }

    /**
     * Compruena si la tabla tiene las columnas timestamps de Laravel.
     *
     * @param  stdClass  $fields
     *
     * @return boolean
     */
    public function hasLaravelTimestamps($fields)
    {
        $hasCreatedAtColumn = false;
        $hasUpdatedAtColumn = false;

        foreach ($fields as $field) {
            if ($field->name == "created_at") {
                $hasCreatedAtColumn = true;
            }

            if ($field->name == "updated_at") {
                $hasUpdatedAtColumn = true;
            }
        }

        return $hasCreatedAtColumn && $hasUpdatedAtColumn;
    }
}
