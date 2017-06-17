<?= "<?php\n" ?>

namespace App\Containers\{{ $crud->containerName() }}\Actions{{ $crud->solveGroupClasses() }};

use App\Containers\{{ $crud->containerName() }}\Data\Repositories\{{ $crud->entityName() }}Repository;
use App\Ship\Parents\Actions\Action;
use Fractal;

/**
 * {{ $crud->actionClass('SelectListFrom', false, false) }} Class.
 * 
 * @author [name] <[<email address>]>
 */
class {{ $crud->actionClass('SelectListFrom', false, false) }} extends Action
{
	public function run()
	{
		return app({{ $crud->entityName() }}Repository::class)->selectList();
	}
}
