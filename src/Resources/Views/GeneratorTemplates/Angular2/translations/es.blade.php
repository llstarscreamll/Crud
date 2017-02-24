export const ES = {
  '{{ $gen->entityNameUppercase() }}': {
    'module-name-singular': '{{ $gen->request->get('singular_entity_name') }}',
    'module-name-plural': '{{ $gen->request->get('plural_entity_name') }}',
    // form fields
    'fields': {
@foreach ($fields as $field)
      '{{ $field->name }}': '{{ $field->label }}',
@endforeach
    }
  }
}
