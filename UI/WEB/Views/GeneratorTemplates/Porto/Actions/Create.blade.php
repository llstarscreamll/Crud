<?= "<?php\n" ?>

namespace App\Containers\{{ $crud->containerName() }}\Actions{{ $crud->solveGroupClasses() }};

use App\Containers\{{ $crud->containerName() }}\Tasks{{ $crud->solveGroupClasses() }}\{{ $crud->taskClass('Create') }};
use App\Ship\Parents\Actions\Action;

/**
 * {{ $crud->actionClass('Create') }} Class.
 * 
 * @author [name] <[<email address>]>
 */
class {{ $crud->actionClass('Create') }} extends Action
{
	public function run(array $input)
	{
		${{ $camelEntity = camel_case($crud->entityName()) }} = $this->call({{ $crud->taskClass('Create') }}::class, [$input]);

		return ${{ $camelEntity }};
	}
}
