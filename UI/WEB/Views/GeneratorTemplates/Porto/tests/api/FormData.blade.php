<?= "<?php\n" ?>

namespace {{ $gen->entityName() }};

use {{ $gen->containerName() }}\ApiTester;
use {{ $gen->entityModelNamespace() }};

/**
 * {{ $gen->entityName() }}FormDataCest Class.
 */
class {{ $gen->entityName() }}FormDataCest
{
    private $endpoint = 'v1/{{ str_slug($gen->tableName, $separator = "-") }}/form-data';

    /**
     * @var App\Containers\User\Models\User
     */
    private $user;

    public function _before(ApiTester $I)
    {
        $this->user = $I->loginAdminUser();
        $this->initData();
        $I->haveHttpHeader('Accept', 'application/json');
    }

    public function _after(ApiTester $I)
    {
    }

    public function tryToTestCreate{{ $gen->entityName() }}(ApiTester $I)
    {
        $I->sendGET($this->endpoint);

        $I->seeResponseCodeIs(200);
    }
}
