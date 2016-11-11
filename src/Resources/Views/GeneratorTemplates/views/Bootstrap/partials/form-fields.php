<?php
/* @var $gen llstarscreamll\Crud\Providers\TestsGenerator */
/* @var $fields [] */
/* @var $request Request */
?>
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