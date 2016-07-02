<?php
/* @var $gen llstarscreamll\CrudGenerator\Providers\TestsGenerator */
/* @var $fields [] */
/* @var $test [] */
/* @var $request [] */
?>
<?='<?php'?>

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class {{$gen->modelClassName()}}PermissionsSeeder extends Seeder
{
    public function run()
    {
        $date = Carbon::now();
        $data = array();

        $data[] = [
            'name'           => '{{$gen->route()()}}.index',
            'display_name'   => 'Listar {!!$request->get('plural_entity_name')!!}',
            'description'    => 'Ver en una lista todos los {!!$request->get('plural_entity_name')!!} del sistema',
            'created_at'     =>  $date->toDateTimeString(),
            'updated_at'     =>  $date->toDateTimeString()
        ];
            
        $data[] = [
            'name'           => '{{$gen->route()()}}.create',
            'display_name'   => 'Crear {!!$request->get('single_entity_name')!!}',
            'description'    => 'Crear nuevos {!!$request->get('plural_entity_name')!!}',
            'created_at'     =>  $date->toDateTimeString(),
            'updated_at'     =>  $date->toDateTimeString()
        ];
            
        $data[] = [
            'name'           => '{{$gen->route()()}}.show',
            'display_name'   => 'Ver {!!$request->get('single_entity_name')!!}',
            'description'    => 'Visalizar la información de los {!!$request->get('plural_entity_name')!!} (sólo lectura)',
            'created_at'     =>  $date->toDateTimeString(),
            'updated_at'     =>  $date->toDateTimeString()
        ];
            
        $data[] = [
        'name'              => '{{$gen->route()()}}.edit',
        'display_name'      => 'Actualizar {!!$request->get('single_entity_name')!!}',
        'description'       => 'Actualiza la información de los {!!$request->get('plural_entity_name')!!} del sistema',
        'created_at'        =>  $date->toDateTimeString(),
            'updated_at'    =>  $date->toDateTimeString()
        ];
        
        $data[] = [
            'name'           => '{{$gen->route()()}}.destroy',
            'display_name'   => 'Eliminar {!!$request->get('single_entity_name')!!}',
            'description'    => 'Eliminar {!!$request->get('plural_entity_name')!!} del sistema',
            'created_at'     =>  $date->toDateTimeString(),
            'updated_at'     =>  $date->toDateTimeString()
        ];
<?php if ($gen->hasDeletedAtColumn($fields)) { ?>
        $data[] = [
            'name'           => '{{$gen->route()()}}.restore',
            'display_name'   => 'Restaurar {!!$request->get('single_entity_name')!!}',
            'description'    => 'Restaurar {!!$request->get('plural_entity_name')!!} que hayan sido eliminados',
            'created_at'     =>  $date->toDateTimeString(),
            'updated_at'     =>  $date->toDateTimeString()
        ];
<?php } ?>

        \DB::table('permissions')->insert($data);
    }
}