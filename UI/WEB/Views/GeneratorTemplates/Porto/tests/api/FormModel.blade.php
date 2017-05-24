<?= "<?php\n" ?>

namespace {{ $gen->entityName() }};

use {{ $gen->containerName() }}\ApiTester;
use {{ $gen->entityModelNamespace() }};

/**
 * {{ $gen->entityName() }}FormModelCest Class.
 * 
 * @author [name] <[<email address>]>
 */
class {{ $gen->entityName() }}FormModelCest
{
/**
     * @var string
     */
    private $endpoint = 'v1/{{ $gen->slugEntityName(true) }}/form-model';

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

    public function formModelConfig{{ $gen->entityName() }}(ApiTester $I)
    {        
        $I->sendGET($this->endpoint);

        $I->seeResponseCodeIs(200);

@foreach($fields as $field)
@if($field->on_index_table || $field->on_create_form || $field->on_update_form)
        $I->seeResponseJsonMatchesXpath('{{ $field->name }}');
@endif
@endforeach
    }
}
