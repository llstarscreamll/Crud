<?= "<?php\n" ?>

namespace {{ $gen->entityName() }};

use {{ $gen->containerName() }}\ApiTester;
use {{ $gen->entityModelNamespace() }};

/**
 * SelectListFrom{{ $gen->entityName() }}Cest Class.
 * 
 * @author [name] <[<email address>]>
 */
class SelectListFrom{{ $gen->entityName() }}Cest
{
    /**
     * @var string
     */
    private $endpoint = 'v1/{{ str_slug($gen->tableName, $separator = "-") }}/form/select-list';

    /**
     * @var App\Containers\User\Models\User
     */
    private $user;

    public function _before(ApiTester $I)
    {
        $this->user = $I->loginAdminUser();
        $I->init{{ $gen->entityName() }}Data();
        $I->haveHttpHeader('Accept', 'application/json');
    }

    public function _after(ApiTester $I)
    {
    }

    public function selectListFrom{{ $gen->entityName() }}(ApiTester $I)
    {
        $data = factory({{ $gen->entityName() }}::class, 5)->create();
        $I->sendGET($this->endpoint);

        $I->seeResponseCodeIs(200);

        $response = json_decode($I->grabResponse());
        $I->assertCount(5, $response);
    }
}
