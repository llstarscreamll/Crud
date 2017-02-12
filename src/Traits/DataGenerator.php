<?php

namespace llstarscreamll\Crud\Traits;

/**
 * DataGenerator Trait.
 */
trait DataGenerator
{
    public function parseFields($request)
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
            if ($field->name == 'deleted_at' && empty($field_data['testData'])) {
                $field->testData = 'null';
            }
            $field->testDataUpdate = empty($field_data['testDataUpdate']) ? '""' : $field_data['testDataUpdate'];
            if ($field->name == 'deleted_at' && empty($field_data['testDataUpdate'])) {
                $field->testDataUpdate = 'null';
            }
            $field->validation_rules = $field_data['validation_rules'];

            $fields[$field->name] = $field;
        }

        $this->fields = $fields;

        return $fields;
    }

    public function getFakeData($field, bool $onlyFaker = false)
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
}
