<?= "<?php\n" ?>

namespace {{ $gen->containerName() }}{{ $gen->solveGroupClasses() }};

use {{ $gen->containerName() }}\ApiTester;
use {{ $gen->entityModelNamespace() }};

/**
 * Restore{{ $gen->entityName() }}Cest Class.
 * 
 * @author [name] <[<email address>]>
 */
class Restore{{ $gen->entityName() }}Cest
{
    /**
     * @var string
     */
	private $endpoint = 'v1/{{ str_slug($gen->tableName, $separator = "-") }}/{id}/restore';

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

@if (!$gen->groupMainApiatoClasses)
    /**
     * @group {{ $gen->entityName() }}
     */
@endif
    public function restore{{ $gen->entityName() }}(ApiTester $I)
    {
    	$item = factory({{ $gen->entityName() }}::class)->create();
    	{{ $gen->entityName() }}::destroy($item->id);

        $I->sendPOST(str_replace('{id}', $item->getHashedKey(), $this->endpoint));
        $I->seeResponseCodeIs(200);

        $restoredItem = $I->grabRecord('{{ $gen->tableName }}', ['id' => $item->id]);
        $I->assertNull($restoredItem['deleted_at']);

        $data = array_intersect_key($item->toArray(), array_flip($item->getFillable()));
        $I->seeRecord('{{ $gen->tableName }}', $data);
    }
}