<?= "<?php\n" ?>

namespace App\Containers\{{ $gen->containerName() }}\Actions\{{ $gen->entityName() }};

use App\Containers\{{ $gen->containerName() }}\Tasks\{{ $gen->entityName() }}\{{ $gen->taskClass('Update') }};
use App\Ship\Parents\Actions\Action;

/**
 * {{ $gen->actionClass('Update') }} Class.
 */
class {{ $gen->actionClass('Update') }} extends Action
{
	public function run(int $id, array $input)
	{
		${{ $camelEntity = camel_case($gen->entityName()) }} = $this->call({{ $gen->taskClass('Update') }}::class, [$id, $input]);

		return ${{ $camelEntity }};
	}
}
