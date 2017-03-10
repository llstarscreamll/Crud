<?php
/* @var $gen App\Containers\Crud\Providers\TestsGenerator */
/* @var $fields [] */
/* @var $request Request */
?>
<?='<?php'?>


<?= $gen->getClassCopyRightDocBlock() ?>


$factory->define(<?= config('modules.crud.config.parent-app-namespace') ?>\Models\<?= $gen->modelClassName() ?>::class, function (Faker\Generator $faker) {
<?php foreach ($fields as $field) { ?>
<?php if ($field->namespace) { ?>
    <?= $gen->modelVariableNameFromClass($field->namespace, 'plural') ?> = <?= $field->namespace ?>::all('id')->pluck('id')->toArray();
<?php } ?>
<?php } ?>

    return [
<?php foreach ($fields as $key => $field) { ?>
<?php if ($field->key !== 'PRI') { ?>
        '<?= $field->name ?>' => <?= $gen->getFakeDataGenerator($field, $onlyFaker = true) ?>,
<?php } ?>
<?php } ?>
    ];
});
