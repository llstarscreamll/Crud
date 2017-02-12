<?= "<?php\n" ?>

namespace {{ $gen->entityName() }};

use {{ $gen->entityName() }}\ApiTester;

class Update{{ $gen->entityName() }}Cest
{
    public function _before(ApiTester $I)
    {
    }

    public function _after(ApiTester $I)
    {
    }

    public function tryToTestUpdate{{ $gen->entityName() }}(ApiTester $I)
    {
    }
}
