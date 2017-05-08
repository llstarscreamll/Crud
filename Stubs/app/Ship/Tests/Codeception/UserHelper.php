<?php

namespace App\Ship\Tests\Codeception;

use App\Containers\User\Models\User as UserModel;
use Spatie\Permission\Models\Role;
use App\Containers\Authentication\Tasks\ApiLoginThisUserObjectTask;

/**
 * UserHelper Class.
 *
 * @author Johan Alvarez <llstarscreamll@hotmail.com>
 */
class UserHelper extends \Codeception\Module
{
    /**
     * Create and log in the admin user.
     *
     * @return App\Containers\User\Models\User
     */
    public function loginAdminUser(string $driver = 'api')
    {
        $user = UserModel::firstOrcreate([
            'name' => 'admin',
            'email' => 'admin@admin.com',
            'password' => bcrypt('admin')
        ])->assignRole($this->createAdminRole());

        return $this->loginUser($user, $driver);
    }

    public function createAdminRole()
    {
        return Role::create([
            'name' => 'admin',
            'display_name' => 'Admin',
        ]);
    }

    /**
     * Log in the given user.
     *
     * @param  UserModel $user
     * @return App\Containers\User\Models\User
     */
    public function loginUser(UserModel $user, string $driver = 'api')
    {
        app('auth')->guard($driver)->setUser($user);
        app('auth')->shouldUse($driver);
        
        return $user;
    }
}
