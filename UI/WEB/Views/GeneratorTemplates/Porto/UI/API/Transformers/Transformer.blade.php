<?= "<?php\n" ?>

namespace App\Containers\{{ $crud->containerName() }}\UI\API\Transformers;

use App\Ship\Parents\Transformers\Transformer;
@foreach ($fields->unique('namespace') as $field)
@if ($field->namespace)
use {{ str_replace('Models', 'UI\API\Transformers', $field->namespace) }}Transformer;
@endif
@endforeach
use App\Containers\{{ $crud->containerName() }}\Models\{{ $crud->entityName() }};

/**
 * {{ $crud->entityName() }}Transformer Class.
 * 
 * @author [name] <[<email address>]>
 */
class {{ $crud->entityName() }}Transformer extends Transformer
{
	/**
	 * @var array
	 */
	protected $availableIncludes = [
@foreach ($fields as $field)
@if($field->namespace)
        '{{ $crud->relationNameFromField($field) }}',
@endif
@endforeach
    ];

	/**
     * @var array
     */
    protected $defaultIncludes = [];

    /**
     * @param App\Containers\{{ $crud->containerName() }}\Models\{{ $crud->entityName() }} ${{ camel_case($entityClass = $crud->entityName()) }}
     *
     * @return array
     */
    public function transform({{ $entityClass }} ${{ camel_case($entityClass) }})
    {
    	$response = [
    		'object' => '{{ $entityClass }}',
@foreach ($fields as $field)
@if ($field->name === "id")
			'{{ $field->name }}' => ${{ camel_case($entityClass) }}->getHashedKey(),
@endif
@if(!$field->hidden && $field->namespace)
            '{{ $field->name }}' => $this->hashKey(${{ camel_case($entityClass) }}->{{ $field->name }}),
@elseif(!$field->hidden && $field->name !== "id")
			'{{ $field->name }}' => ${{ camel_case($entityClass) }}->{{ $field->name }},
@endif
@if(!$field->hidden && in_array($field->type, ['datetime', 'timestamp']))
            '{{ $field->name }}' => ${{ camel_case($entityClass) }}->{{ $field->name }} ? ${{ camel_case($entityClass) }}->{{ $field->name }}->toDateTimeString() : null,
@endif
@endforeach
    	];

        $response = $this->ifAdmin([
            'real_id' => ${{ camel_case($entityClass) }}->id,
        ], $response);

        return $response;
    }
@foreach ($fields as $field)
@if ($field->namespace)

    public function include{{ studly_case($crud->relationNameFromField($field))  }}({{ $entityClass }} ${{ camel_case($entityClass) }})
    {
        return ${{ camel_case($entityClass) }}->{{  $crud->relationNameFromField($field)  }}
            ? $this->{{ in_array($field->relation, ['belongsTo', 'hasOne']) ? 'item' : 'collection' }}(${{ camel_case($entityClass) }}->{{  $crud->relationNameFromField($field)  }}, new {{ class_basename($field->namespace) }}Transformer())
            : null;
    }
@endif
@endforeach
}