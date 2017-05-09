<?php

namespace App\Ship\Tests\Codeception;

use Vinkla\Hashids\Facades\Hashids;

/**
 * HashidsHelper Class.
 *
 * @author Johan Alvarez <llstarscreamll@hotmail.com>
 */
class HashidsHelper extends \Codeception\Module
{
    /**
     * Use Hashids to encode ids if config('apiato.hash-id') == true.
     *
     * @return int|string
     */
    public function hashKey(int $id)
    {
        if (config('apiato.hash-id')) {
            return Hashids::encode($id);
        }

        return $id;
    }
}
