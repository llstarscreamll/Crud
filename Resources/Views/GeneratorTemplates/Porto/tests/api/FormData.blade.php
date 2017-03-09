<?= "<?php\n" ?>

namespace {{ $gen->entityName() }};

use {{ $gen->entityName() }}\ApiTester;
use {{ $gen->entityModelNamespace() }};

class {{ $gen->entityName() }}FormDataCest
{
    private $endpoint = 'api/{{ str_slug($gen->tableName, $separator = "-") }}/form-data/{{ $gen->slugEntityName() }}';

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

    public function tryToTestCreate{{ $gen->entityName() }}(ApiTester $I)
    {
        $I->amBearerAuthenticated($this->user->token);
        $I->sendGET($this->endpoint);

        $I->seeResponseCodeIs(200);
    }
}
