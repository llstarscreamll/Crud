<?= "<?php\n" ?>

namespace {{ $crud->containerName() }}{{ $crud->solveGroupClasses() }};

use {{ $crud->containerName() }}\ApiTester;
use {{ $crud->entityModelNamespace() }};

/**
 * Update{{ $crud->entityName() }}Cest Class.
 * 
 * @author [name] <[<email address>]>
 */
class Update{{ $crud->entityName() }}Cest
{
	private $endpoint = 'v1/{{ str_slug($crud->tableName, $separator = "-") }}/{id}';

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
    public function update{{ $crud->entityName() }}(ApiTester $I)
    {
    	$oldItem = factory({{ $crud->entityName() }}::class)->create();
    	$newItem = factory({{ $crud->entityName() }}::class)->make();
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
        
        $I->dontSeeRecord('{{ $crud->tableName }}', $oldItem->toArray());
        $data = array_intersect_key($newItem->toArray(), array_flip($newItem->getFillable()));
        $I->seeRecord('{{ $crud->tableName }}', $data);
    }
}
