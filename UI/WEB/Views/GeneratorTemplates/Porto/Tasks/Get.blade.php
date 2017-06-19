<?= "<?php\n" ?>

namespace App\Containers\{{ $crud->containerName() }}\Tasks{{ $crud->solveGroupClasses() }};

use App\Containers\{{ $crud->containerName() }}\Data\Repositories\{{ $repoClass = $crud->entityName().'Repository' }};
use App\Containers\{{ $crud->containerName() }}\Exceptions\{{ $crud->entityName() }}CreationFailedException;
use App\Ship\Parents\Tasks\Task;

/**
 * {{ $crud->taskClass('Get') }} Class.
 * 
 * @author [name] <[<email address>]>
 */
class {{ $crud->taskClass('Get') }} extends Task
{
	public function run(int $id) {
        ${{ $camelEntity = camel_case($crud->entityName()) }} = app({{ $repoClass }}::class)@if($crud->hasSoftDeleteColumn)->makeModel()->withTrashed()@endif->find($id);
        return ${{ $camelEntity }};
	}
}
