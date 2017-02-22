<?= "<?php\n" ?>

namespace {{ $gen->entityName() }};

use {{ $gen->entityName() }}\ApiTester;
use {{ $gen->entityModelNamespace() }};

class Create{{ $gen->entityName() }}Cest
{
    private $endpoint = 'api/{{ str_slug($gen->tableName, $separator = "-") }}/create';

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
        $data = factory({{ $gen->entityName() }}::class)->make();

        $I->haveHttpHeader('authorization', 'Bearer '.$this->user->token);

        $I->sendPOST($this->endpoint, $data);
        
        $I->seeResponseCodeIs(200);
        $I->seeResponseContainsJson($data->toArray());
    }
}
