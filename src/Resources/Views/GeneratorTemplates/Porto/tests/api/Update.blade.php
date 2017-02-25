<?= "<?php\n" ?>

namespace {{ $gen->entityName() }};

use {{ $gen->entityName() }}\ApiTester;
use {{ $gen->entityModelNamespace() }};

class Update{{ $gen->entityName() }}Cest
{
	private $endpoint = 'api/{{ str_slug($gen->tableName, $separator = "-") }}/{id}';

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

    public function tryToTestUpdate{{ $gen->entityName() }}(ApiTester $I)
    {
    	$oldData = factory({{ $gen->entityName() }}::class)->create();
    	$newData = factory({{ $gen->entityName() }}::class)->make();
@foreach ($fields as $field)
@if(strpos($field->validation_rules, 'confirmed') !== false)
        $newData->{{ $field->name }}_confirmation = $newData->{{ $field->name }};
@endif
@endforeach

    	$I->amBearerAuthenticated($this->user->token);
        $I->sendPUT(str_replace('{id}', $oldData->getHashedKey(), $this->endpoint), $newData->getAttributes());

        $I->seeResponseCodeIs(200);

@foreach ($fields as $field)
@if(!$field->hidden && $field->name !== "id" && !in_array($field->type, ['timestamp', 'datetime', 'date']))
        $I->seeResponseContainsJson(['{{ $field->name }}' => $newData->{{ $field->name }}]);
@endif
@endforeach
    }
}
