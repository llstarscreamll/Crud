<?= "<?php\n" ?>

namespace App\Containers\{{ $gen->containerName() }}\Actions\{{ $gen->entityName() }};

use App\Containers\{{ $gen->containerName() }}\Tasks\{{ $gen->entityName() }}\{{ $gen->taskClass('Restore') }};
use App\Ship\Parents\Actions\Action;

/**
 * {{ $gen->actionClass('Restore') }} Class.
 * 
 * @author [name] <[<email address>]>
 */
class {{ $gen->actionClass('Restore') }} extends Action
{
	public function run(int $id)
	{
		${{ $camelEntity = camel_case($gen->entityName()) }} = $this->call({{ $gen->taskClass('Restore') }}::class, [$id]);

		return ${{ $camelEntity }};
	}
}
