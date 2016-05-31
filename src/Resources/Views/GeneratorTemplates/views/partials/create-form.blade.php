<?php
/* @var $gen \Nvd\Crud\Commands\Crud */
/* @var $fields [] */
?>
<?php $i = 0; ?>
<?php foreach ($fields as $key => $field) {
    ?>
<?php if ($str = $gen->getFormInputMarkup($field, $gen->table_name)) {
    ?>

<?=$str?>
<?php
if ($i % 2 == 0) {
    ?>
<div class="clearfix"></div>
<?php
}
    ?>
<?php
}
    ?>
<?php $i++;
} ?>