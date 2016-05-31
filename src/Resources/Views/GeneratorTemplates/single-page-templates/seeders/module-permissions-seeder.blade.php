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
            'name'           => '{{$gen->camelCasePlural()}}.index',
            'display_name'   => 'Listar {{$request->get('plural_entity_name')}}',
            'description'    => 'Ver en una lista todos los {{$request->get('plural_entity_name')}} del sistema',
            'created_at'     =>  $date->toDateTimeString(),
            'updated_at'     =>  $date->toDateTimeString()
        ];
            
        $data[] = [
            'name'           => '{{$gen->camelCasePlural()}}.create',
            'display_name'   => 'Crear {{$request->get('singular_entity_name')}}',
            'description'    => 'Crear nuevos {{$request->get('plural_entity_name')}}',
            'created_at'     =>  $date->toDateTimeString(),
            'updated_at'     =>  $date->toDateTimeString()
        ];
            
        $data[] = [
            'name'           => '{{$gen->camelCasePlural()}}.show',
            'display_name'   => 'Ver {{$request->get('singular_entity_name')}}',
            'description'    => 'Visalizar la información de los {{$request->get('plural_entity_name')}} (sólo lectura)',
            'created_at'     =>  $date->toDateTimeString(),
            'updated_at'     =>  $date->toDateTimeString()
        ];
            
        $data[] = [
        'name'              => '{{$gen->camelCasePlural()}}.edit',
        'display_name'      => 'Actualizar {{$request->get('singular_entity_name')}}',
        'description'       => 'Actualiza la información de los {{$request->get('plural_entity_name')}} del sistema',
        'created_at'        =>  $date->toDateTimeString(),
            'updated_at'    =>  $date->toDateTimeString()
        ];
        
        $data[] = [
            'name'           => '{{$gen->camelCasePlural()}}.destroy',
            'display_name'   => 'Eliminar {{$request->get('singular_entity_name')}}',
            'description'    => 'Eliminar {{$request->get('plural_entity_name')}} del sistema',
            'created_at'     =>  $date->toDateTimeString(),
            'updated_at'     =>  $date->toDateTimeString()
        ];

        \DB::table('permissions')->insert($data);
    }
}