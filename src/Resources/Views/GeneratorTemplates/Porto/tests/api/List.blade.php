<?= "<?php\n" ?>

namespace {{ $gen->entityName() }};

use {{ $gen->entityName() }}\ApiTester;

class List{{ $gen->entityName() }}Cest
{
    public function _before(ApiTester $I)
    {
    }

    public function _after(ApiTester $I)
    {
    }

    public function tryToTestList{{ $gen->entityName() }}(ApiTester $I)
    {
    }
}