<?= "<?php\n" ?>

namespace {{ $gen->entityName() }};

use {{ $gen->containerName() }}\ApiTester;
use {{ $gen->entityModelNamespace() }};
use Vinkla\Hashids\Facades\Hashids;

/**
 * Get{{ $gen->entityName() }}Cest Class.
 * 
 * @author [name] <[<email address>]>
 */
class Get{{ $gen->entityName() }}Cest
{
    /**
     * @var string
     */
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

    public function get{{ $gen->entityName() }}(ApiTester $I)
    {
    	$data = factory({{ $gen->entityName() }}::class)->create();

        $I->sendGET(str_replace('{id}', $data->getHashedKey(), $this->endpoint));

        $I->seeResponseCodeIs(200);

@foreach ($fields as $field)
@if(!$field->hidden && $field->namespace)
        $I->seeResponseContainsJson(['{{ $field->name }}' => $I->hashKey($data->{{ $field->name }})]);
@elseif(!$field->hidden && $field->name !== "id" && !in_array($field->type, ['timestamp', 'datetime', 'date']))
        $I->seeResponseContainsJson(['{{ $field->name }}' => $data->{{ $field->name }}]);
@endif
@endforeach
    }
}
