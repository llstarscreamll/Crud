<?= "<?php\n" ?>

namespace {{ $crud->containerName() }}{{ $crud->solveGroupClasses() }};

use {{ $crud->containerName() }}\ApiTester;
use {{ $crud->entityModelNamespace() }};

/**
 * Delete{{ $crud->entityName() }}Cest Class.
 * 
 * @author [name] <[<email address>]>
 */
class Delete{{ $crud->entityName() }}Cest
{
    /**
     * @var string
     */
	private $endpoint = 'v1/{{ str_slug($crud->tableName, $separator = "-") }}/{id}';

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
    public function delete{{ $crud->entityName() }}(ApiTester $I)
    {
    	$data = factory({{ $crud->entityName() }}::class)->create();

        $I->sendDELETE(str_replace('{id}', $data->getHashedKey(), $this->endpoint));
        $I->seeResponseCodeIs(202);

@if ($crud->hasSoftDeleteColumn)
        $deletedItem = $I->grabRecord('{{ $crud->tableName }}', ['id' => $data->id]);
        $I->assertNotNull($deletedItem['deleted_at']);
@else
        $I->dontSeeRecord('{{ $crud->tableName }}', ['id' => $data->id]);
@endif
    }
}
