<?= "<?php\n" ?>

namespace App\Containers\{{ $crud->containerName() }}\Actions{{ $crud->solveGroupClasses() }};

use App\Containers\{{ $crud->containerName() }}\Tasks{{ $crud->solveGroupClasses() }}\{{ $crud->taskClass('Delete') }};
use App\Ship\Parents\Actions\Action;

/**
 * {{ $crud->actionClass('Delete') }} Class.
 * 
 * @author [name] <[<email address>]>
 */
class {{ $crud->actionClass('Delete') }} extends Action
{
	public function run(int $id)
	{
		${{ $camelEntity = camel_case($crud->entityName()) }} = $this->call({{ $crud->taskClass('Delete') }}::class, [$id]);

		return ${{ $camelEntity }};
	}
}
