<?= "<?php\n" ?>

namespace App\Containers\{{ $gen->containerName() }}\Tasks\{{ $gen->entityName() }};

use App\Containers\{{ $gen->containerName() }}\Data\Repositories\{{ $gen->entityName() }}Repository;
use App\Ship\Parents\Tasks\Task;
use App\Containers\{{ $gen->containerName() }}\Exceptions\{{ $gen->entityName() }}CreationFailedException;

/**
 * {{ $gen->taskClass('Get') }} Class.
 */
class {{ $gen->taskClass('Get') }} extends Task
{
	/**
	 * @var {{ $repoClass = $gen->entityRepoClass() }}
	 */
	private ${{ camel_case($repoClass) }};

	/**
	 * Create new {{ $gen->taskClass('Get') }} class instance.
	 * @param
	 */
	public function __construct({{ $repoClass }} ${{ camel_case($repoClass) }})
	{
		$this->{{ camel_case($repoClass) }} = ${{ camel_case($repoClass) }};
	}

	public function run(int $id) {
        ${{ $camelEntity = camel_case($gen->entityName()) }} = $this->{{ camel_case($repoClass) }}@if($gen->hasSoftDeleteColumn)->makeModel()->withTrashed()@endif->find($id);
        return ${{ $camelEntity }};
	}
}
