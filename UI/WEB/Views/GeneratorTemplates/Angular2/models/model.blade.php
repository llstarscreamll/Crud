@foreach ($fields->unique('namespace') as $field)
@if (!empty($field->relation))
import { {{ class_basename($field->namespace) }} } from './../../{{ $crud->ngSlugModuleFromNamespace($field->namespace) }}/models/{{ camel_case(class_basename($field->namespace)) }}';
@endif
@endforeach

/**
 * {{ $crud->entityName() }} Class.
 *
 * @author [name] <[<email address>]>
 */
export class {{ $crud->entityName() }} {
@foreach ($fields as $field)
@if (!$field->hidden)
	{{ $field->name }}: {{ $crud->jsDataTypeFromField($field) }};
@endif
@endforeach
@foreach ($fields as $field)
@if (!empty($field->relation))
	{{  $crud->relationNameFromField($field)  }}: { data: {{ class_basename($field->namespace) }} };
@endif
@endforeach
}
