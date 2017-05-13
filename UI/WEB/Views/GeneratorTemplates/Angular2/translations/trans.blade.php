/**
 * {{ $gen->entityName() }} {{ $gen->getLanguageKey(true) }} Translations.
 *
 * @author [name] <[<email address>]>
 */
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
    'search_field_placeholder': '{{ trans('crud::templates.search_field_placeholder') }}',
    'search_btn': '{{ trans('crud::templates.search_btn') }}',
    'cancel_modal_btn': '{{ trans('crud::templates.cancel_modal_btn') }}',
    'actions_table_header': '{{ trans('crud::templates.actions_table_header') }}',
    'loading_items_list': '{{ trans('crud::templates.loading_items_list', ['entity' => strtolower($gen->request->get('plural_entity_name'))]) }}',

    'advanced_search': {
      'title': '{{ trans('crud::templates.advanced_search') }}',
      'options_tab_title': '{{ trans('crud::templates.options_tab_title') }}',
      'search_tab_title': '{{ trans('crud::templates.search_tab_title') }}',
      'apply_btn': '{{ trans('crud::templates.advanced_search_apply_btn') }}'
    },

    'msg': {
      'create_success': '{{ trans('crud::templates.create_success', ['item' => $gen->request->get('single_entity_name')]) }}',
      'update_success': '{{ trans('crud::templates.update_success', ['item' => $gen->request->get('single_entity_name')]) }}',
      'delete_success': '{{ trans('crud::templates.delete_success', ['item' => $gen->request->get('single_entity_name')]) }}',
      'restore_success': '{{ trans('crud::templates.restore_success', ['item' => $gen->request->get('single_entity_name')]) }}',
      'no_rows_found': '{{ trans('crud::templates.no_rows_found') }}',
@if($gen->hasSoftDeleteColumn)
      'item_trashed': '{{ trans('crud::templates.item_trashed', ['entity' => strtolower($gen->request->get('single_entity_name'))]) }}',
      'softdeleted_rows_info': '{{ trans('crud::templates.softdeleted_rows_info') }}',
@endif
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
    },

    'paginator': {
      'first_text': '{{ trans('crud::templates.paginator.first_text') }}',
      'last_text': '{{ trans('crud::templates.paginator.last_text') }}',
      'next_text': '{{ trans('crud::templates.paginator.next_text') }}',
      'previous_text': '{{ trans('crud::templates.paginator.previous_text') }}',
    },
  },
}
