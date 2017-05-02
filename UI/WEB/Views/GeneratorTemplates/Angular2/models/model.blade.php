import { Timestamps } from './../../core/models/date';
@foreach ($fields->unique('namespace') as $field)
@if (!empty($field->relation))
import { {{ class_basename($field->namespace) }} } from './../../{{ $gen->ngSlugModuleFromNamespace($field->namespace) }}/models/{{ camel_case(class_basename($field->namespace)) }}';
@endif
@endforeach

export class {{ $gen->entityName() }} {
@foreach ($fields as $field)
@if (!$field->hidden)
	{{ $field->name }}: {{ $gen->jsDataTypeFromField($field) }};
@endif
@endforeach
@foreach ($fields as $field)
@if (!empty($field->relation))
	{{  $gen->relationNameFromField($field)  }}: { data: {{ class_basename($field->namespace) }} };
@endif
@endforeach
}
