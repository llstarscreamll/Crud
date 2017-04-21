<?= "<?php\n" ?>

namespace App\Containers\{{ $gen->containerName() }}\Actions\{{ $gen->entityName() }};

use App\Containers\{{ $gen->containerName() }}\Tasks\{{ $gen->entityName() }}\{{ $gen->taskClass('Delete') }};
use App\Ship\Parents\Actions\Action;

/**
 * {{ $gen->actionClass('Delete') }} Class.
 */
class {{ $gen->actionClass('Delete') }} extends Action
{
	public function run(int $id)
	{
		${{ $camelEntity = camel_case($gen->entityName()) }} = $this->call({{ $gen->taskClass('Delete') }}::class, [$id]);

		return ${{ $camelEntity }};
	}
}
