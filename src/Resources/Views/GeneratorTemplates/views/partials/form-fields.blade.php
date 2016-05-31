<?php
/* @var $gen llstarscreamll\CrudGenerator\Providers\TestsGenerator */
/* @var $fields [] */
/* @var $request Request */
?>
<?php $i = 0; ?>
<?php foreach ($fields as $key => $field) { ?>
<?php if ($str = $gen->getFormInputMarkup($field, $gen->table_name)) { ?>
<?=$str?>
<?php if ($i % 2 == 1) {
?> <div class="clearfix"></div> <?php
} ?>
<?php $i++;
} ?>
<?php } ?>