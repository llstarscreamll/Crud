export const ES = {
  '{{ $gen->entityNameUppercase() }}': {
    'module-name-singular': '{{ $entity = $gen->request->get('single_entity_name') }}',
    'module-name-plural': '{{ $gen->request->get('plural_entity_name') }}',
    'create': '{{ trans('crud::templates.create-link') }}',
    'edit': '{{ trans('crud::templates.edit-link') }}',
    'delete': '{{ trans('crud::templates.delete-link') }}',
    // form fields
    'fields': {
@foreach ($fields as $field)
      '{{ $gen->tableName.'.'.$field->name }}': '{{ $field->label }}',
@endforeach
    }
  }
}
