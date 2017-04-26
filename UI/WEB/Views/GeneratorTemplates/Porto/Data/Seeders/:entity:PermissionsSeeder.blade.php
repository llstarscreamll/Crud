<?='<?php'?>

namespace App\Containers\{{ $gen->containerName() }}\Data\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

/**
 * {{ $gen->entityName() }}PermissionsSeeder Class.
 */
class {{ $gen->entityName() }}PermissionsSeeder extends Seeder
{
    public function run()
    {
        $permissions = collect([]);

        $permissions->push(Permission::create([
            'name' => '{{ $gen->slugEntityName() }}.index',
            'display_name' => 'Listar {{ $request->get('plural_entity_name') }}',
        ]));
            
        $permissions->push(Permission::create([
            'name' => '{{ $gen->slugEntityName() }}.create',
            'display_name' => 'Crear {{ $request->get('single_entity_name') }}',
        ]));
            
        $permissions->push(Permission::create([
            'name' => '{{ $gen->slugEntityName() }}.show',
            'display_name' => 'Ver {{ $request->get('single_entity_name') }}',
        ]));
            
        $permissions->push(Permission::create([
            'name' => '{{ $gen->slugEntityName() }}.edit',
            'display_name' => 'Actualizar {{ $request->get('single_entity_name') }}',
        ]));
        
        $permissions->push(Permission::create([
            'name' => '{{ $gen->slugEntityName() }}.destroy',
            'display_name' => 'Eliminar {{ $request->get('single_entity_name') }}',
        ]));
@if ($gen->hasSoftDeleteColumn)
        
        $permissions->push(Permission::create([
            'name' => '{{ $gen->slugEntityName() }}.restore',
            'display_name' => 'Restaurar {{ $request->get('single_entity_name') }}',
        ]));
@endif
    
    Role::where('name', 'admin')->first()->givePermissionTo($permissions);
    }
}