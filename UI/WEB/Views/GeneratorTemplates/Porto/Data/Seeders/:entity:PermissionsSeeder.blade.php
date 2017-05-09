<?='<?php'?>

namespace App\Containers\{{ $gen->containerName() }}\Data\Seeders;

use App\Ship\Parents\Seeders\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

/**
 * {{ $gen->entityName() }}PermissionsSeeder Class.
 * 
 * @author [name] <[<email address>]>
 */
class {{ $gen->entityName() }}PermissionsSeeder extends Seeder
{
    public function run()
    {
        $permissions = collect([]);

        $permissions->push(Permission::create([
            'name' => '{{ $gen->slugEntityName() }}.list_and_search',
            'display_name' => '{{ trans('crud::templates.list_and_search') }} {{ strtolower($request->get('plural_entity_name')) }}',
        ]));
            
        $permissions->push(Permission::create([
            'name' => '{{ $gen->slugEntityName() }}.create',
            'display_name' => '{{ trans('crud::templates.create') }} {{ strtolower($request->get('single_entity_name')) }}',
        ]));
            
        $permissions->push(Permission::create([
            'name' => '{{ $gen->slugEntityName() }}.details',
            'display_name' => '{{ trans('crud::templates.details') }} {{ strtolower($request->get('single_entity_name')) }}',
        ]));
            
        $permissions->push(Permission::create([
            'name' => '{{ $gen->slugEntityName() }}.update',
            'display_name' => '{{ trans('crud::templates.edit') }} {{ strtolower($request->get('single_entity_name')) }}',
        ]));
        
        $permissions->push(Permission::create([
            'name' => '{{ $gen->slugEntityName() }}.delete',
            'display_name' => '{{ trans('crud::templates.delete') }} {{ strtolower($request->get('single_entity_name')) }}',
        ]));
@if ($gen->hasSoftDeleteColumn)
        
        $permissions->push(Permission::create([
            'name' => '{{ $gen->slugEntityName() }}.restore',
            'display_name' => '{{ trans('crud::templates.restore') }} {{ strtolower($request->get('single_entity_name')) }}',
        ]));
@endif
    
    Role::where('name', 'admin')->first()->givePermissionTo($permissions);
    }
}