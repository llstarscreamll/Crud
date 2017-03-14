<?= "<?php\n" ?>

namespace {{ $gen->entityName() }};

use {{ $gen->containerName() }}\ApiTester;
use {{ $gen->entityModelNamespace() }};

class ListAndSearch{{ $gen->entityName() }}Cest
{
	private $endpoint = 'api/{{ str_slug($gen->tableName, $separator = "-") }}';

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

    public function tryToTestList{{ $gen->entityName() }}(ApiTester $I)
    {
    	$data = factory({{ $gen->entityName() }}::class, 10)->create();

        $I->amBearerAuthenticated($this->user->token);
        $I->sendGET($this->endpoint);

        $I->seeResponseCodeIs(200);
        $response = json_decode($I->grabResponse());
        $I->assertCount(10, $response->data);
    }
}