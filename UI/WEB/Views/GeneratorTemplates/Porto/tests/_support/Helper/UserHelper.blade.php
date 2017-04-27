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
    public function loginAdminUser(string $driver = 'api')
    {
        $user = UserModel::where('email', 'admin@admin.com')->first();
        return $this->loginUser($user, $driver);
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
