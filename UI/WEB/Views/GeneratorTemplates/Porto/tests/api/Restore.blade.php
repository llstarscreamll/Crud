<?= "<?php\n" ?>

namespace {{ $gen->entityName() }};

use {{ $gen->containerName() }}\ApiTester;
use {{ $gen->entityModelNamespace() }};

/**
 * Restore{{ $gen->entityName() }}Cest Class.
 */
class Restore{{ $gen->entityName() }}Cest
{
	private $endpoint = 'v1/{{ str_slug($gen->tableName, $separator = "-") }}/{id}/restore';

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

    public function tryToTestRestore{{ $gen->entityName() }}(ApiTester $I)
    {
    	$data = factory({{ $gen->entityName() }}::class)->create();
    	{{ $gen->entityName() }}::destroy($data->id);

        $I->sendPOST(str_replace('{id}', $data->getHashedKey(), $this->endpoint));
        $I->seeResponseCodeIs(200);
    }
}