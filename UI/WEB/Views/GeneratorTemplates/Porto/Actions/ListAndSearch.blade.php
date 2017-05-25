<?= "<?php\n" ?>

namespace App\Containers\{{ $gen->containerName() }}\Actions{{ $gen->solveGroupClasses() }};

use App\Containers\{{ $gen->containerName() }}\Tasks{{ $gen->solveGroupClasses() }}\{{ $gen->taskClass('ListAndSearch', $plural = true) }};
use App\Ship\Parents\Actions\Action;

/**
 * {{ $gen->actionClass('ListAndSearch', $plural = true) }} Class.
 * 
 * @author [name] <[<email address>]>
 */
class {{ $gen->actionClass('ListAndSearch', $plural = true) }} extends Action
{
	public function run($input)
	{
		${{ $camelEntity = camel_case($gen->entityName()) }} = $this->call({{ $gen->taskClass('ListAndSearch', $plural = true) }}::class, [$input]);

		return ${{ $camelEntity }};
	}
}
