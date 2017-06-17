<?= "<?php\n" ?>

namespace App\Containers\{{ $crud->containerName() }}\Tasks{{ $crud->solveGroupClasses() }};

use App\Containers\{{ $crud->containerName() }}\Data\Repositories\{{ $repoClass = $crud->entityName().'Repository' }};
use App\Ship\Parents\Tasks\Task;

/**
 * {{ $crud->taskClass('Restore') }} Class.
 * 
 * @author [name] <[<email address>]>
 */
class {{ $crud->taskClass('Restore') }} extends Task
{
	public function run(int $id) {
        ${{ $camelEntity = camel_case($crud->entityName()) }} = app({{ $repoClass }}::class)->restore($id);
        return ${{ $camelEntity }};
	}
}
