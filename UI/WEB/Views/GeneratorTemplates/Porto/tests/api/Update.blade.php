<?= "<?php\n" ?>

namespace {{ $gen->entityName() }};

use {{ $gen->containerName() }}\ApiTester;
use {{ $gen->entityModelNamespace() }};
use Vinkla\Hashids\Facades\Hashids;

/**
 * Update{{ $gen->entityName() }}Cest Class.
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
        $this->initData();
        $I->haveHttpHeader('Accept', 'application/json');
    }

    public function _after(ApiTester $I)
    {
    }

    public function tryToTestUpdate{{ $gen->entityName() }}(ApiTester $I)
    {
    	$oldData = factory({{ $gen->entityName() }}::class)->create();
    	$newData = factory({{ $gen->entityName() }}::class)->make();
@foreach ($fields as $field)
@if(strpos($field->validation_rules, 'confirmed') !== false)
        $newData->{{ $field->name }}_confirmation = $newData->{{ $field->name }};
@endif
@if($field->namespace)
        $newData->{{ $field->name }} = Hashids::encode($newData->getAttributes()['{{ $field->name }}']);
@endif
@endforeach

        $I->sendPUT(str_replace('{id}', $oldData->getHashedKey(), $this->endpoint), $newData->getAttributes());

        $I->seeResponseCodeIs(200);

@foreach ($fields as $field)
@if(!$field->hidden && $field->namespace)
        $I->seeResponseContainsJson(['{{ $field->name }}' => $newData->getAttributes()['{{ $field->name }}']]);
@elseif(!$field->hidden && $field->name !== "id" && !in_array($field->type, ['timestamp', 'datetime', 'date']))
        $I->seeResponseContainsJson(['{{ $field->name }}' => $newData->{{ $field->name }}]);
@endif
@endforeach
    }
}
