<?php

namespace Library\Helper;

use App\Containers\Reason\Models\Reason;
use App\Containers\User\Models\User;
use App\Containers\Library\Data\Seeders\BookPermissionsSeeder;
use Illuminate\Support\Facades\Artisan;

/**
 * LibraryHelper Class.
 * 
 * @author  [name] <[<email address>]>
 */
class LibraryHelper extends \Codeception\Module
{
    /**
     * Init the Book data dependencies.
     *
     * @return  void
     */
    public function initBookData()
    {
        Artisan::call('db:seed', ['--class' => BookPermissionsSeeder::class]);
        factory(Reason::class, 3)->create();
        factory(User::class, 3)->create();
    }

}
