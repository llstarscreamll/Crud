<?= "<?php\n" ?>

namespace {{ $gen->entityName() }};

use {{ $gen->entityName() }}\ApiTester;

class Delete{{ $gen->entityName() }}Cest
{
    public function _before(ApiTester $I)
    {
    }

    public function _after(ApiTester $I)
    {
    }

    public function tryToTestDelete{{ $gen->entityName() }}(ApiTester $I)
    {
    }
}
