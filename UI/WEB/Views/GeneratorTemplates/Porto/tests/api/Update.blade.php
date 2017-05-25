<?= "<?php\n" ?>

namespace {{ $gen->entityName() }};

use {{ $gen->containerName() }}\ApiTester;
use {{ $gen->entityModelNamespace() }};
use Vinkla\Hashids\Facades\Hashids;

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

    public function update{{ $gen->entityName() }}(ApiTester $I)
    {
    	$oldData = factory({{ $gen->entityName() }}::class)->create();
    	$newData = factory({{ $gen->entityName() }}::class)->make();
        $newDataArray = $newData->toArray();
@foreach ($fields as $field)
@if(strpos($field->validation_rules, 'confirmed') !== false)
        array_set($newDataArray, '{{ $field->name }}_confirmation', $newData->{{ $field->name }});
@endif
@if($field->namespace)
        array_set($newDataArray, '{{ $field->name }}', $I->hashKey($newData->{{ $field->name }}));
@endif
@endforeach

        $I->sendPUT(str_replace('{id}', $oldData->getHashedKey(), $this->endpoint), $newDataArray);

        $I->seeResponseCodeIs(200);

@foreach ($fields as $field)
@if($field->name == "id")
        $I->seeResponseContainsJson(['{{ $field->name }}' => $oldData->getHashedKey()]);
@elseif(!$field->hidden && $field->name !== "id")
        $I->seeResponseContainsJson(['{{ $field->name }}' => $newDataArray['{{ $field->name }}']]);
@endif
@endforeach
        
        $I->dontSeeRecord('{{ $gen->tableName }}', $oldData->toArray());
        $I->seeRecord('{{ $gen->tableName }}', $newData->toArray());
    }
}
