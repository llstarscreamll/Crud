<?= "<?php\n" ?>

namespace App\Containers\{{ $gen->containerName() }}\UI\API\Controllers;

use App\Containers\{{ $gen->containerName() }}\Actions\{{ $gen->entityName() }}\{{ $gen->actionClass('ListAndSearch', $plural = true) }};
use App\Containers\{{ $gen->containerName() }}\Actions\{{ $gen->entityName() }}\{{ $gen->actionClass('Create') }};
use App\Containers\{{ $gen->containerName() }}\Actions\{{ $gen->entityName() }}\{{ $gen->actionClass('Get') }};
use App\Containers\{{ $gen->containerName() }}\Actions\{{ $gen->entityName() }}\{{ $gen->actionClass('Update') }};
use App\Containers\{{ $gen->containerName() }}\Actions\{{ $gen->entityName() }}\{{ $gen->actionClass('Delete') }};
use App\Containers\{{ $gen->containerName() }}\Actions\{{ $gen->entityName() }}\{{ $gen->actionClass('Restore') }};
use App\Containers\{{ $gen->containerName() }}\Actions\{{ $gen->entityName() }}\{{ $gen->actionClass('SelectListFrom', false, false) }};
use App\Containers\{{ $gen->containerName() }}\UI\API\Requests\{{ $gen->entityName() }}\{{ str_replace('.php', '', $gen->apiRequestFile('Create', $plural = false)) }};
use App\Containers\{{ $gen->containerName() }}\UI\API\Requests\{{ $gen->entityName() }}\{{ str_replace('.php', '', $gen->apiRequestFile('Get', $plural = false)) }};
use App\Containers\{{ $gen->containerName() }}\UI\API\Requests\{{ $gen->entityName() }}\{{ str_replace('.php', '', $gen->apiRequestFile('Delete', $plural = false)) }};
use App\Containers\{{ $gen->containerName() }}\UI\API\Requests\{{ $gen->entityName() }}\{{ str_replace('.php', '', $gen->apiRequestFile('ListAndSearch', $plural = true)) }};
use App\Containers\{{ $gen->containerName() }}\UI\API\Requests\{{ $gen->entityName() }}\{{ str_replace('.php', '', $gen->apiRequestFile('Restore', $plural = false)) }};
use App\Containers\{{ $gen->containerName() }}\UI\API\Requests\{{ $gen->entityName() }}\{{ str_replace('.php', '', $gen->apiRequestFile('Update', $plural = false)) }};
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
	 * @param  Request $request
	 * @return Illuminate\Http\Response
	 */
	public function selectListFrom{{ $gen->entityName() }}()
	{
		$data = $this->call({{ $gen->actionClass('SelectListFrom', false, false) }}::class);

		return $data;
	}

	/**
	 * List and search resources from storage.
	 *
	 * @param {{ str_replace('.php', '', $gen->apiRequestFile('ListAndSearch', $plural = true)) }} $request
	 * @return Illuminate\Http\Response
	 */
	public function listAndSearch{{ str_plural($gen->entityName()) }}({{ str_replace('.php', '', $gen->apiRequestFile('ListAndSearch', $plural = true)) }} $request)
	{
		${{ camel_case(str_plural($gen->entityName())) }} = $this->call({{ $gen->actionClass('ListAndSearch', $plural = true) }}::class, [$request]);
		return $this->transform(${{ camel_case(str_plural($gen->entityName())) }}, new {{ $gen->entityName() }}Transformer());
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param {{ str_replace('.php', '', $gen->apiRequestFile('Create', $plural = false)) }} $request
	 * @return Illuminate\Http\Response
	 */
	public function create{{ $gen->entityName() }}({{ str_replace('.php', '', $gen->apiRequestFile('Create', $plural = false)) }} $request)
	{
		${{ camel_case($gen->entityName()) }} = $this->call({{ $gen->actionClass('Create') }}::class, [$request->all()]);
		return $this->transform(${{ camel_case($gen->entityName()) }}, new {{ $gen->entityName() }}Transformer());
	}

	/**
	 * Returns the specified resource.
	 *
	 * @param {{ str_replace('.php', '', $gen->apiRequestFile('Get', $plural = false)) }} $request
	 * @return Illuminate\Http\Response
	 */
	public function get{{ $gen->entityName() }}({{ str_replace('.php', '', $gen->apiRequestFile('Get', $plural = false)) }} $request)
	{
		${{ camel_case($gen->entityName()) }} = $this->call({{ $gen->actionClass('Get') }}::class, [$request->id]);
		return $this->transform(${{ camel_case($gen->entityName()) }}, new {{ $gen->entityName() }}Transformer());
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param {{ str_replace('.php', '', $gen->apiRequestFile('Update', $plural = false)) }} $request
	 * @return Illuminate\Http\Response
	 */
	public function update{{ $gen->entityName() }}({{ str_replace('.php', '', $gen->apiRequestFile('Update', $plural = false)) }} $request)
	{
		${{ camel_case($gen->entityName()) }} = $this->call({{ $gen->actionClass('Update') }}::class, [$request->id, $request->all()]);
		return $this->transform(${{ camel_case($gen->entityName()) }}, new {{ $gen->entityName() }}Transformer());
	}

	/**
	 * {{ $gen->hasSoftDeleteColumn ? 'Soft' : null }}Delete the specified resource from storage.
	 *
	 * @param {{ str_replace('.php', '', $gen->apiRequestFile('Delete', $plural = false)) }} $request
	 * @return Illuminate\Http\Response
	 */
	public function delete{{ $gen->entityName() }}({{ str_replace('.php', '', $gen->apiRequestFile('Delete', $plural = false)) }} $request)
	{
		${{ camel_case($gen->entityName()) }} = $this->call({{ $gen->actionClass('Delete') }}::class, [$request->id]);
		return $this->accepted('{{ $gen->entityName() }} Deleted Successfully.');
	}

@if($gen->hasSoftDeleteColumn)
	/**
	 * Restore the specified softDeleted resource from storage.
	 *
	 * @param {{ str_replace('.php', '', $gen->apiRequestFile('Restore', $plural = false)) }} $request
	 * @return Illuminate\Http\Response
	 */
	public function restore{{ $gen->entityName() }}({{ str_replace('.php', '', $gen->apiRequestFile('Restore', $plural = false)) }} $request)
	{
		${{ camel_case($gen->entityName()) }} = $this->call({{ $gen->actionClass('Restore') }}::class, [$request->id]);
		return $this->transform(${{ camel_case($gen->entityName()) }}, new {{ $gen->entityName() }}Transformer());
	}
@endif
}
