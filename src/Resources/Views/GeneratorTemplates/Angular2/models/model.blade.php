import { Timestamps } from './../../core/models/date';

export class {{ $gen->entityName() }} {
@foreach ($fields as $field)
@if (!$field->hidden)
	{{ $field->name }}: {{ $gen->jsDataTypeFromField($field) }};
@endif
@endforeach
@foreach ($fields as $field)
@if (!empty($field->relation))
	{{  $gen->relationNameFromField($field)  }}: { data: {name: ''} };
@endif
@endforeach
}
