<?= "<?php\n" ?>

namespace App\Containers\{{ $gen->containerName() }}\Tasks\{{ $gen->entityName() }};

use App\Containers\{{ $gen->containerName() }}\Data\Repositories\{{ $repoClass = $gen->entityName().'Repository' }};
use App\Ship\Parents\Tasks\Task;
use App\Containers\{{ $gen->containerName() }}\Exceptions\{{ $gen->entityName() }}CreationFailedException;

/**
 * {{ $gen->taskClass('Update') }} Class.
 */
class {{ $gen->taskClass('Update') }} extends Task
{
	public function run(int $id, array $input) {
		${{ $camelEntity = camel_case($gen->entityName()) }} = app({{ $repoClass }}::class)->update($input, $id);

        return ${{ $camelEntity }};
	}
}
