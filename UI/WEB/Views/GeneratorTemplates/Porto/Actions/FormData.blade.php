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
 * 
 * @author [name] <[<email address>]>
 */
class {{ $gen->actionClass('FormData', false, true) }} extends Action
{
	public function run()
	{
		return [
@foreach ($fields->unique('namespace') as $field)
@if ($field->namespace)
			'{!! str_plural(class_basename($field->namespace)) !!}' => app({{ class_basename($gen->namespacedRepoFromModelNamespace($field->namespace)) }}::class)->selectList(),
@endif
@endforeach
		];
	}
}
