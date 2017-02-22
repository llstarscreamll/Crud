<?= "<?php\n" ?>

namespace App\Containers\{{ $gen->containerName() }}\Actions\{{ $gen->entityName() }};

use App\Containers\{{ $gen->containerName() }}\Tasks\{{ $gen->entityName() }}\{{ $gen->taskClass('Update') }};
use App\Ship\Parents\Actions\Action;

/**
 * {{ $gen->actionClass('Update') }} Class.
 */
class {{ $gen->actionClass('Update') }} extends Action
{
	/**
	 * @var App\Containers\{{ $gen->containerName() }}\Tasks\{{ $gen->entityName() }}\{{ $gen->taskClass('Update') }}
	 */
	private ${{ camel_case($task = $gen->taskClass('Update')) }};

	/**
	 * Creates new {{ $gen->actionClass('Update') }} class instance.
	 * @param {{ $task }} ${{ camel_case($task) }}
	 */
	public function __construct(
		{{ $task }} ${{ camel_case($task) }}
	) {
		$this->{{ camel_case($task) }} = ${{ camel_case($task) }};
	}

	public function run(int $id, array $input)
	{
		${{ $camelEntity = camel_case($gen->entityName()) }} = $this->{{ camel_case($task) }}->run($id, $input);

		return ${{ $camelEntity }};
	}
}
