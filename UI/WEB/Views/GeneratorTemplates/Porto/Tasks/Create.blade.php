<?= "<?php\n" ?>

namespace App\Containers\{{ $gen->containerName() }}\Tasks{{ $gen->solveGroupClasses() }};

use App\Containers\{{ $gen->containerName() }}\Data\Repositories\{{ $repoClass = $gen->entityName().'Repository' }};
use App\Containers\{{ $gen->containerName() }}\Exceptions\{{ $gen->entityName() }}CreationFailedException;
use App\Ship\Parents\Tasks\Task;

/**
 * {{ $gen->taskClass('Create') }} Class.
 * 
 * @author [name] <[<email address>]>
 */
class {{ $gen->taskClass('Create') }} extends Task
{
	public function run(array $input) {
		try {
            ${{ $camelEntity = camel_case($gen->entityName()) }} = app({{ $repoClass }}::class)->create($input);
        } catch (Exception $e) {
            throw (new {{ $gen->entityName() }}CreationFailedException())->debug($e);
        }

        return ${{ $camelEntity }};
	}
}
