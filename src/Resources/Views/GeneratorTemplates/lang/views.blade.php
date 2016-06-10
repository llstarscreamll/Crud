<?php
/* @var $gen llstarscreamll\CrudGenerator\Providers\TestsGenerator */
/* @var $fields [] */
/* @var $test [] */
/* @var $request [] */
?>
<?='<?php'?>

return [

    /**
     * Los textos de las vistas como por ejemplo los labels de los campos del fomulario,
     * cabeceras de tablas, etc...
     */
    
    // nombre del módulo
    'module'   => [
        'name'           => '{!!$request->get('plural_entity_name')!!}',
        'short-name'     => '{!!$request->get('plural_entity_name')!!}',
        'name-singular'  => '{!!$request->get('single_entity_name')!!}',
    ],

    // vista index
    'index'    => [
        'name'          => 'Index',
        'btn-trash'     => 'Mover {!!$request->get('plural_entity_name')!!} a Papelera',
        'btn-create'    => 'Crear {!!$request->get('single_entity_name')!!}',
        'table-actions-column' => 'Acciones',
        'search-button'         => 'Buscar',
        'clean-filter'          => 'Limpiar filtros',
        'see-details-button'    => 'Ver detalles',
        'edit-item-button'      => 'Editar registro',
        'delete-item-button'    => 'Borrar registro',
        'no-records-found'      => 'No se encontraron registros...',
        'create-form-modal-title'   => 'Crear Nuevo {!!$request->get('single_entity_name')!!}',
    ],

    // vista create
    'create'    => [
        'name'          => 'Crear',
        'btn-create'    => 'Crear'
    ],

    // vista edit
    'edit'    => [
        'name'          => 'Actualizar',
        'link-access'   => 'Editar',
        'btn-edit'      => 'Actualizar',
    ],

    // vista show
    'show'    => [
        'name'                                      => 'Detalles',
        'long-name'                                 => 'Detalles de {!!$request->get('single_entity_name')!!}',
        'btn-trash'                                 => 'Mover a Papelera',
        'btn-edit'                                  => 'Editar',
        'modal-confirm-trash-title'                 => 'Está Seguro?',
        'modal-confirm-trash-body'                  => 'La información de <strong>:item</strong> será movida a la papelera, sus datos no estarán disponibles...',
        'modal-confirm-trash-btn-confirm'           => 'Confirmar',
        'modal-confirm-trash-btn-cancel'            => 'Cancelar',
    ],
    
    // nombres de los elementos del formulario de creación/edición
    'form-fields' => [
@foreach($fields as $field)
        '{{$field->name}}' => '{!!$gen->getFormFieldName($field->label).($gen->isTheFieldRequired($field) ? ' *' : '')!!}',
@if(strpos($field->validation_rules, 'confirmed'))
        '{{$field->name}}_confirmation' => '{!!$gen->getFormFieldName("Confirmar ".$field->label).($gen->isTheFieldRequired($field) ? ' *' : '')!!}',
@endif
@endforeach
    ],

    // nombres cortos de los elementos del formulario, para la tabla del index
    'form-fields-short-name' => [
@foreach($fields as $field)
        '{{$field->name}}' => '{!!$gen->getFormFieldName($field->label)!!}',
@endforeach
    ],

    // el formulario de búsqueda
    'search_form'   => [
        'find'              => 'Buscar...',
        'btn-search'        => 'Buscar',
        'btn-clean'         => 'Quitar Filtros',
    ],

    // otros mensajes
    'inputs-required-help'  => 'Los campos marcados con <strong>*</strong> son requeridos.'

];