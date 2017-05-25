<?= "<?php\n" ?>

namespace App\Containers\{{ $gen->containerName() }}\Actions{{ $gen->solveGroupClasses() }};

use App\Containers\{{ $gen->containerName() }}\Tasks{{ $gen->solveGroupClasses() }}\{{ $gen->taskClass('Get') }};
use App\Ship\Parents\Actions\Action;

/**
 * {{ $gen->actionClass('Get') }} Class.
 * 
 * @author [name] <[<email address>]>
 */
class {{ $gen->actionClass('Get') }} extends Action
{
	public function run(int $id)
	{
		${{ $camelEntity = camel_case($gen->entityName()) }} = $this->call({{ $gen->taskClass('Get') }}::class, [$id]);

		return ${{ $camelEntity }};
	}
}
