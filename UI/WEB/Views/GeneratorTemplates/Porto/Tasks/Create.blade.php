<?= "<?php\n" ?>

namespace App\Containers\{{ $crud->containerName() }}\Tasks{{ $crud->solveGroupClasses() }};

use App\Containers\{{ $crud->containerName() }}\Data\Repositories\{{ $repoClass = $crud->entityName().'Repository' }};
use App\Containers\{{ $crud->containerName() }}\Exceptions\{{ $crud->entityName() }}CreationFailedException;
use App\Ship\Parents\Tasks\Task;

/**
 * {{ $crud->taskClass('Create') }} Class.
 * 
 * @author [name] <[<email address>]>
 */
class {{ $crud->taskClass('Create') }} extends Task
{
	public function run(array $input) {
		try {
            ${{ $camelEntity = camel_case($crud->entityName()) }} = app({{ $repoClass }}::class)->create($input);
        } catch (Exception $e) {
            throw (new {{ $crud->entityName() }}CreationFailedException())->debug($e);
        }

        return ${{ $camelEntity }};
	}
}
