export const {{ $gen->entityNameSnakeCase() }} = {
  '{{ $gen->entityNameSnakeCase() }}': {
    'module-name-plural': '{{ $gen->request->get('plural_entity_name') }}',
    'module-name-singular': '{{ $entity = $gen->request->get('single_entity_name') }}',

    'form-page': '{{ trans('crud::templates.form_of', ['item' => $gen->request->get('single_entity_name')]) }}',

    'create': '{{ trans('crud::templates.create') }}',
    'details': '{{ trans('crud::templates.details') }}',
    'edit': '{{ trans('crud::templates.edit') }}',
    'delete': '{{ trans('crud::templates.delete') }}',
    'see_all': '{{ trans('crud::templates.see_all') }}',
    'msg': {
      'create_succcess': '{{ trans('crud::templates.create_success', ['item' => $gen->request->get('single_entity_name')]) }}',
      'update_succcess': '{{ trans('crud::templates.update_success', ['item' => $gen->request->get('single_entity_name')]) }}',
      'delete_succcess': '{{ trans('crud::templates.delete_success', ['item' => $gen->request->get('single_entity_name')]) }}',
      'restore_succcess': '{{ trans('crud::templates.restore_success', ['item' => $gen->request->get('single_entity_name')]) }}',
      'no_rows_found': '{{ trans('crud::templates.no_rows_found') }}',
    },

    'delete-alert': {
      'title': '{{ trans('crud::templates.confirm_title') }}',
      'text': '{{ trans('crud::templates.confirm_delete_text') }}',
      'confirm_btn_text': '{{ trans('crud::templates.confirm_delete_btn_text') }}',
      'cancel_btn_text': '{{ trans('crud::templates.confirm_cancel_btn_text') }}',
    },
    
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
