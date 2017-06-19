<?= "<?php\n" ?>

namespace {{ $crud->containerName() }}{{ $crud->solveGroupClasses() }};

use {{ $crud->containerName() }}\ApiTester;
use {{ $crud->entityModelNamespace() }};

/**
 * SelectListFrom{{ $crud->entityName() }}Cest Class.
 * 
 * @author [name] <[<email address>]>
 */
class SelectListFrom{{ $crud->entityName() }}Cest
{
    /**
     * @var string
     */
    private $endpoint = 'v1/{{ str_slug($crud->tableName, $separator = "-") }}/form/select-list';

    /**
     * @var App\Containers\User\Models\User
     */
    private $user;

    public function _before(ApiTester $I)
    {
        $this->user = $I->loginAdminUser();
        $I->init{{ $crud->entityName() }}Data();
        $I->haveHttpHeader('Accept', 'application/json');
    }

    public function _after(ApiTester $I)
    {
    }

@if (!$crud->groupMainApiatoClasses)
    /**
     * @group {{ $crud->entityName() }}
     */
@endif
    public function selectListFrom{{ $crud->entityName() }}(ApiTester $I)
    {
        $data = factory({{ $crud->entityName() }}::class, 5)->create();
        $I->sendGET($this->endpoint);

        $I->seeResponseCodeIs(200);

        $response = json_decode($I->grabResponse());
        $I->assertCount(5, $response);
    }
}
