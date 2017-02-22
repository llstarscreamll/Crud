<?= "<?php\n" ?>

namespace App\Containers\{{ $gen->containerName() }}\Actions\{{ $gen->entityName() }};

use App\Containers\{{ $gen->containerName() }}\Tasks\{{ $gen->entityName() }}\{{ $gen->taskClass('Create') }};
use App\Ship\Parents\Actions\Action;

/**
 * {{ $gen->actionClass('Create') }} Class.
 */
class {{ $gen->actionClass('Create') }} extends Action
{
	/**
	 * @var App\Containers\{{ $gen->containerName() }}\Tasks\{{ $gen->entityName() }}\{{ $gen->taskClass('Create') }}
	 */
	private ${{ camel_case($task = $gen->taskClass('Create')) }};

	/**
	 * Creates new {{ $gen->actionClass('Create') }} class instance.
	 * @param {{ $task }} ${{ camel_case($task) }}
	 */
	public function __construct(
		{{ $task }} ${{ camel_case($task) }}
	) {
		$this->{{ camel_case($task) }} = {{ camel_case($task) }};
	}

	public function run(
@foreach ($fields->filter(function ($field) { return $field->fillable; }) as $field)
@if($field->fillable)
			${{ $field->name }}@if(!$loop->last){{ ",\n" }}@endif
@endif
@endforeach
	) {
		${{ $camelEntity = camel_case($gen->entityName()) }} = $this->{{ camel_case($task) }}->run(
@foreach ($fields->filter(function ($field) { return $field->fillable; }) as $field)
@if($field->fillable)
				${{ $field->name }}@if(!$loop->last){{ ",\n" }}@endif
@endif
@endforeach
		);

		return ${{ $camelEntity }};
	}
}
