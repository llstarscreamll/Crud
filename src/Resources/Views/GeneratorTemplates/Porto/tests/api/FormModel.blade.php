<?= "<?php\n" ?>

namespace {{ $gen->entityName() }};

use {{ $gen->entityName() }}\ApiTester;
use {{ $gen->entityModelNamespace() }};

class {{ $gen->entityName() }}FormModelCest
{
    private $endpoint = 'api/{{ $gen->slugEntityName() }}/form-model-for-{{ $gen->slugEntityName() }}';

    /**
     * @var App\Containers\User\Models\User
     */
    private $user;

    public function _before(ApiTester $I)
    {
        $this->user = $I->loginAdminUser();
    }

    public function _after(ApiTester $I)
    {
    }

    public function tryToTestCreate{{ $gen->entityName() }}(ApiTester $I)
    {
        $I->amBearerAuthenticated($this->user->token);
        
        $I->sendGET($this->endpoint);

        $I->seeResponseCodeIs(200);
    }
}
