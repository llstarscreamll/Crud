<?= "<?php\n" ?>

namespace App\Containers\{{ $gen->containerName() }}\UI\API\Controllers;

use App\Containers\{{ $gen->containerName() }}\Actions\{{ $gen->entityName() }}\{{ $gen->actionClass('ListAndSearch', $plural = true) }};
use App\Containers\{{ $gen->containerName() }}\Actions\{{ $gen->entityName() }}\{{ $gen->actionClass('Create') }};
use App\Containers\{{ $gen->containerName() }}\Actions\{{ $gen->entityName() }}\{{ $gen->actionClass('Update') }};
use App\Containers\{{ $gen->containerName() }}\Actions\{{ $gen->entityName() }}\{{ $gen->actionClass('Delete') }};
use App\Containers\{{ $gen->containerName() }}\Actions\{{ $gen->entityName() }}\{{ $gen->actionClass('Restore') }};
use App\Port\Controller\Abstracts\PortApiController;
use Dingo\Api\Http\Request;

class Controller extends PortApiController
{
	public function listAll{{ str_plural($gen->entityName()) }}()
	{

	}

	public function create{{ $gen->entityName() }}()
	{
	
	}

	public function update{{ $gen->entityName() }}()
	{
	
	}

	public function delete{{ $gen->entityName() }}()
	{
	
	}

	public function restore{{ $gen->entityName() }}()
	{
	
	}
}
