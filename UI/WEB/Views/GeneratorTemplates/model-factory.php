<?php
/* @var $crud App\Containers\Crud\Providers\TestsGenerator */
/* @var $fields [] */
/* @var $request Request */
?>
<?='<?php'?>


<?= $crud->getClassCopyRightDocBlock() ?>


$factory->define(<?= config('modules.crud.config.parent-app-namespace') ?>\Models\<?= $crud->modelClassName() ?>::class, function (Faker\Generator $faker) {
<?php foreach ($fields as $field) { ?>
<?php if ($field->namespace) { ?>
    <?= $crud->modelVariableNameFromClass($field->namespace, 'plural') ?> = <?= $field->namespace ?>::all('id')->pluck('id')->toArray();
<?php } ?>
<?php } ?>

    return [
<?php foreach ($fields as $key => $field) { ?>
<?php if ($field->key !== 'PRI') { ?>
        '<?= $field->name ?>' => <?= $crud->getFakeDataGenerator($field, $onlyFaker = true) ?>,
<?php } ?>
<?php } ?>
    ];
});
