<?= "<?php\n" ?>

namespace {{ $gen->containerName() }}{{ $gen->solveGroupClasses() }};

use {{ $gen->containerName() }}\ApiTester;
use {{ $gen->entityModelNamespace() }};

/**
 * Delete{{ $gen->entityName() }}Cest Class.
 * 
 * @author [name] <[<email address>]>
 */
class Delete{{ $gen->entityName() }}Cest
{
    /**
     * @var string
     */
	private $endpoint = 'v1/{{ str_slug($gen->tableName, $separator = "-") }}/{id}';

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
    public function delete{{ $gen->entityName() }}(ApiTester $I)
    {
    	$data = factory({{ $gen->entityName() }}::class)->create();

        $I->sendDELETE(str_replace('{id}', $data->getHashedKey(), $this->endpoint));
        $I->seeResponseCodeIs(202);

@if ($gen->hasSoftDeleteColumn)
        $deletedItem = $I->grabRecord('{{ $gen->tableName }}', ['id' => $data->id]);
        $I->assertNotNull($deletedItem['deleted_at']);
@else
        $I->dontSeeRecord('{{ $gen->tableName }}', ['id' => $data->id]);
@endif
    }
}
