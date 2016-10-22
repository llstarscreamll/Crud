<?php
/* @var $gen llstarscreamll\CrudGenerator\Providers\TestsGenerator */
/* @var $fields [] */
/* @var $test [] */
/* @var $request [] */
?>
<?='<?php'?>


<?= $gen->getClassCopyRightDocBlock() ?>


use Carbon\Carbon;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;

class {{$gen->studlyCasePlural()}}TableSeeder extends Seeder
{
    public function run()
    {
        $data = array();
        $date = Carbon::now();
        $faker = Faker::create();

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