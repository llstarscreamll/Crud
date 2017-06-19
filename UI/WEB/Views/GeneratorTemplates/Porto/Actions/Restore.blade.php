<?= "<?php\n" ?>

namespace App\Containers\{{ $crud->containerName() }}\Actions{{ $crud->solveGroupClasses() }};

use App\Containers\{{ $crud->containerName() }}\Tasks{{ $crud->solveGroupClasses() }}\{{ $crud->taskClass('Restore') }};
use App\Ship\Parents\Actions\Action;

/**
 * {{ $crud->actionClass('Restore') }} Class.
 * 
 * @author [name] <[<email address>]>
 */
class {{ $crud->actionClass('Restore') }} extends Action
{
	public function run(int $id)
	{
		${{ $camelEntity = camel_case($crud->entityName()) }} = $this->call({{ $crud->taskClass('Restore') }}::class, [$id]);

		return ${{ $camelEntity }};
	}
}
