<?= "<?php\n" ?>

namespace App\Containers\{{ $gen->containerName() }}\Actions\{{ $gen->entityName() }};

@foreach ($fields as $field)
@if ($field->namespace)
use {{ $gen->namespacedRepoFromModelNamespace($field->namespace) }};
@endif
@endforeach
use App\Ship\Parents\Actions\Action;

/**
 * {{ $gen->actionClass('FormData', false, true) }} Class.
 */
class {{ $gen->actionClass('FormData', false, true) }} extends Action
{
	/**
	 * Creates new {{ $gen->actionClass('FormData', false, true) }} class instance.
	 */
	public function __construct(
@foreach ($fields->filter(function($value) {return $value->namespace;}) as $field)
@if ($field->namespace)
		{{ class_basename($namespace = $gen->namespacedRepoFromModelNamespace($field->namespace)) }} {{ $gen->variableFromNamespace($namespace) }} {{ $loop->last === true ? '' : ',' }}
@endif
@endforeach
	) {
@foreach ($fields as $field)
@if ($field->namespace)
		{!! str_replace('$', '$this->', $gen->variableFromNamespace($namespace = $gen->namespacedRepoFromModelNamespace($field->namespace))) !!} = {{ $gen->variableFromNamespace($namespace) }};
@endif
@endforeach	
	}

	public function run()
	{
		return [
@foreach ($fields as $field)
@if ($field->namespace)
			'{!! studly_case(str_replace(['$'], [''], $gen->variableFromNamespace($field->namespace, false))) !!}' => {!! str_replace('$', '$this->', $gen->variableFromNamespace($gen->namespacedRepoFromModelNamespace($field->namespace))) !!}->all(['id', 'name']),
@endif
@endforeach	
		];
	}
}
