<?= "<?php\n" ?>

namespace {{ $gen->entityName() }};

use {{ $gen->containerName() }}\ApiTester;
use {{ $gen->entityModelNamespace() }};

/**
 * Delete{{ $gen->entityName() }}Cest Class.
 */
class Delete{{ $gen->entityName() }}Cest
{
	private $endpoint = 'v1/{{ str_slug($gen->tableName, $separator = "-") }}/{id}';

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

    public function tryToTestDelete{{ $gen->entityName() }}(ApiTester $I)
    {
    	$data = factory({{ $gen->entityName() }}::class)->create();

        $I->sendDELETE(str_replace('{id}', $data->getHashedKey(), $this->endpoint));
        $I->seeResponseCodeIs(202);
    }
}
