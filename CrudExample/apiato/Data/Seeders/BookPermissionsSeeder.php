<?php
namespace App\Containers\Library\Data\Seeders;

use App\Ship\Parents\Seeders\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

/**
 * BookPermissionsSeeder Class.
 * 
 * @author  [name] <[<email address>]>
 */
class BookPermissionsSeeder extends Seeder
{
    public function run()
    {
        $permissions = collect([]);

        $permissions->push(Permission::create([
            'name' => 'book.list_and_search',
            'display_name' => 'List and search libros',
        ]));
            
        $permissions->push(Permission::create([
            'name' => 'book.create',
            'display_name' => 'Create libro',
        ]));
            
        $permissions->push(Permission::create([
            'name' => 'book.details',
            'display_name' => 'Details libro',
        ]));
            
        $permissions->push(Permission::create([
            'name' => 'book.update',
            'display_name' => 'Edit libro',
        ]));
        
        $permissions->push(Permission::create([
            'name' => 'book.delete',
            'display_name' => 'Delete libro',
        ]));
        
        $permissions->push(Permission::create([
            'name' => 'book.restore',
            'display_name' => 'Restore libro',
        ]));
    
    Role::where('name', 'admin')->first()->givePermissionTo($permissions);
    }
}