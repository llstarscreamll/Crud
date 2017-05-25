<?= "<?php\n" ?>

namespace {{ $gen->containerName() }}{{ $gen->solveGroupClasses() }};

use {{ $gen->containerName() }}\ApiTester;
use {{ $gen->entityModelNamespace() }};

/**
 * Create{{ $gen->entityName() }}Cest Class.
 * 
 * @author [name] <[<email address>]>
 */
class Create{{ $gen->entityName() }}Cest
{
    /**
     * @var string
     */
    private $endpoint = 'v1/{{ str_slug($gen->tableName, $separator = "-") }}/create';

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
    public function create{{ $gen->entityName() }}(ApiTester $I)
    {
        $newItem = factory({{ $gen->entityName() }}::class)->make();
        $data = $newItem->toArray();
@foreach ($fields as $field)
@if(strpos($field->validation_rules, 'confirmed') !== false)
        array_set($data, '{{ $field->name }}_confirmation', $newItem->{{ $field->name }});
@endif
@if($field->namespace && $field->fillable)
        array_set($data, '{{ $field->name }}', $I->hashKey($newItem->{{ $field->name }}));
@endif
@endforeach

        $I->sendPOST($this->endpoint, $data);

        $I->seeResponseCodeIs(200);

@foreach ($fields as $field)
@if(!$field->hidden && $field->fillable)
        $I->seeResponseContainsJson(['{{ $field->name }}' => $data['{{ $field->name }}']]);
@elseif(!$field->hidden && !$field->fillable)
        $I->seeResponseJsonMatchesXpath('{{ $field->name }}');
@endif
@endforeach

        $data = array_intersect_key($newItem->toArray(), array_flip($newItem->getFillable()));
        $I->seeRecord('{{ $gen->tableName }}', $data);
    }
}
