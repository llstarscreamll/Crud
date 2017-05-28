<?php

namespace Library\Helper;

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
        // more stuff here
    }

}
