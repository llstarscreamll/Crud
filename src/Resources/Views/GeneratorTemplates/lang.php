<?php
/* @var $gen llstarscreamll\CrudGenerator\Providers\TestsGenerator */
/* @var $fields [] */
/* @var $test [] */
/* @var $request [] */
?>
<?='<?php'?>


<?= $gen->getClassCopyRightDocBlock() ?>


return [

    /**
     * Líneas de idioma en español para la interfaz, mensajes de validación,
     * nombres de campos de validación, mensajes de transacciones, etc...
     */
    
    // nombre del módulo
    'module' => [
        'name' => '<?= $request->get('plural_entity_name') ?>',
        'short-name' => '<?= $request->get('plural_entity_name') ?>',
        'name-singular' => '<?= $request->get('single_entity_name') ?>',
    ],

    'index-create-btn' => 'Crear <?= $request->get('single_entity_name') ?>',
    'index-create-form-modal-title' => 'Crear Nuevo <?= $request->get('single_entity_name') ?>',
    
    // nombres de los elementos del formulario
    'form-labels' => [
<?php foreach ($fields as $field) { ?>
        '<?= $field->name?>' => '<?= $gen->getFormFieldName($field->label).($gen->isTheFieldRequired($field) ? ' *' : '') ?>',
<?php if (strpos($field->validation_rules, 'confirmed')) { ?>
        '<?= $field->name?>_confirmation' => '<?= $gen->getFormFieldName("Confirmar ".$field->label).($gen->isTheFieldRequired($field) ? ' *' : '') ?>',
<?php } ?>
<?php if ($field->type == "enum") { ?>
        '<?= $field->name?>_values' => <?= $gen->getEnumValuesArrayFormField($field) ?>,
<?php } ?>
<?php } ?>
    ],

    // nombres cortos de los elementos del formulario, para la tabla del index
    'table-columns' => [
<?php foreach ($fields as $field) { ?>
<?php if (!$field->hidden) { ?>
        '<?= $field->name?>' => '<?= $gen->getFormFieldName($field->label) ?>',
<?php } ?>
<?php } ?>
    ],

    // Los nombres de los atributos de validación en Form Requests.
    'attributes' => [
<?php foreach ($fields as $field) { ?>
        '<?= $field->name ?>' => '<?= $gen->getFormFieldName($field->label) ?>',
<?php if (strpos($field->validation_rules, 'confirmed')) { ?>
        '<?= $field->name?>_confirmation' => 'Confirmar <?= $gen->getFormFieldName($field->label) ?>',
<?php } elseif ($field->type == 'date' || $field->type == 'timestamp' || $field->type == 'datetime') { ?>
        '<?= $field->name ?>[from]' => '<?= $gen->getFormFieldName($field->label) ?> inicial',
        '<?= $field->name ?>[to]' => '<?= $gen->getFormFieldName($field->label) ?> final',
<?php } elseif ($field->type == "tinyint") { ?>
        '<?= $field->name ?>_true' => '<?= $gen->getFormFieldName($field->label) ?> si',
        '<?= $field->name ?>_false' => '<?= $gen->getFormFieldName($field->label) ?> no',
<?php } ?>
<?php } ?>
    ],

    // Los mensajes personalizados de validación en Form Requests.
    'messages' => [
        'foo' => 'msg'
    ],

    // mensajes de transacciones
    'store_<?= $gen->snakeCaseSingular()?>_success' => '<?=  $gen->getStoreSuccessMsg() ?>',
    'update_<?= $gen->snakeCaseSingular()?>_success' => '<?=  $gen->getUpdateSuccessMsg() ?>',
    'destroy_<?= $gen->snakeCaseSingular()?>_success' => '<?=  $gen->getDestroySuccessMsgSingle() ?>|<?=  $gen->getDestroySuccessMsgPlural() ?>',
<?php if (($hasSoftDelete = $gen->hasDeletedAtColumn($fields))) { ?>
    'restore_<?= $gen->snakeCaseSingular()?>_success' => '<?=  $gen->getRestoreSuccessMsgSingle() ?>|<?=  $gen->getRestoreSuccessMsgPlural() ?>',

<?php } ?>
];
