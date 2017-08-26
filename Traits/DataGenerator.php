<?php

namespace App\Containers\Crud\Traits;

use stdClass;
use Illuminate\Support\Collection;
use Vinkla\Hashids\Facades\Hashids;

/**
 * DataGenerator Trait.
 */
/**
 * TODO: this trait should be a abstrac class?
 */
trait DataGenerator
{
    /**
     * @var boolean
     */
    public $hasSoftDeleteColumn = false;

    /**
     * @var boolean
     */
    public $hasLaravelTimestamps = false;

    /**
     * @var boolean
     */
    public $hasCreatedAtColumn = false;

    /**
     * @var boolean
     */
    public $hasUpdatedAtColumn = false;

    /**
     * @var boolean
     */
    public $groupMainApiatoClasses = false;

    /**
     * @var boolean
     */
    public $hasRelations = false;

    /**
     * @var string
     */
    public $primaryKey = '';

    public function parseFields($request)
    {
        $fields = array();

        foreach ($request->get('field') as $field_data) {
            $field = new stdClass();
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
            if ($field->name == 'deleted_at' && empty($field_data['testData'])) {
                $field->testData = 'null';
            }
            $field->testDataUpdate = empty($field_data['testDataUpdate']) ? '""' : $field_data['testDataUpdate'];
            if ($field->name == 'deleted_at' && empty($field_data['testDataUpdate'])) {
                $field->testDataUpdate = 'null';
            }
            $field->validation_rules = $field_data['validation_rules'];

            $fields[$field->name] = $field;

            // some data checks
            !empty($field_data['namespace']) ? $this->hasRelations = true : null;
            $field_data['name'] == "created_at" ? ($this->hasCreatedAtColumn = true) : null;
            $field_data['name'] == "updated_at" ? ($this->hasUpdatedAtColumn = true) : null;
            $field_data['name'] == "deleted_at" ? ($this->hasSoftDeleteColumn = true) : null;
            $field_data['key'] == "PRI" ? ($this->primaryKey = $field_data['name']) : null;
        }

        $this->fields = $fields;

        // some final checks
        $this->hasCreatedAtColumn && $this->hasUpdatedAtColumn
            ? ($this->hasLaravelTimestamps = true)
            : null;

        $this->groupMainApiatoClasses = $this->request->get('group_main_apiato_classes', false);

        return collect($fields);
    }

    public function getFormModelConfigArray(Collection $fields)
    {
        $config = [];
        $dividers = 0;

        foreach ($fields as $field) {
            $fieldConfig = [];
            $fieldConfig['name'] = $field->name;
            $fieldConfig['type'] = $this->getWidgetType($field);
            $fieldConfig['placeholder'] = '';
            $fieldConfig['value'] = $field->defValue;
            $fieldConfig['min'] = '';
            $fieldConfig['max'] = '';

            // style classes
            $fieldConfig['mainWrapperClass'] = 'col-sm-6';
            $fieldConfig['labelClass'] = '';
            $fieldConfig['controlWrapperClass'] = '';
            $fieldConfig['controlClass'] = '';
            // add a divider after the id field
            $fieldConfig['break'] = in_array($field->name, ['id']) ? true : false ;

            $fieldConfig['visibility'] = [
                'create' => $field->on_create_form,
                'details' => !$field->hidden,
                'edit' => $field->on_update_form,
                'search' => !$field->hidden,
            ];

            if ($field->namespace) {
                $fieldConfig['dynamicOptions'] = [
                    'data' => str_plural(class_basename($field->namespace))
                ];
            }

            if ($field->type === 'tinyint') {
                $fieldConfig['option'] = [
                    'value' => 'true',
                    'label' => trans('crud::templates.yes'),
                ];
            }

            if ($field->type == "enum") {
                $fieldConfig['options'] = $this->getEnumValuesArray($field->name);
            }

            if ($field->validation_rules) {
                $fieldConfig['validation'] = explode('|', $field->validation_rules);
            }

            $config[] = $fieldConfig;
        }

        return $config;
    }

    public function getWidgetType($field)
    {
        $type = "";

        if ($field->key == 'PRI') {
            return 'text';
        }

        switch ($field->type) {
            case 'enum':
                $type = "radio";
                break;

            case 'bigint':
            case 'float':
            case 'double':
                $type = "number";
                break;

            case 'timestamp':
            case 'datetime':
                $type = "datetime-local";
                break;

            case 'date':
                $type = "date";
                break;

            case 'time':
                $type = "time";
                break;
            
            case 'int': {
                $type = "number";
                if ($field->namespace) {
                    $type = "select";
                }
            }
                break;

            case 'tinyint':
                $type = "checkbox";
                break;

            case 'text':
                $type = "textarea";
                break;
            
            default:
                $type = "text";
                break;
        }

        return $type;
    }

    public function getFakeData($field, bool $onlyFaker = false)
    {
        // null para los campos de fecha de eliminación
        if ($field->name == 'deleted_at') {
            return 'null';
        }

        if (str_contains($field->validation_rules, 'email')) {
            return '$faker->email';
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
            $modelVariableName = $this->variableFromNamespace($field->namespace, $singular = false);

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
            $enumValues = $this->getMysqlTableColumnEnumValues($field->name);

            $enumValues = str_replace('enum(', '[', $enumValues);
            $enumValues = str_replace(')', ']', $enumValues);

            return "\$faker->randomElement($enumValues)";
        }

        // default
        return '$faker->';
    }

    /**
     * @return array
     */
    public function getEnumValuesArray(string $column)
    {
        $values = $this->getMysqlTableColumnEnumValues($column);
        $values = str_replace('enum(', '', $values);
        $values = str_replace('\')', '\'', $values);
        $values = str_replace('\'', '', $values);

        return explode(',', $values);
    }

    /**
     * TODO: where ti put this method? And what if the app is runing on sqlite?
     *
     * @param string $column The table column name
     *
     * @return string
     */
    public function getMysqlTableColumnEnumValues(string $column)
    {
        $prefix = config('database.connections.'.env('DB_CONNECTION').'.prefix');

        return \DB::select(
            \DB::raw(
                "SHOW COLUMNS FROM {$prefix}{$this->tableName} WHERE Field = '$column'"
            )
        )[0]->Type;
    }

    /**
     * Obtiene el tipo de dato nativo del campo, de la base de datos a PHP para
     * mapear casting de atributos de modelos.
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
        $cast = '';

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

    public function jsDataTypeFromField(stdClass $field)
    {
        if ($field->name == 'id') {
            return 'string | number';
        }
        
        $stringTypes = [
            'varchar',
            'char',
            'text',
            'enum',
            'time',
            'date',
            'datetime',
            'timestamp'
        ];
        $intTypes = ['int', 'bigint'];
        $boolenTypes = ['tinyint', 'bool', 'boolean'];
        $dateTimeTypes = ['datetime', 'timestamp'];

        if ($field->type == "json") {
            return "{}";
        }

        if (in_array($field->type, $boolenTypes)) {
            return "boolean";
        }

        if (in_array($field->type, $stringTypes)) {
            return "string";
        }

        if (in_array($field->type, $intTypes)) {
            return "number";
        }

        /*if (in_array($field->type, $dateTimeTypes)) {
            return "Timestamps";
        }*/

        return "null";
    }

    /**
     * Configures the index file imports for components, effects, containers,
     * etc... If the file already exists, then append the convenient imports to
     * the file, if the file does not exist, then creates the file with the
     * respective imports.
     *
     * @param  string $indexFilePath The final index file location
     * @param  string $template      The index template file to create
     * @param  string $className     The class name to search for on existing index file
     * @param  string $fileName      The file name where the above class is located
     * @return void                
     */
    public function setupIndexFile(string $indexFilePath, string $template, string $className, string $fileName)
    {
        if (file_exists($indexFilePath)) {
            $indexFileContents = file_get_contents($indexFilePath);
            
            if (strpos($indexFileContents, $className)) {
                session()->push('warning', $className.' already added on index file');
            } else {
                $replace = $this->indexFileReplacements($className, $fileName);

                $content = str_replace(
                    $this->indexStrToreplace,
                    $replace,
                    $indexFileContents
                );

                file_put_contents($indexFilePath, $content) === false
                    ? session()->push('error', $className." index file setup error")
                    : session()->push('success', $className." index file setup success");
            }
            
            return;
        }

        $content = view($template, [
            'crud' => $this,
            'fields' => $this->parseFields($this->request)
        ]);

        file_put_contents($indexFilePath, $content) === false
            ? session()->push('error', "Error on index $className file setup")
            : session()->push('success', "Index $className setup success");
    }

    /**
     * Prepare the replacements for an existing index file, the result will be
     * appened to the target file.
     *
     * @param  string $className The class name to import
     * @param  string $fileName  The file name where the above class is located
     * @return string
     */
    public function indexFileReplacements(string $className, string $fileName)
    {
        $classImport = "import { $className } from '$fileName'";
        
        if (isset($this->indexClassTemplate)) {
            $className = str_replace(':class', $className, $this->indexClassTemplate);
        }

        $classUsage = $this->indexStrToreplace."\n  $className,";

        return $classImport."\n".$classUsage;
    }

    /**
     * Devuelve string con clausula para el Query Builder de Eloquent.
     *
     * @param stdClass $field
     * @param string   $value
     *
     * @return string
     */
    public function getConditionStr($field, $value = null)
    {
        $columnName = $field->name == 'id' ? 'ids' : $field->name;

        // cláusula por defecto
        $string = "'{$field->name}', \$this->input->get('{$columnName}')";

        // para búsquedas de tipo texto
        if (in_array($field->type, ['varchar', 'text'])) {
            $string = "'{$field->name}', 'like', '%'.\$this->input->get('{$columnName}').'%'";
        }

        // para búsquedas en campos de tipo enum
        if ($field->type == 'enum') {
            $string = "'{$field->name}', \$this->input->get('$columnName')";
        }

        // para búsqueda en campos de tipo boolean
        if ($field->type == 'tinyint') {
            $string = "'{$field->name}', $value";
        }

        return $string;
    }

    public function getRelatedModelDataFromfields($fields): array
    {
        $data = [];

        foreach ($fields as $field) {
            if ($field->namespace) {
                $id = Hashids::encode(1);
                $data[$this->relationNameFromField($field)]['data'] = factory($field->namespace)->make()->getAttributes() + ['id' => $id];
                $data[$field->name] = $id;
            }
        }

        return $data;
    }
}
