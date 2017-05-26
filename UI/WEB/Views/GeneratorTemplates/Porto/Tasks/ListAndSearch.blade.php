<?= "<?php\n" ?>

namespace App\Containers\{{ $gen->containerName() }}\Tasks{{ $gen->solveGroupClasses() }};

use App\Containers\{{ $gen->containerName() }}\Data\Repositories\{{ $repoClass = $gen->entityName().'Repository' }};
use App\Containers\{{ $gen->containerName() }}\Data\Criterias\{{ $advencedSearchCriteria = str_replace('.php', '', $gen->criteriaFile('Advanced:entity:Search')) }};
use Prettus\Repository\Criteria\RequestCriteria;
use App\Ship\Parents\Tasks\Task;

/**
 * {{ $gen->taskClass('ListAndSearch', $plural = true) }} Class.
 * 
 * @author [name] <[<email address>]>
 */
class {{ $gen->taskClass('ListAndSearch', $plural = true) }} extends Task
{
	public function run($input) {
		{!! $repo = '$'.camel_case($repoClass) !!} = app({{ $repoClass }}::class);

		if ($input->get('advanced_search', false)) {
			{{ $repo }}
				->popCriteria(RequestCriteria::class)
				->pushCriteria(new {{ $advencedSearchCriteria }}($input));
		}
        
        ${{ $camelEntity = camel_case($gen->entityName(true)) }} = {{ $repo }}->paginate();
        
        return ${{ $camelEntity }};
	}
}
