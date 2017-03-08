export const ES = {
  '{{ $gen->entityNameUppercase() }}': {
    'module-name-singular': '{{ $entity = $gen->request->get('single_entity_name') }}',
    'module-name-plural': '{{ $gen->request->get('plural_entity_name') }}',
    'create': '{{ trans('crud::templates.create-link') }}',
    'create-btn': '{{ trans('crud::templates.create-link') }}',
    'edit': '{{ trans('crud::templates.edit-link') }}',
    'delete': '{{ trans('crud::templates.delete-link') }}',
    // form fields
    'fields': {
@foreach ($fields as $field)
      '{{ $gen->tableName.'.'.$field->name }}': '{{ $field->label }}',
@if (strrpos($field->validation_rules, 'confirmed'))
      '{{ $gen->tableName.'.'.$field->name.'_confirmation' }}': '{{ trans('crud::templates.confirm_field_prefix').' '.strtolower($field->label) }}',
@endif
@if ($field->type == "enum")
      '{{ $gen->tableName.'.'.$field->name }}-options': {
@foreach ($gen->getEnumValuesArray($field->name) as $option)
        '{{ $option }}': '{{ $option }}',
@endforeach
      },
@endif
@endforeach
    }
  }
}
