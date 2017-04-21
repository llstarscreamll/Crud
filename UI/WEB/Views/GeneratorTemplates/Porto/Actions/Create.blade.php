<?= "<?php\n" ?>

namespace App\Containers\{{ $gen->containerName() }}\Actions\{{ $gen->entityName() }};

use App\Containers\{{ $gen->containerName() }}\Tasks\{{ $gen->entityName() }}\{{ $gen->taskClass('Create') }};
use App\Ship\Parents\Actions\Action;

/**
 * {{ $gen->actionClass('Create') }} Class.
 */
class {{ $gen->actionClass('Create') }} extends Action
{
	public function run(array $input)
	{
		${{ $camelEntity = camel_case($gen->entityName()) }} = $this->call({{ $gen->taskClass('Create') }}::class, [$input]);

		return ${{ $camelEntity }};
	}
}
