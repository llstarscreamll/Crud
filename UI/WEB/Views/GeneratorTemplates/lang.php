<?php
/* @var $crud App\Containers\Crud\Providers\TestsGenerator */
/* @var $fields [] */
/* @var $test [] */
/* @var $request [] */
?>
<?='<?php'?>


<?= $crud->getClassCopyRightDocBlock() ?>


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
        '<?= $field->name?>' => '<?= $crud->getFormFieldName($field->label).($crud->isTheFieldRequired($field) ? ' *' : '') ?>',
<?php if (strpos($field->validation_rules, 'confirmed')) { ?>
        '<?= $field->name?>_confirmation' => '<?= $crud->getFormFieldName("Confirmar ".$field->label).($crud->isTheFieldRequired($field) ? ' *' : '') ?>',
<?php } ?>
<?php if ($field->type == "enum") { ?>
        '<?= $field->name?>_values' => <?= $crud->getEnumValuesArrayFormField($field) ?>,
<?php } ?>
<?php } ?>
    ],

    // nombres cortos de los elementos del formulario, para la tabla del index
    'table-columns' => [
<?php foreach ($fields as $field) { ?>
<?php if (!$field->hidden) { ?>
        '<?= $field->name?>' => '<?= $crud->getFormFieldName($field->label) ?>',
<?php } ?>
<?php } ?>
    ],

    // Los nombres de los atributos de validación en Form Requests.
    'attributes' => [
<?php foreach ($fields as $field) { ?>
        '<?= $field->name ?>' => '<?= $crud->getFormFieldName($field->label) ?>',
<?php if (strpos($field->validation_rules, 'confirmed')) { ?>
        '<?= $field->name?>_confirmation' => 'Confirmar <?= $crud->getFormFieldName($field->label) ?>',
<?php } elseif ($field->type == 'date' || $field->type == 'timestamp' || $field->type == 'datetime') { ?>
        '<?= $field->name ?>[from]' => '<?= $crud->getFormFieldName($field->label) ?> inicial',
        '<?= $field->name ?>[to]' => '<?= $crud->getFormFieldName($field->label) ?> final',
<?php } elseif ($field->type == "tinyint") { ?>
        '<?= $field->name ?>_true' => '<?= $crud->getFormFieldName($field->label) ?> si',
        '<?= $field->name ?>_false' => '<?= $crud->getFormFieldName($field->label) ?> no',
<?php } ?>
<?php } ?>
    ],

    // Los mensajes personalizados de validación en Form Requests.
    'messages' => [
        'foo' => 'msg'
    ],

    // mensajes de transacciones
    'store_<?= $crud->snakeCaseSingular()?>_success' => '<?=  $crud->getStoreSuccessMsg() ?>',
    'update_<?= $crud->snakeCaseSingular()?>_success' => '<?=  $crud->getUpdateSuccessMsg() ?>',
    'destroy_<?= $crud->snakeCaseSingular()?>_success' => '<?=  $crud->getDestroySuccessMsgSingle() ?>|<?=  $crud->getDestroySuccessMsgPlural() ?>',
<?php if (($hasSoftDelete = $crud->hasDeletedAtColumn($fields))) { ?>
    'restore_<?= $crud->snakeCaseSingular()?>_success' => '<?=  $crud->getRestoreSuccessMsgSingle() ?>|<?=  $crud->getRestoreSuccessMsgPlural() ?>',

<?php } ?>
];
