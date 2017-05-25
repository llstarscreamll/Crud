<?= "<?php\n" ?>

namespace App\Containers\{{ $gen->containerName() }}\Actions{{ $gen->solveGroupClasses() }};

use App\Containers\{{ $gen->containerName() }}\Tasks{{ $gen->solveGroupClasses() }}\{{ $gen->taskClass('Create') }};
use App\Ship\Parents\Actions\Action;

/**
 * {{ $gen->actionClass('Create') }} Class.
 * 
 * @author [name] <[<email address>]>
 */
class {{ $gen->actionClass('Create') }} extends Action
{
	public function run(array $input)
	{
		${{ $camelEntity = camel_case($gen->entityName()) }} = $this->call({{ $gen->taskClass('Create') }}::class, [$input]);

		return ${{ $camelEntity }};
	}
}
