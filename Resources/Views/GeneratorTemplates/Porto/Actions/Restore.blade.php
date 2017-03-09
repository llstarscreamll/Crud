<?= "<?php\n" ?>

namespace App\Containers\{{ $gen->containerName() }}\Actions\{{ $gen->entityName() }};

use App\Containers\{{ $gen->containerName() }}\Tasks\{{ $gen->entityName() }}\{{ $gen->taskClass('Restore') }};
use App\Ship\Parents\Actions\Action;

/**
 * {{ $gen->actionClass('Restore') }} Class.
 */
class {{ $gen->actionClass('Restore') }} extends Action
{
	/**
	 * @var App\Containers\{{ $gen->containerName() }}\Tasks\{{ $gen->entityName() }}\{{ $gen->taskClass('Restore') }}
	 */
	private ${{ camel_case($task = $gen->taskClass('Restore')) }};

	/**
	 * Creates new {{ $gen->actionClass('Restore') }} class instance.
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
