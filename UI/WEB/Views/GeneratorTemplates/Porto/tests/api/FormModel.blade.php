<?= "<?php\n" ?>

namespace {{ $crud->containerName() }}{{ $crud->solveGroupClasses() }};

use {{ $crud->containerName() }}\ApiTester;
use {{ $crud->entityModelNamespace() }};

/**
 * {{ $crud->entityName() }}FormModelCest Class.
 * 
 * @author [name] <[<email address>]>
 */
class {{ $crud->entityName() }}FormModelCest
{
/**
     * @var string
     */
    private $endpoint = 'v1/{{ $crud->slugEntityName(true) }}/form-model';

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
    public function formModelConfigFrom{{ $crud->entityName() }}(ApiTester $I)
    {        
        $I->sendGET($this->endpoint);

        $I->seeResponseCodeIs(200);

@foreach($fields as $field)
@if($field->on_index_table || $field->on_create_form || $field->on_update_form)
        $I->seeResponseContainsJson([['name' => '{{ $field->name }}']]);
@endif
@endforeach
    }
}
