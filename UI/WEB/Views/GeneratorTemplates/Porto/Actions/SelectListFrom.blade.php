<?= "<?php\n" ?>

namespace App\Containers\{{ $gen->containerName() }}\Actions{{ $gen->solveGroupClasses() }};

use App\Containers\{{ $gen->containerName() }}\Data\Repositories\{{ $gen->entityName() }}Repository;
use App\Ship\Parents\Actions\Action;
use Fractal;

/**
 * {{ $gen->actionClass('SelectListFrom', false, false) }} Class.
 * 
 * @author [name] <[<email address>]>
 */
class {{ $gen->actionClass('SelectListFrom', false, false) }} extends Action
{
	public function run()
	{
		return app({{ $gen->entityName() }}Repository::class)->selectList();
	}
}
