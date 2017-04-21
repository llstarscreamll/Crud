<?= "<?php\n" ?>

namespace {{ $gen->containerName() }}\Helper;

use App\Containers\User\Models\User as UserModel;
use Spatie\Permission\Models\Role;
use App\Containers\Authentication\Tasks\ApiLoginThisUserObjectTask;

/**
 * UserHelper Class.
 */
class UserHelper extends \Codeception\Module
{
    /**
     * Create and log in the admin user.
     *
     * @return App\Containers\User\Models\User
     */
    public function loginAdminUser()
    {
        $user = $this->createAdminUser();
        return $this->loginUser($user);
    }

    /**
     * Log in the given user.
     *
     * @param  UserModel $user
     * @return App\Containers\User\Models\User
     */
    public function loginUser(UserModel $user)
    {
        $driver = 'api';
        app('auth')->guard($driver)->setUser($user);
        app('auth')->shouldUse($driver);
        
        return $user;
    }

    /**
     * Create the admin user.
     *
     * @return App\Containers\User\Models\User
     */
    public function createAdminUser()
    {
        $role = Role::create(['name' => 'admin']);
        $user = UserModel::create([
            'name' => 'Admin',
            'email' => 'admin@admin.com',
            'password' => bcrypt('admin'),
        ]);
        $user->assignRole($role);

        return $user->fresh();
    }
}
