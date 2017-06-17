<?= "<?php\n" ?>

namespace App\Containers\{{ $crud->containerName() }}\Actions{{ $crud->solveGroupClasses() }};

use App\Containers\{{ $crud->containerName() }}\Tasks{{ $crud->solveGroupClasses() }}\{{ $crud->taskClass('Get') }};
use App\Ship\Parents\Actions\Action;

/**
 * {{ $crud->actionClass('Get') }} Class.
 * 
 * @author [name] <[<email address>]>
 */
class {{ $crud->actionClass('Get') }} extends Action
{
	public function run(int $id)
	{
		${{ $camelEntity = camel_case($crud->entityName()) }} = $this->call({{ $crud->taskClass('Get') }}::class, [$id]);

		return ${{ $camelEntity }};
	}
}
