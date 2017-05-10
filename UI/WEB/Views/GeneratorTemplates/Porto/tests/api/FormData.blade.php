<?= "<?php\n" ?>

namespace {{ $gen->entityName() }};

use {{ $gen->containerName() }}\ApiTester;
use {{ $gen->entityModelNamespace() }};

/**
 * {{ $gen->entityName() }}FormDataCest Class.
 * 
 * @author [name] <[<email address>]>
 */
class {{ $gen->entityName() }}FormDataCest
{
    private $endpoint = 'v1/{{ str_slug($gen->tableName, $separator = "-") }}/form-data';

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

    public function tryToGet{{ $gen->entityName() }}FormData(ApiTester $I)
    {
        $I->sendGET($this->endpoint);

        $I->seeResponseCodeIs(200);

@foreach($fields as $field)
@if($field->namespace && ($field->on_index_table || $field->on_create_form || $field->on_update_form))
        $I->seeResponseJsonMatchesXpath('{{ str_plural(class_basename($field->namespace)) }}');
@endif
@endforeach
    }
}
