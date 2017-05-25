<?= "<?php\n" ?>

namespace {{ $gen->containerName() }}{{ $gen->solveGroupClasses() }};

use {{ $gen->containerName() }}\ApiTester;
use {{ $gen->entityModelNamespace() }};

/**
 * Update{{ $gen->entityName() }}Cest Class.
 * 
 * @author [name] <[<email address>]>
 */
class Update{{ $gen->entityName() }}Cest
{
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
    public function update{{ $gen->entityName() }}(ApiTester $I)
    {
    	$oldItem = factory({{ $gen->entityName() }}::class)->create();
    	$newItem = factory({{ $gen->entityName() }}::class)->make();
        $data = $newItem->toArray();
@foreach ($fields as $field)
@if(strpos($field->validation_rules, 'confirmed') !== false)
        array_set($data, '{{ $field->name }}_confirmation', $newItem->{{ $field->name }});
@endif
@if($field->namespace)
        array_set($data, '{{ $field->name }}', $I->hashKey($newItem->{{ $field->name }}));
@endif
@endforeach

        $I->sendPUT(str_replace('{id}', $oldItem->getHashedKey(), $this->endpoint), $data);

        $I->seeResponseCodeIs(200);

@foreach ($fields as $field)
@if($field->name == "id")
        $I->seeResponseContainsJson(['{{ $field->name }}' => $oldItem->getHashedKey()]);
@elseif(!$field->hidden && $field->fillable)
        $I->seeResponseContainsJson(['{{ $field->name }}' => $data['{{ $field->name }}']]);
@elseif(!$field->hidden && !$field->fillable)
        $I->seeResponseJsonMatchesXpath('{{ $field->name }}');
@endif
@endforeach
        
        $I->dontSeeRecord('{{ $gen->tableName }}', $oldItem->toArray());
        $data = array_intersect_key($newItem->toArray(), array_flip($newItem->getFillable()));
        $I->seeRecord('{{ $gen->tableName }}', $data);
    }
}
