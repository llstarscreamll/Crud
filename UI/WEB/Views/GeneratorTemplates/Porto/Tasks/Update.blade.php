<?= "<?php\n" ?>

namespace App\Containers\{{ $crud->containerName() }}\Tasks{{ $crud->solveGroupClasses() }};

use App\Containers\{{ $crud->containerName() }}\Data\Repositories\{{ $repoClass = $crud->entityName().'Repository' }};
use App\Containers\{{ $crud->containerName() }}\Exceptions\{{ $crud->entityName() }}CreationFailedException;
use App\Ship\Parents\Tasks\Task;

/**
 * {{ $crud->taskClass('Update') }} Class.
 * 
 * @author [name] <[<email address>]>
 */
class {{ $crud->taskClass('Update') }} extends Task
{
	public function run(int $id, array $input) {
		${{ $camelEntity = camel_case($crud->entityName()) }} = app({{ $repoClass }}::class)->update($input, $id);

        return ${{ $camelEntity }};
	}
}
