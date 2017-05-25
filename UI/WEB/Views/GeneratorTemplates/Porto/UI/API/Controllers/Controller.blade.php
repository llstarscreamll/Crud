<?= "<?php\n" ?>

namespace App\Containers\{{ $gen->containerName() }}\UI\API\Controllers;

use App\Containers\{{ $gen->containerName() }}\Actions{{ $gen->solveGroupClasses() }}\{{ $gen->actionClass('Create') }};
use App\Containers\{{ $gen->containerName() }}\Actions{{ $gen->solveGroupClasses() }}\{{ $gen->actionClass('Delete') }};
use App\Containers\{{ $gen->containerName() }}\Actions{{ $gen->solveGroupClasses() }}\{{ $gen->actionClass('Get') }};
use App\Containers\{{ $gen->containerName() }}\Actions{{ $gen->solveGroupClasses() }}\{{ $gen->actionClass('ListAndSearch', true) }};
use App\Containers\{{ $gen->containerName() }}\Actions{{ $gen->solveGroupClasses() }}\{{ $gen->actionClass('Restore') }};
use App\Containers\{{ $gen->containerName() }}\Actions{{ $gen->solveGroupClasses() }}\{{ $gen->actionClass('SelectListFrom', false, false) }};
use App\Containers\{{ $gen->containerName() }}\Actions{{ $gen->solveGroupClasses() }}\{{ $gen->actionClass('Update') }};
use App\Containers\{{ $gen->containerName() }}\UI\API\Requests{{ $gen->solveGroupClasses() }}\{{ str_replace('.php', '', $gen->apiRequestFile('Create', false)) }};
use App\Containers\{{ $gen->containerName() }}\UI\API\Requests{{ $gen->solveGroupClasses() }}\{{ str_replace('.php', '', $gen->apiRequestFile('Delete', false)) }};
use App\Containers\{{ $gen->containerName() }}\UI\API\Requests{{ $gen->solveGroupClasses() }}\{{ str_replace('.php', '', $gen->apiRequestFile('Get', false)) }};
use App\Containers\{{ $gen->containerName() }}\UI\API\Requests{{ $gen->solveGroupClasses() }}\{{ str_replace('.php', '', $gen->apiRequestFile('ListAndSearch', true)) }};
use App\Containers\{{ $gen->containerName() }}\UI\API\Requests{{ $gen->solveGroupClasses() }}\{{ str_replace('.php', '', $gen->apiRequestFile('Restore', false)) }};
use App\Containers\{{ $gen->containerName() }}\UI\API\Requests{{ $gen->solveGroupClasses() }}\{{ str_replace('.php', '', $gen->apiRequestFile('SelectListFrom', false)) }};
use App\Containers\{{ $gen->containerName() }}\UI\API\Requests{{ $gen->solveGroupClasses() }}\{{ str_replace('.php', '', $gen->apiRequestFile('Update', false)) }};
use App\Containers\{{ $gen->containerName() }}\UI\API\Transformers\{{ $gen->entityName() }}Transformer;
use App\Ship\Parents\Controllers\ApiController;
use Illuminate\Http\Request;

/**
 * {{ $gen->entityName() }}Controller Class.
 * 
 * @author [name] <[<email address>]>
 */
class {{ $gen->entityName() }}Controller extends ApiController
{
	/**
	 * Returns the array entity form model.
	 *
	 * @param  Request $request
	 * @return Illuminate\Http\Response
	 */
	public function formModel(Request $request)
	{
		$model = config('{{ $gen->slugEntityName() }}-form-model');

		if (empty($model)) {
            return abort(404, 'Form Model Not Found.');
        }

		return $model;
	}

	/**
	 * Returns list of all records on DB with only id and name columns, mainly
	 * to be used on select dropdowns.
	 *
	 * @param {{ $requestClass = str_replace('.php', '', $gen->apiRequestFile('SelectListFrom', false)) }} $request
	 * @return Illuminate\Http\Response
	 */
	public function selectListFrom{{ $gen->entityName() }}({{ $requestClass }} $request)
	{
		$data = $this->call({{ $gen->actionClass('SelectListFrom', false, false) }}::class);

		return $data;
	}

	/**
	 * List and search resources from storage.
	 *
	 * @param {{ $requestClass = str_replace('.php', '', $gen->apiRequestFile('ListAndSearch', true)) }} $request
	 * @return Illuminate\Http\Response
	 */
	public function listAndSearch{{ str_plural($gen->entityName()) }}({{ $requestClass }} $request)
	{
		${{ camel_case(str_plural($gen->entityName())) }} = $this->call({{ $gen->actionClass('ListAndSearch', true) }}::class, [$request]);
		return $this->transform(${{ camel_case(str_plural($gen->entityName())) }}, new {{ $gen->entityName() }}Transformer());
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param {{ $requestClass = str_replace('.php', '', $gen->apiRequestFile('Create', false)) }} $request
	 * @return Illuminate\Http\Response
	 */
	public function create{{ $gen->entityName() }}({{ $requestClass }} $request)
	{
		${{ camel_case($gen->entityName()) }} = $this->call({{ $gen->actionClass('Create') }}::class, [$request->all()]);
		return $this->transform(${{ camel_case($gen->entityName()) }}, new {{ $gen->entityName() }}Transformer());
	}

	/**
	 * Returns the specified resource.
	 *
	 * @param {{ $requestClass = str_replace('.php', '', $gen->apiRequestFile('Get', false)) }} $request
	 * @return Illuminate\Http\Response
	 */
	public function get{{ $gen->entityName() }}({{ $requestClass }} $request)
	{
		${{ camel_case($gen->entityName()) }} = $this->call({{ $gen->actionClass('Get') }}::class, [$request->id]);
		return $this->transform(${{ camel_case($gen->entityName()) }}, new {{ $gen->entityName() }}Transformer());
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param {{ $requestClass = str_replace('.php', '', $gen->apiRequestFile('Update', false)) }} $request
	 * @return Illuminate\Http\Response
	 */
	public function update{{ $gen->entityName() }}({{ $requestClass }} $request)
	{
		${{ camel_case($gen->entityName()) }} = $this->call({{ $gen->actionClass('Update') }}::class, [$request->id, $request->all()]);
		return $this->transform(${{ camel_case($gen->entityName()) }}, new {{ $gen->entityName() }}Transformer());
	}

	/**
	 * {{ $gen->hasSoftDeleteColumn ? 'Soft' : null }}Delete the specified resource from storage.
	 *
	 * @param {{ $requestClass = str_replace('.php', '', $gen->apiRequestFile('Delete', false)) }} $request
	 * @return Illuminate\Http\Response
	 */
	public function delete{{ $gen->entityName() }}({{ $requestClass }} $request)
	{
		${{ camel_case($gen->entityName()) }} = $this->call({{ $gen->actionClass('Delete') }}::class, [$request->id]);
		return $this->accepted('{{ $gen->entityName() }} Deleted Successfully.');
	}

@if($gen->hasSoftDeleteColumn)
	/**
	 * Restore the specified softDeleted resource from storage.
	 *
	 * @param {{ $requestClass = str_replace('.php', '', $gen->apiRequestFile('Restore', false)) }} $request
	 * @return Illuminate\Http\Response
	 */
	public function restore{{ $gen->entityName() }}({{ $requestClass }} $request)
	{
		${{ camel_case($gen->entityName()) }} = $this->call({{ $gen->actionClass('Restore') }}::class, [$request->id]);
		return $this->transform(${{ camel_case($gen->entityName()) }}, new {{ $gen->entityName() }}Transformer());
	}
@endif
}
