<?= "<?php\n" ?>

namespace App\Containers\{{ $gen->containerName() }}\Tasks\{{ $gen->entityName() }};

use App\Containers\{{ $gen->containerName() }}\Data\Repositories\{{ $gen->entityName() }}Repository;
use App\Ship\Parents\Tasks\Task;
use App\Containers\{{ $gen->containerName() }}\Exceptions\{{ $gen->entityName() }}CreationFailedException;

/**
 * {{ $gen->taskClass('Create') }} Class.
 */
class {{ $gen->taskClass('Create') }} extends Task
{
	/**
	 * @var {{ $repoClass = $gen->entityRepoClass() }}
	 */
	private ${{ camel_case($repoClass) }};

	/**
	 * Create new {{ $gen->taskClass('Create') }} class instance.
	 * @param
	 */
	public function __construct({{ $repoClass }} ${{ camel_case($repoClass) }})
	{
		$this->{{ camel_case($repoClass) }} = ${{ camel_case($repoClass) }};
	}

	public function run(array $input) {
		try {
            ${{ $camelEntity = camel_case($gen->entityName()) }} = $this->{{ camel_case($repoClass) }}->create($input);
        } catch (Exception $e) {
            throw (new {{ $gen->entityName() }}CreationFailedException())->debug($e);
        }

        return ${{ $camelEntity }};
	}
}
