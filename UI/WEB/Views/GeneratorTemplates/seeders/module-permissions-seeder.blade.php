<?php
/* @var $gen App\Containers\Crud\Providers\TestsGenerator */
/* @var $fields [] */
/* @var $test [] */
/* @var $request [] */
?>
<?='<?php'?>


<?= $gen->getClassCopyRightDocBlock() ?>


use Carbon\Carbon;
use Illuminate\Database\Seeder;

/**
 * Clase <?= $gen->modelClassName() ?>PermissionsSeeder
 *
 * @author <?= config('modules.crud.config.author') ?> <<?= config('modules.crud.config.author_email') ?>>
 */
class <?= $gen->modelClassName() ?>PermissionsSeeder extends Seeder
{
    public function run()
    {
        $date = Carbon::now();
        $data = array();

        $data[] = [
            '<?= config('modules.crud.config.permission-slug-field-name') ?>' => '<?= $gen->route() ?>.index',
            '<?= config('modules.crud.config.permission-name-field-name') ?>' => 'Listar <?= $request->get('plural_entity_name') ?>',
            'description' => 'Ver en una lista todos los <?= $request->get('plural_entity_name') ?> del sistema',
            'created_at' => $date->toDateTimeString(),
            'updated_at' => $date->toDateTimeString()
        ];
            
        $data[] = [
            '<?= config('modules.crud.config.permission-slug-field-name') ?>' => '<?= $gen->route() ?>.create',
            '<?= config('modules.crud.config.permission-name-field-name') ?>' => 'Crear <?= $request->get('single_entity_name') ?>',
            'description' => 'Crear nuevos <?= $request->get('plural_entity_name') ?>',
            'created_at' => $date->toDateTimeString(),
            'updated_at' => $date->toDateTimeString()
        ];
            
        $data[] = [
            '<?= config('modules.crud.config.permission-slug-field-name') ?>' => '<?= $gen->route() ?>.show',
            '<?= config('modules.crud.config.permission-name-field-name') ?>' => 'Ver <?= $request->get('single_entity_name') ?>',
            'description' => 'Visalizar la información de los <?= $request->get('plural_entity_name') ?> (sólo lectura)',
            'created_at' => $date->toDateTimeString(),
            'updated_at' => $date->toDateTimeString()
        ];
            
        $data[] = [
            '<?= config('modules.crud.config.permission-slug-field-name') ?>' => '<?= $gen->route() ?>.edit',
            '<?= config('modules.crud.config.permission-name-field-name') ?>' => 'Actualizar <?= $request->get('single_entity_name') ?>',
            'description' => 'Actualiza la información de los <?= $request->get('plural_entity_name') ?> del sistema',
            'created_at' => $date->toDateTimeString(),
            'updated_at' => $date->toDateTimeString()
        ];
        
        $data[] = [
            '<?= config('modules.crud.config.permission-slug-field-name') ?>' => '<?= $gen->route() ?>.destroy',
            '<?= config('modules.crud.config.permission-name-field-name') ?>' => 'Eliminar <?= $request->get('single_entity_name') ?>',
            'description' => 'Eliminar <?= $request->get('plural_entity_name') ?> del sistema',
            'created_at' => $date->toDateTimeString(),
            'updated_at' => $date->toDateTimeString()
        ];

<?php if ($gen->hasDeletedAtColumn($fields)) { ?>
        $data[] = [
            '<?= config('modules.crud.config.permission-slug-field-name') ?>' => '<?= $gen->route() ?>.restore',
            '<?= config('modules.crud.config.permission-name-field-name') ?>' => 'Restaurar <?= $request->get('single_entity_name') ?>',
            'description' => 'Restaurar <?= $request->get('plural_entity_name') ?> que hayan sido eliminados',
            'created_at' => $date->toDateTimeString(),
            'updated_at' => $date->toDateTimeString()
        ];
<?php } ?>

        \DB::table('permissions')->insert($data);

        $this->call(AttachPermissionsToAdminRoleSeeder::class);
    }
}