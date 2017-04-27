<?= "<?php\n" ?>

namespace App\Containers\{{ $gen->containerName() }}\UI\API\Transformers;

use App\Ship\Parents\Transformers\Transformer;
@foreach ($fields as $field)
@if ($field->namespace)
use {{ str_replace('Models', 'UI\API\Transformers', $field->namespace) }}Transformer;
@endif
@endforeach
use App\Containers\{{ $gen->containerName() }}\Models\{{ $gen->entityName() }};

/**
 * {{ $gen->entityName() }}Transformer Class.
 */
class {{ $gen->entityName() }}Transformer extends Transformer
{
	/**
	 * @var array
	 */
	protected $availableIncludes = [
@foreach ($fields as $field)
@if($field->namespace)
        '{{ $gen->relationNameFromField($field) }}',
@endif
@endforeach
    ];

	/**
     * @var array
     */
    protected $defaultIncludes = [];

    /**
     * @param App\Containers\{{ $gen->containerName() }}\Models\{{ $gen->entityName() }} ${{ camel_case($entityClass = $gen->entityName()) }}
     *
     * @return array
     */
    public function transform({{ $entityClass }} ${{ camel_case($entityClass) }})
    {
    	return $response = [
    		'object' => '{{ $entityClass }}',
@foreach ($fields as $field)
@if ($field->name === "id")
			'{{ $field->name }}' => ${{ camel_case($entityClass) }}->getHashedKey(),
@endif
@if(!$field->hidden && $field->namespace)
            '{{ $field->name }}' => ${{ camel_case($entityClass) }}->{{ $gen->relationNameFromField($field) }} ? ${{ camel_case($entityClass) }}->{{ $gen->relationNameFromField($field) }}->getHashedKey() : null,
@elseif(!$field->hidden && $field->name !== "id")
			'{{ $field->name }}' => ${{ camel_case($entityClass) }}->{{ $field->name }},
@endif
@if(!$field->hidden && in_array($field->type, ['datetime', 'timestamp']))
            '{{ $field->name }}' => ${{ camel_case($entityClass) }}->{{ $field->name }} ? ${{ camel_case($entityClass) }}->{{ $field->name }}->toDateTimeString() : null,
@endif
@endforeach
    	];
    }
@foreach ($fields as $field)
@if ($field->namespace)

    public function include{{ studly_case($gen->relationNameFromField($field))  }}({{ $entityClass }} ${{ camel_case($entityClass) }})
    {
        return ${{ camel_case($entityClass) }}->{{  $gen->relationNameFromField($field)  }}
            ? $this->{{ in_array($field->relation, ['belongsTo', 'hasOne']) ? 'item' : 'collection' }}(${{ camel_case($entityClass) }}->{{  $gen->relationNameFromField($field)  }}, new {{ class_basename($field->namespace) }}Transformer())
            : null;
    }
@endif
@endforeach
}