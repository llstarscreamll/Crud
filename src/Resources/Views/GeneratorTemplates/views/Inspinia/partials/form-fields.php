<?php
/* @var $gen llstarscreamll\CrudGenerator\Providers\TestsGenerator */
/* @var $fields [] */
/* @var $request Request */
?>
{{--
    ****************************************************************************
    Campos de formulario.
    ____________________________________________________________________________
    Contiene los campos del formulario de creación, actualización o detalles del
    registro.
    Si se desea que sean mostrados en modo deshabilitado, pasar la variable
    $show = true cuando sea llamada esta vista, util para el caso en que sólo se
    quiera visualizar los datos sin riesgo a que se hagan cambios.
    ****************************************************************************

    <?= $gen->getCopyRightDocBlock() ?>
    
    ****************************************************************************
--}}
<?php $i = 0; ?>
<?php foreach ($fields as $key => $field) { ?>
<?php if ($str = $gen->getFormInputMarkup($field, $gen->table_name)) { ?>
<?=$str?>
<?php if ($i % 2 == 1) {
?><?="\n<div class=\"clearfix\"></div>\n"?><?php
} ?>
<?php if (strpos($field->validation_rules, 'confirmed') !== false) { $i++; ?>
<?=$gen->getFormInputConfirmationMarkup($field)?>
<?php } ?>
<?php $i++;
} ?>
<?php } ?>