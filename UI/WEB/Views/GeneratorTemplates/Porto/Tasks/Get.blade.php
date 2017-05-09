<?= "<?php\n" ?>

namespace App\Containers\{{ $gen->containerName() }}\Tasks\{{ $gen->entityName() }};

use App\Containers\{{ $gen->containerName() }}\Data\Repositories\{{ $repoClass = $gen->entityName().'Repository' }};
use App\Ship\Parents\Tasks\Task;
use App\Containers\{{ $gen->containerName() }}\Exceptions\{{ $gen->entityName() }}CreationFailedException;

/**
 * {{ $gen->taskClass('Get') }} Class.
 * 
 * @author [name] <[<email address>]>
 */
class {{ $gen->taskClass('Get') }} extends Task
{
	public function run(int $id) {
        ${{ $camelEntity = camel_case($gen->entityName()) }} = app({{ $repoClass }}::class)@if($gen->hasSoftDeleteColumn)->makeModel()->withTrashed()@endif->find($id);
        return ${{ $camelEntity }};
	}
}
