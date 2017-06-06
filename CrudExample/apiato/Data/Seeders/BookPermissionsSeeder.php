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
            'name' => 'books.list_and_search',
            'display_name' => 'List and search libros',
        ]));
            
        $permissions->push(Permission::create([
            'name' => 'books.create',
            'display_name' => 'Create libros',
        ]));
            
        $permissions->push(Permission::create([
            'name' => 'books.details',
            'display_name' => 'Details libros',
        ]));
            
        $permissions->push(Permission::create([
            'name' => 'books.update',
            'display_name' => 'Edit libros',
        ]));
        
        $permissions->push(Permission::create([
            'name' => 'books.delete',
            'display_name' => 'Delete libros',
        ]));
        
        $permissions->push(Permission::create([
            'name' => 'books.restore',
            'display_name' => 'Restore libros',
        ]));
    
    Role::where('name', 'admin')->first()->givePermissionTo($permissions);
    }
}