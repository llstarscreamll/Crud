<?= "<?php\n" ?>

namespace App\Containers\{{ $gen->containerName() }}\Actions\{{ $gen->entityName() }};

use App\Containers\{{ $gen->containerName() }}\Tasks\{{ $gen->entityName() }}\{{ $gen->taskClass('Get') }};
use App\Ship\Parents\Actions\Action;

/**
 * {{ $gen->actionClass('Get') }} Class.
 */
class {{ $gen->actionClass('Get') }} extends Action
{
	public function run(int $id)
	{
		${{ $camelEntity = camel_case($gen->entityName()) }} = $this->call({{ $gen->taskClass('Get') }}::class, [$id]);

		return ${{ $camelEntity }};
	}
}
