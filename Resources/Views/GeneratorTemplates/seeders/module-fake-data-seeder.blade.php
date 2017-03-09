<?php
/* @var $gen llstarscreamll\Crud\Providers\TestsGenerator */
/* @var $fields [] */
/* @var $test [] */
/* @var $request [] */
?>
<?='<?php'?>


<?= $gen->getClassCopyRightDocBlock() ?>


use Carbon\Carbon;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;

/**
 * Clase <?= $gen->studlyCasePlural() ?>TableSeeder
 *
 * @author <?= config('modules.crud.config.author') ?> <<?= config('modules.crud.config.author_email') ?>>
 */
class <?= $gen->studlyCasePlural() ?>TableSeeder extends Seeder
{
    public function run()
    {
        $data = array();
        $date = Carbon::now();
        $faker = Faker::create();

<?php foreach ($fields as $field) { ?>
<?php if ($field->namespace) { ?>
        <?= $gen->modelVariableNameFromClass($field->namespace, 'plural') ?> = <?= $field->namespace ?>::all('id')->pluck('id')->toArray();
<?php } ?>
<?php } ?>

        for ($i=0; $i < 10; $i++) { 
            $data[] = [
<?php foreach ($fields as $key => $field) { ?>
<?php if ($field->key !== 'PRI') { ?>
                '<?= $field->name ?>' => <?= $gen->getFakeDataGenerator($field) ?>,
<?php } ?>
<?php } ?>
            ];
        }

        \DB::table('<?= $gen->table_name ?>')->insert($data);
    }
}