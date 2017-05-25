<?= "<?php\n" ?>

namespace App\Containers\{{ $gen->containerName() }}\Actions{{ $gen->solveGroupClasses() }};

use App\Containers\{{ $gen->containerName() }}\Tasks{{ $gen->solveGroupClasses() }}\{{ $gen->taskClass('Update') }};
use App\Ship\Parents\Actions\Action;

/**
 * {{ $gen->actionClass('Update') }} Class.
 * 
 * @author [name] <[<email address>]>
 */
class {{ $gen->actionClass('Update') }} extends Action
{
	public function run(int $id, array $input)
	{
		${{ $camelEntity = camel_case($gen->entityName()) }} = $this->call({{ $gen->taskClass('Update') }}::class, [$id, $input]);

		return ${{ $camelEntity }};
	}
}
