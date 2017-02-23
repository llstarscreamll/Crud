<?= "<?php\n" ?>

namespace App\Containers\{{ $gen->containerName() }}\Actions\{{ $gen->entityName() }};

use App\Containers\{{ $gen->containerName() }}\Tasks\{{ $gen->entityName() }}\{{ $gen->taskClass('Get') }};
use App\Ship\Parents\Actions\Action;

/**
 * {{ $gen->actionClass('Get') }} Class.
 */
class {{ $gen->actionClass('Get') }} extends Action
{
	/**
	 * @var App\Containers\{{ $gen->containerName() }}\Tasks\{{ $gen->entityName() }}\{{ $gen->taskClass('Get') }}
	 */
	private ${{ camel_case($task = $gen->taskClass('Get')) }};

	/**
	 * Creates new {{ $gen->actionClass('Get') }} class instance.
	 * @param {{ $task }} ${{ camel_case($task) }}
	 */
	public function __construct(
		{{ $task }} ${{ camel_case($task) }}
	) {
		$this->{{ camel_case($task) }} = ${{ camel_case($task) }};
	}

	public function run(int $id)
	{
		${{ $camelEntity = camel_case($gen->entityName()) }} = $this->{{ camel_case($task) }}->run($id);

		return ${{ $camelEntity }};
	}
}
