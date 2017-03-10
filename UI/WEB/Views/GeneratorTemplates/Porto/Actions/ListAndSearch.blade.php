<?= "<?php\n" ?>

namespace App\Containers\{{ $gen->containerName() }}\Actions\{{ $gen->entityName() }};

use App\Containers\{{ $gen->containerName() }}\Tasks\{{ $gen->entityName() }}\{{ $gen->taskClass('ListAndSearch', $plural = true) }};
use App\Ship\Parents\Actions\Action;

/**
 * {{ $gen->actionClass('ListAndSearch', $plural = true) }} Class.
 */
class {{ $gen->actionClass('ListAndSearch', $plural = true) }} extends Action
{
	/**
	 * @var App\Containers\{{ $gen->containerName() }}\Tasks\{{ $gen->entityName() }}\{{ $gen->taskClass('ListAndSearch', $plural = true) }}
	 */
	private ${{ camel_case($task = $gen->taskClass('ListAndSearch', $plural = true)) }};

	/**
	 * Creates new {{ $gen->actionClass('ListAndSearch', $plural = true) }} class instance.
	 * @param {{ $task }} ${{ camel_case($task) }}
	 */
	public function __construct(
		{{ $task }} ${{ camel_case($task) }}
	) {
		$this->{{ camel_case($task) }} = ${{ camel_case($task) }};
	}

	public function run($input)
	{
		${{ $camelEntity = camel_case($gen->entityName()) }} = $this->{{ camel_case($task) }}->run($input);

		return ${{ $camelEntity }};
	}
}
