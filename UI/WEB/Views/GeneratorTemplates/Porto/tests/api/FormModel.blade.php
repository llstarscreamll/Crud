<?= "<?php\n" ?>

namespace {{ $gen->entityName() }};

use {{ $gen->containerName() }}\ApiTester;
use {{ $gen->entityModelNamespace() }};

/**
 * {{ $gen->entityName() }}FormModelCest Class.
 */
class {{ $gen->entityName() }}FormModelCest
{
    private $endpoint = 'v1/{{ $gen->slugEntityName(true) }}/form-model';

    /**
     * @var App\Containers\User\Models\User
     */
    private $user;

    public function _before(ApiTester $I)
    {
        $this->user = $I->loginAdminUser();
        $I->initData();
        $I->haveHttpHeader('Accept', 'application/json');
    }

    public function _after(ApiTester $I)
    {
    }

    public function tryToRequestFormModelConfig{{ $gen->entityName() }}(ApiTester $I)
    {        
        $I->sendGET($this->endpoint);

        $I->seeResponseCodeIs(200);
    }
}
