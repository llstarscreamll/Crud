<?= "<?php\n" ?>

namespace {{ $gen->entityName() }};

use {{ $gen->entityName() }}\ApiTester;
use {{ $gen->entityModelNamespace() }};

class Restore{{ $gen->entityName() }}Cest
{
	private $endpoint = 'api/{{ str_slug($gen->tableName, $separator = "-") }}/{id}/restore';

    /**
     * @var App\Containers\User\Models\User
     */
    private $user;

    public function _before(ApiTester $I)
    {
    	$this->user = $I->loginAdminUser();
@foreach ($fields as $field)
@if($field->namespace)
        factory(\{{ $field->namespace }}::class, 4)->create();
@endif
@endforeach
    }

    public function _after(ApiTester $I)
    {
    }

    public function tryToTestRestore{{ $gen->entityName() }}(ApiTester $I)
    {
    	$data = factory({{ $gen->entityName() }}::class)->create();
    	{{ $gen->entityName() }}::destroy($data->id);

    	$I->amBearerAuthenticated($this->user->token);
        $I->sendPOST(str_replace('{id}', $data->id, $this->endpoint));
        $I->seeResponseCodeIs(200);
    }
}