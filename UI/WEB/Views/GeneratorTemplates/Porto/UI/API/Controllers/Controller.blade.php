<?= "<?php\n" ?>

namespace App\Containers\{{ $crud->containerName() }}\UI\API\Controllers;

use App\Containers\{{ $crud->containerName() }}\Actions{{ $crud->solveGroupClasses() }}\{{ $crud->actionClass('Create') }};
use App\Containers\{{ $crud->containerName() }}\Actions{{ $crud->solveGroupClasses() }}\{{ $crud->actionClass('Delete') }};
use App\Containers\{{ $crud->containerName() }}\Actions{{ $crud->solveGroupClasses() }}\{{ $crud->actionClass('Get') }};
use App\Containers\{{ $crud->containerName() }}\Actions{{ $crud->solveGroupClasses() }}\{{ $crud->actionClass('ListAndSearch', true) }};
use App\Containers\{{ $crud->containerName() }}\Actions{{ $crud->solveGroupClasses() }}\{{ $crud->actionClass('Restore') }};
use App\Containers\{{ $crud->containerName() }}\Actions{{ $crud->solveGroupClasses() }}\{{ $crud->actionClass('SelectListFrom', false, false) }};
use App\Containers\{{ $crud->containerName() }}\Actions{{ $crud->solveGroupClasses() }}\{{ $crud->actionClass('Update') }};
use App\Containers\{{ $crud->containerName() }}\UI\API\Requests{{ $crud->solveGroupClasses() }}\{{ str_replace('.php', '', $crud->apiRequestFile('Create', false)) }};
use App\Containers\{{ $crud->containerName() }}\UI\API\Requests{{ $crud->solveGroupClasses() }}\{{ str_replace('.php', '', $crud->apiRequestFile('Delete', false)) }};
use App\Containers\{{ $crud->containerName() }}\UI\API\Requests{{ $crud->solveGroupClasses() }}\{{ str_replace('.php', '', $crud->apiRequestFile('Get', false)) }};
use App\Containers\{{ $crud->containerName() }}\UI\API\Requests{{ $crud->solveGroupClasses() }}\{{ str_replace('.php', '', $crud->apiRequestFile('ListAndSearch', true)) }};
use App\Containers\{{ $crud->containerName() }}\UI\API\Requests{{ $crud->solveGroupClasses() }}\{{ str_replace('.php', '', $crud->apiRequestFile('Restore', false)) }};
use App\Containers\{{ $crud->containerName() }}\UI\API\Requests{{ $crud->solveGroupClasses() }}\{{ str_replace('.php', '', $crud->apiRequestFile('SelectListFrom', false)) }};
use App\Containers\{{ $crud->containerName() }}\UI\API\Requests{{ $crud->solveGroupClasses() }}\{{ str_replace('.php', '', $crud->apiRequestFile('Update', false)) }};
use App\Containers\{{ $crud->containerName() }}\UI\API\Transformers\{{ $crud->entityName() }}Transformer;
use App\Ship\Parents\Controllers\ApiController;
use Illuminate\Http\Request;

/**
 * {{ $crud->entityName() }}Controller Class.
 * 
 * @author [name] <[<email address>]>
 */
class {{ $crud->entityName() }}Controller extends ApiController
{
	/**
	 * Returns the array entity form model.
	 *
	 * @param  Request $request
	 * @return Illuminate\Http\Response
	 */
	public function formModel(Request $request)
	{
		$model = config('{{ $crud->slugEntityName() }}-form-model');

		if (empty($model)) {
            return abort(404, 'Form Model Not Found.');
        }

		return $model;
	}

	/**
	 * Returns list of all records on DB with only id and name columns, mainly
	 * to be used on select dropdowns.
	 *
	 * @param {{ $requestClass = str_replace('.php', '', $crud->apiRequestFile('SelectListFrom', false)) }} $request
	 * @return Illuminate\Http\Response
	 */
	public function selectListFrom{{ $crud->entityName() }}({{ $requestClass }} $request)
	{
		$data = $this->call({{ $crud->actionClass('SelectListFrom', false, false) }}::class);

		return $data;
	}

	/**
	 * List and search resources from storage.
	 *
	 * @param {{ $requestClass = str_replace('.php', '', $crud->apiRequestFile('ListAndSearch', true)) }} $request
	 * @return Illuminate\Http\Response
	 */
	public function listAndSearch{{ str_plural($crud->entityName()) }}({{ $requestClass }} $request)
	{
		${{ camel_case(str_plural($crud->entityName())) }} = $this->call({{ $crud->actionClass('ListAndSearch', true) }}::class, [$request]);
		return $this->transform(${{ camel_case(str_plural($crud->entityName())) }}, new {{ $crud->entityName() }}Transformer());
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param {{ $requestClass = str_replace('.php', '', $crud->apiRequestFile('Create', false)) }} $request
	 * @return Illuminate\Http\Response
	 */
	public function create{{ $crud->entityName() }}({{ $requestClass }} $request)
	{
		${{ camel_case($crud->entityName()) }} = $this->call({{ $crud->actionClass('Create') }}::class, [$request->all()]);
		return $this->transform(${{ camel_case($crud->entityName()) }}, new {{ $crud->entityName() }}Transformer());
	}

	/**
	 * Returns the specified resource.
	 *
	 * @param {{ $requestClass = str_replace('.php', '', $crud->apiRequestFile('Get', false)) }} $request
	 * @return Illuminate\Http\Response
	 */
	public function get{{ $crud->entityName() }}({{ $requestClass }} $request)
	{
		${{ camel_case($crud->entityName()) }} = $this->call({{ $crud->actionClass('Get') }}::class, [$request->id]);
		return $this->transform(${{ camel_case($crud->entityName()) }}, new {{ $crud->entityName() }}Transformer());
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param {{ $requestClass = str_replace('.php', '', $crud->apiRequestFile('Update', false)) }} $request
	 * @return Illuminate\Http\Response
	 */
	public function update{{ $crud->entityName() }}({{ $requestClass }} $request)
	{
		${{ camel_case($crud->entityName()) }} = $this->call({{ $crud->actionClass('Update') }}::class, [$request->id, $request->all()]);
		return $this->transform(${{ camel_case($crud->entityName()) }}, new {{ $crud->entityName() }}Transformer());
	}

	/**
	 * {{ $crud->hasSoftDeleteColumn ? 'Soft' : null }}Delete the specified resource from storage.
	 *
	 * @param {{ $requestClass = str_replace('.php', '', $crud->apiRequestFile('Delete', false)) }} $request
	 * @return Illuminate\Http\Response
	 */
	public function delete{{ $crud->entityName() }}({{ $requestClass }} $request)
	{
		${{ camel_case($crud->entityName()) }} = $this->call({{ $crud->actionClass('Delete') }}::class, [$request->id]);
		return $this->accepted('{{ $crud->entityName() }} Deleted Successfully.');
	}

@if($crud->hasSoftDeleteColumn)
	/**
	 * Restore the specified softDeleted resource from storage.
	 *
	 * @param {{ $requestClass = str_replace('.php', '', $crud->apiRequestFile('Restore', false)) }} $request
	 * @return Illuminate\Http\Response
	 */
	public function restore{{ $crud->entityName() }}({{ $requestClass }} $request)
	{
		${{ camel_case($crud->entityName()) }} = $this->call({{ $crud->actionClass('Restore') }}::class, [$request->id]);
		return $this->transform(${{ camel_case($crud->entityName()) }}, new {{ $crud->entityName() }}Transformer());
	}
@endif
}
