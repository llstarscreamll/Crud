<?= "<?php\n" ?>

namespace App\Containers\{{ $crud->containerName() }}\Tasks{{ $crud->solveGroupClasses() }};

use App\Containers\{{ $crud->containerName() }}\Data\Repositories\{{ $repoClass = $crud->entityName().'Repository' }};
use App\Containers\{{ $crud->containerName() }}\Data\Criterias\{{ $advencedSearchCriteria = str_replace('.php', '', $crud->criteriaFile('Advanced-entity-Search')) }};
use Prettus\Repository\Criteria\RequestCriteria;
use App\Ship\Parents\Tasks\Task;

/**
 * {{ $crud->taskClass('ListAndSearch', $plural = true) }} Class.
 * 
 * @author [name] <[<email address>]>
 */
class {{ $crud->taskClass('ListAndSearch', $plural = true) }} extends Task
{
	public function run($input) {
		{!! $repo = '$'.camel_case($repoClass) !!} = app({{ $repoClass }}::class);

		if ($input->get('advanced_search', false)) {
			{{ $repo }}
				->popCriteria(RequestCriteria::class)
				->pushCriteria(new {{ $advencedSearchCriteria }}($input));
		}
        
        ${{ $camelEntity = camel_case($crud->entityName(true)) }} = {{ $repo }}->paginate();
        
        return ${{ $camelEntity }};
	}
}
