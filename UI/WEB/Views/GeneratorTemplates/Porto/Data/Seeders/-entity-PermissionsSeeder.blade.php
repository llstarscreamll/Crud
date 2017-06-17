<?='<?php'?>

namespace App\Containers\{{ $crud->containerName() }}\Data\Seeders;

use App\Ship\Parents\Seeders\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

/**
 * {{ $crud->entityName() }}PermissionsSeeder Class.
 * 
 * @author [name] <[<email address>]>
 */
class {{ $crud->entityName() }}PermissionsSeeder extends Seeder
{
    public function run()
    {
        $permissions = collect([]);

        $permissions->push(Permission::create([
            'name' => '{{ $crud->slugEntityName(true) }}.list_and_search',
            'display_name' => '{{ trans('crud::templates.list_and_search') }} {{ strtolower($request->get('plural_entity_name')) }}',
        ]));
            
        $permissions->push(Permission::create([
            'name' => '{{ $crud->slugEntityName(true) }}.create',
            'display_name' => '{{ trans('crud::templates.create') }} {{ strtolower($request->get('plural_entity_name')) }}',
        ]));
            
        $permissions->push(Permission::create([
            'name' => '{{ $crud->slugEntityName(true) }}.details',
            'display_name' => '{{ trans('crud::templates.details') }} {{ strtolower($request->get('plural_entity_name')) }}',
        ]));
            
        $permissions->push(Permission::create([
            'name' => '{{ $crud->slugEntityName(true) }}.update',
            'display_name' => '{{ trans('crud::templates.edit') }} {{ strtolower($request->get('plural_entity_name')) }}',
        ]));
        
        $permissions->push(Permission::create([
            'name' => '{{ $crud->slugEntityName(true) }}.delete',
            'display_name' => '{{ trans('crud::templates.delete') }} {{ strtolower($request->get('plural_entity_name')) }}',
        ]));
@if ($crud->hasSoftDeleteColumn)
        
        $permissions->push(Permission::create([
            'name' => '{{ $crud->slugEntityName(true) }}.restore',
            'display_name' => '{{ trans('crud::templates.restore') }} {{ strtolower($request->get('plural_entity_name')) }}',
        ]));
@endif
    
    Role::where('name', 'admin')->first()->givePermissionTo($permissions);
    }
}