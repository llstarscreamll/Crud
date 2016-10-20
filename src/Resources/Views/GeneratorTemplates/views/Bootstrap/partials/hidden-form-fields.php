{{--
	Aquí se muestran los campos que no están presentes en la vista de creación o edición,
	pero que son útiles para la vista de detalles de un registro (show) como fecha de
	creación, fecha de actualización y demás campos de control...
--}}

<?php $i = 0; foreach ($fields as $key => $field) { ?>
<?php // los campos a imprimir en esta zona son los que no están presentes en el formulario de creación ?>
<?php if (!in_array($field->name, $gen->getCreateFormFields()) && ! $field->hidden && $field->name != 'id') { ?>
<?php if ($str = $gen->getFormInputMarkup($field, $gen->table_name, $checkSkippedFields = true)) { ?>
<?=$str?>
<?php if ($i % 2 == 1) { ?>

<div class="clearfix"></div>
<?php } ?>
<?php $i++; } ?>
<?php } ?>
<?php } ?>