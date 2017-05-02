<?= "<?php\n" ?>

namespace App\Containers\{{ $gen->containerName() }}\Actions\{{ $gen->entityName() }};

@foreach ($fields->unique('namespace') as $field)
@if ($field->namespace)
use {{ $gen->namespacedRepoFromModelNamespace($field->namespace) }};
use {{ $gen->namespacedTransformerFromModelNamespace($field->namespace) }};
@endif
@endforeach
use App\Ship\Parents\Actions\Action;
use Fractal;

/**
 * {{ $gen->actionClass('FormData', false, true) }} Class.
 */
class {{ $gen->actionClass('FormData', false, true) }} extends Action
{
	/**
	 * Creates new {{ $gen->actionClass('FormData', false, true) }} class instance.
	 */
	public function __construct(
@foreach ($fields->filter(function($value) {return $value->namespace;})->unique('namespace') as $field)
@if ($field->namespace)
		{{ class_basename($namespace = $gen->namespacedRepoFromModelNamespace($field->namespace)) }} {{ $gen->variableFromNamespace($namespace) }} {{ $loop->last === true ? '' : ',' }}
@endif
@endforeach
	) {
@foreach ($fields->unique('namespace') as $field)
@if ($field->namespace)
		{!! str_replace('$', '$this->', $gen->variableFromNamespace($namespace = $gen->namespacedRepoFromModelNamespace($field->namespace))) !!} = {{ $gen->variableFromNamespace($namespace) }};
@endif
@endforeach
	}

	public function run()
	{
		return [
@foreach ($fields->unique('namespace') as $field)
@if ($field->namespace)
			'{!! studly_case(str_replace(['$'], [''], $gen->variableFromNamespace($field->namespace, false))) !!}' => Fractal::create(
				app({{ class_basename($gen->namespacedRepoFromModelNamespace($field->namespace)) }}::class)->all(['id', 'name']),
				app({{ class_basename($gen->namespacedTransformerFromModelNamespace($field->namespace)) }}::class)
			)->toArray()['data'],
@endif
@endforeach	
		];
	}
}
