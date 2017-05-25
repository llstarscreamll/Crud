<?= "<?php\n" ?>

namespace App\Containers\{{ $gen->containerName() }}\Actions{{ $gen->solveGroupClasses() }};

use App\Containers\{{ $gen->containerName() }}\Tasks{{ $gen->solveGroupClasses() }}\{{ $gen->taskClass('Delete') }};
use App\Ship\Parents\Actions\Action;

/**
 * {{ $gen->actionClass('Delete') }} Class.
 * 
 * @author [name] <[<email address>]>
 */
class {{ $gen->actionClass('Delete') }} extends Action
{
	public function run(int $id)
	{
		${{ $camelEntity = camel_case($gen->entityName()) }} = $this->call({{ $gen->taskClass('Delete') }}::class, [$id]);

		return ${{ $camelEntity }};
	}
}
