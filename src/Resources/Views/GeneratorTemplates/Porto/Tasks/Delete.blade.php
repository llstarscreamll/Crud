<?= "<?php\n" ?>

namespace App\Containers\{{ $gen->containerName() }}\Tasks\{{ $gen->entityName() }};

use App\Containers\{{ $gen->containerName() }}\Data\Repositories\{{ $gen->entityName() }}Repository;
use App\Ship\Parents\Tasks\Task;

/**
 * {{ $gen->taskClass('Delete') }} Class.
 */
class {{ $gen->taskClass('Delete') }} extends Task
{
	/**
	 * @var {{ $repoClass = $gen->entityRepoClass() }}
	 */
	private ${{ camel_case($repoClass) }};

	/**
	 * Create new {{ $gen->taskClass('Delete') }} class instance.
	 * @param
	 */
	public function __construct({{ $repoClass }} ${{ camel_case($repoClass) }})
	{
		$this->{{ camel_case($repoClass) }} = ${{ camel_case($repoClass) }};
	}

	public function run(int $id) {
        ${{ $camelEntity = camel_case($gen->entityName()) }} = $this->{{ camel_case($repoClass) }}->delete($id);
        return ${{ $camelEntity }};
	}
}
