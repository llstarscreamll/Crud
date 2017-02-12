<?= "<?php\n" ?>

namespace {{ $gen->entityName() }};

use {{ $gen->entityName() }}\ApiTester;
use {{ $gen->entityModelNamespace() }};

class Create{{ $gen->entityName() }}Cest
{
    private $endpoint = 'api/{{ camel_case($gen->entityName()) }}/create';

    public function _before(ApiTester $I)
    {
    }

    public function _after(ApiTester $I)
    {
    }

    public function tryToTestCreate{{ $gen->entityName() }}(ApiTester $I)
    {
        $data = factory({{ $gen->entityName() }}::class)->make();

        $I->sendPOST($this->endpoint, $data);
        
        $I->seeResponseCodeIs(200);
        $I->seeResponseContainsJson($data);
    }
}
