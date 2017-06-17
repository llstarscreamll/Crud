{{--
    ****************************************************************************
    Campos de Formulario Ocultos.
    ____________________________________________________________________________
    Aquí se muestran los campos que no están presentes en la vista de creación o
    edición como los de fecha de creación y de actualizacíón, se usan en la
    vista de detalles de un registro (show).
    ****************************************************************************

    <?= $crud->getViewCopyRightDocBlock() ?>
    
    ****************************************************************************
--}}
<?php $i = 0; foreach ($fields as $key => $field) { ?>
<?php // los campos a imprimir en esta zona son los que no están presentes en el formulario de creación ?>
<?php if (!in_array($field->name, $crud->getCreateFormFields()) && ! $field->hidden && $field->name != 'id') { ?>
<?php if ($str = $crud->getFormInputMarkup($field, $crud->table_name, $checkSkippedFields = true)) { ?>
<?=$str?>
<?php if ($i % 2 == 1) { ?>

<div class="clearfix"></div>
<?php } ?>
<?php $i++; } ?>
<?php } ?>
<?php } ?>