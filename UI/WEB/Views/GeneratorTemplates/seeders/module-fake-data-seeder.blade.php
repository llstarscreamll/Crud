<?php
/* @var $crud App\Containers\Crud\Providers\TestsGenerator */
/* @var $fields [] */
/* @var $test [] */
/* @var $request [] */
?>
<?='<?php'?>


<?= $crud->getClassCopyRightDocBlock() ?>


use Carbon\Carbon;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;

/**
 * Clase <?= $crud->studlyCasePlural() ?>TableSeeder
 *
 * @author <?= config('modules.crud.config.author') ?> <<?= config('modules.crud.config.author_email') ?>>
 */
class <?= $crud->studlyCasePlural() ?>TableSeeder extends Seeder
{
    public function run()
    {
        $data = array();
        $date = Carbon::now();
        $faker = Faker::create();

<?php foreach ($fields as $field) { ?>
<?php if ($field->namespace) { ?>
        <?= $crud->modelVariableNameFromClass($field->namespace, 'plural') ?> = <?= $field->namespace ?>::all('id')->pluck('id')->toArray();
<?php } ?>
<?php } ?>

        for ($i=0; $i < 10; $i++) { 
            $data[] = [
<?php foreach ($fields as $key => $field) { ?>
<?php if ($field->key !== 'PRI') { ?>
                '<?= $field->name ?>' => <?= $crud->getFakeDataGenerator($field) ?>,
<?php } ?>
<?php } ?>
            ];
        }

        \DB::table('<?= $crud->table_name ?>')->insert($data);
    }
}