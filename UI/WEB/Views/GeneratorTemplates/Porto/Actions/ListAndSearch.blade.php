<?= "<?php\n" ?>

namespace App\Containers\{{ $crud->containerName() }}\Actions{{ $crud->solveGroupClasses() }};

use App\Containers\{{ $crud->containerName() }}\Tasks{{ $crud->solveGroupClasses() }}\{{ $crud->taskClass('ListAndSearch', $plural = true) }};
use App\Ship\Parents\Actions\Action;

/**
 * {{ $crud->actionClass('ListAndSearch', $plural = true) }} Class.
 * 
 * @author [name] <[<email address>]>
 */
class {{ $crud->actionClass('ListAndSearch', $plural = true) }} extends Action
{
	public function run($input)
	{
		${{ $camelEntity = camel_case($crud->entityName()) }} = $this->call({{ $crud->taskClass('ListAndSearch', $plural = true) }}::class, [$input]);

		return ${{ $camelEntity }};
	}
}
