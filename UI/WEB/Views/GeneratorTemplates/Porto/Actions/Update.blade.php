<?= "<?php\n" ?>

namespace App\Containers\{{ $crud->containerName() }}\Actions{{ $crud->solveGroupClasses() }};

use App\Containers\{{ $crud->containerName() }}\Tasks{{ $crud->solveGroupClasses() }}\{{ $crud->taskClass('Update') }};
use App\Ship\Parents\Actions\Action;

/**
 * {{ $crud->actionClass('Update') }} Class.
 * 
 * @author [name] <[<email address>]>
 */
class {{ $crud->actionClass('Update') }} extends Action
{
	public function run(int $id, array $input)
	{
		${{ $camelEntity = camel_case($crud->entityName()) }} = $this->call({{ $crud->taskClass('Update') }}::class, [$id, $input]);

		return ${{ $camelEntity }};
	}
}
