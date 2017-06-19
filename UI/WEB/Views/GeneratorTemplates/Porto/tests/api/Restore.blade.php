<?= "<?php\n" ?>

namespace {{ $crud->containerName() }}{{ $crud->solveGroupClasses() }};

use {{ $crud->containerName() }}\ApiTester;
use {{ $crud->entityModelNamespace() }};

/**
 * Restore{{ $crud->entityName() }}Cest Class.
 * 
 * @author [name] <[<email address>]>
 */
class Restore{{ $crud->entityName() }}Cest
{
    /**
     * @var string
     */
	private $endpoint = 'v1/{{ str_slug($crud->tableName, $separator = "-") }}/{id}/restore';

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
    public function restore{{ $crud->entityName() }}(ApiTester $I)
    {
    	$item = factory({{ $crud->entityName() }}::class)->create();
    	{{ $crud->entityName() }}::destroy($item->id);

        $I->sendPOST(str_replace('{id}', $item->getHashedKey(), $this->endpoint));
        $I->seeResponseCodeIs(200);

        $restoredItem = $I->grabRecord('{{ $crud->tableName }}', ['id' => $item->id]);
        $I->assertNull($restoredItem['deleted_at']);

        $data = array_intersect_key($item->toArray(), array_flip($item->getFillable()));
        $I->seeRecord('{{ $crud->tableName }}', $data);
    }
}