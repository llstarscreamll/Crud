<?= "<?php\n" ?>

namespace App\Containers\{{ $gen->containerName() }}\UI\API\Controllers;

use App\Containers\{{ $gen->containerName() }}\Actions\{{ $gen->entityName() }}\{{ $gen->actionClass('ListAndSearch', $plural = true) }};
use App\Containers\{{ $gen->containerName() }}\Actions\{{ $gen->entityName() }}\{{ $gen->actionClass('Create') }};
use App\Containers\{{ $gen->containerName() }}\Actions\{{ $gen->entityName() }}\{{ $gen->actionClass('Update') }};
use App\Containers\{{ $gen->containerName() }}\Actions\{{ $gen->entityName() }}\{{ $gen->actionClass('Delete') }};
use App\Containers\{{ $gen->containerName() }}\Actions\{{ $gen->entityName() }}\{{ $gen->actionClass('Restore') }};
use App\Containers\{{ $gen->containerName() }}\UI\API\Requests\{{ $gen->entityName() }}\{{ str_replace('.php', '', $gen->apiRequestFile('Create', $plural = false)) }};
use App\Containers\{{ $gen->containerName() }}\UI\API\Requests\{{ $gen->entityName() }}\{{ str_replace('.php', '', $gen->apiRequestFile('Delete', $plural = false)) }};
use App\Containers\{{ $gen->containerName() }}\UI\API\Requests\{{ $gen->entityName() }}\{{ str_replace('.php', '', $gen->apiRequestFile('ListAll', $plural = true)) }};
use App\Containers\{{ $gen->containerName() }}\UI\API\Requests\{{ $gen->entityName() }}\{{ str_replace('.php', '', $gen->apiRequestFile('Restore', $plural = false)) }};
use App\Containers\{{ $gen->containerName() }}\UI\API\Requests\{{ $gen->entityName() }}\{{ str_replace('.php', '', $gen->apiRequestFile('Update', $plural = false)) }};
use App\Containers\{{ $gen->containerName() }}\UI\API\Transformers\{{ $gen->entityName() }}Transformer;
use App\Ship\Parents\Controllers\ApiController;
use Dingo\Api\Http\Request;

/**
 * Controller Class.
 */
class Controller extends ApiController
{
	public function listAll{{ str_plural($gen->entityName()) }}({{ str_replace('.php', '', $gen->apiRequestFile('ListAll', $plural = true)) }} $request, {{ $gen->actionClass('ListAndSearch', $plural = true) }} $action)
	{

	}

	public function create{{ $gen->entityName() }}({{ str_replace('.php', '', $gen->apiRequestFile('Create', $plural = false)) }} $request, {{ $gen->actionClass('Create') }} $action)
	{
		${{ camel_case($gen->entityName()) }} = $action->run($request->all());
		return $this->response->item(${{ camel_case($gen->entityName()) }}, new {{ $gen->entityName() }}Transformer());
	}

	public function update{{ $gen->entityName() }}({{ str_replace('.php', '', $gen->apiRequestFile('Update', $plural = false)) }} $request, {{ $gen->actionClass('Update') }} $action)
	{
		${{ camel_case($gen->entityName()) }} = $action->run($request->all());
		return $this->response->item(${{ camel_case($gen->entityName()) }}, new {{ $gen->entityName() }}Transformer());
	}

	public function delete{{ $gen->entityName() }}({{ str_replace('.php', '', $gen->apiRequestFile('Delete', $plural = false)) }} $request, {{ $gen->actionClass('Delete') }} $action)
	{
		${{ camel_case($gen->entityName()) }} = $action->run($request->id);
		return $this->response->accepted(null, [
            'message' => '{{ $gen->entityName() }} Deleted Successfully.',
        ]);
	}

	public function restore{{ $gen->entityName() }}({{ str_replace('.php', '', $gen->apiRequestFile('Restore', $plural = false)) }} $request, {{ $gen->actionClass('Restore') }} $action)
	{
		${{ camel_case($gen->entityName()) }} = $action->run($request->id);
		return $this->response->item(${{ camel_case($gen->entityName()) }}, new {{ $gen->entityName() }}Transformer());
	}
}
