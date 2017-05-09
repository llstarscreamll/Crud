<?= "<?php\n" ?>

namespace App\Containers\{{ $gen->containerName() }}\Tasks\{{ $gen->entityName() }};

use App\Containers\{{ $gen->containerName() }}\Data\Repositories\{{ $repoClass = $gen->entityName().'Repository' }};
use App\Containers\{{ $gen->containerName() }}\Data\Criterias\{{ $gen->entityName() }}\{{ $advencedSearchCriteria = str_replace('.php', '', $gen->criteriaFile('Advanced:entity:Search')) }};
use App\Ship\Parents\Tasks\Task;
use Prettus\Repository\Criteria\RequestCriteria;

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
