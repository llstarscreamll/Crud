<?= "<?php\n" ?>

namespace App\Containers\{{ $gen->containerName() }}\Tasks\{{ $gen->entityName() }};

use App\Ship\Parents\Tasks\Task;

/**
 * {{ $gen->taskClass('Create') }} Class.
 */
class {{ $gen->taskClass('Create') }} extends Task
{
	/**
	 * @var {{ $repoClass = $gen->entityRepoClass() }}
	 */
	private ${{ camel_case($repoClass) }};

	/**
	 * Create new {{ $gen->taskClass('Create') }} class instance.
	 * @param
	 */
	public function __construct({{ $repoClass }} ${{ camel_case($repoClass) }})
	{
		$this->{{ camel_case($repoClass) }} = ${{ camel_case($repoClass) }};
	}

	public function run(
		@foreach ($fields->filter(function ($field) { return $field->fillable; }) as $field)
		@if($field->fillable)
			${{ $field->name }}@if(!$loop->last){{ ",\n" }}@endif
		@endif
		@endforeach
	) {
		try {
            ${{ $camelEntity = camel_case($gen->entityName()) }} = $this->{{ camel_case($repoClass) }}->create([
@foreach ($fields->filter(function ($field) { return $field->fillable; }) as $field)
@if($field->fillable)
					'{{ $field->name }}' => ${{ $field->name }}@if(!$loop->last){{ ",\n" }}@endif
@endif
@endforeach
            {{ "\n" }}]);
        } catch (Exception $e) {
            throw (new AccountFailedException())->debug($e);
        }

        return ${{ $camelEntity }};
	}
}
