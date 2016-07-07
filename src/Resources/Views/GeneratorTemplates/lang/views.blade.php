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
     * cabeceras de tablas, labels de botones, de links, etc...
     */
    
    // nombre del módulo
    'module' => [
        'name' => '{!!$request->get('plural_entity_name')!!}',
        'short-name' => '{!!$request->get('plural_entity_name')!!}',
        'name-singular' => '{!!$request->get('single_entity_name')!!}',
    ],

    // vista index
    'index' => [
        'name' => 'Index',

        // botonera
        'create-button-label' => 'Crear {!!$request->get('single_entity_name')!!}',
        'delete-massively-button-label' => 'Borrar {!!$request->get('plural_entity_name')!!} seleccionados',
@if ($gen->hasDeletedAtColumn($fields))
        'restore-massively-button-label' => 'Restaurar Seleccionados',
@endif

<?php
//////////////////////////////////////////////////////////////////////////////////////////////////////////////
// si la entidad tiene softDeletes, podemos añadir las lineas para los formularios de restaurar registros y //
// las lineas de los filtros del formulario de búsqueda de registros "eliminados"                           //
//////////////////////////////////////////////////////////////////////////////////////////////////////////////
?>
        // lineas de las opciones de filtros del fomulario de búsqueda
@if ($gen->hasDeletedAtColumn($fields))
        'filter-with-trashed-label' => 'Con Reg. Borrados',
        'filter-only-trashed-label' => 'Sólo Reg. Borrados',

@if ($request->has('use_modal_confirmation_on_delete'))
        // ventana modal de confirmación de la acción del botón restaurar registro
        'modal-restore-title' => 'Está seguro?',
        'modal-restore-message' => 'La información de <strong>:item</strong> será <strong>Restaurada</strong>...',
        'modal-restore-btn-confirm-label' => 'Restaurar',
        'modal-restore-btn-confirm-class-name' => 'btn-success',

        // ventana modal de confirmación para acción del botón restaurar registros masivamente
        'modal-restore-massively-title' => 'Está seguro?',
        'modal-restore-massively-message' => 'La información de los elementos seleccionados será <strong>Restaurada</strong>...',
        'modal-restore-massively-btn-confirm-label' => 'Restaurar Todos',
        'modal-restore-massively-btn-confirm-class-name' => 'btn-success',

@else
        'restore-confirm-message' => 'Está seguro? El resgistro será RESTAURADO...',
        'restore-massively-confirm-message' => 'Está seguro? Todos los registros seleccionados serán RESTAURADOS...',

@endif
@endif
@if ($request->has('use_modal_confirmation_on_delete'))
        // ventana modal de confirmación de la acción del botón eliminar registro
        'modal-delete-title' => 'Está seguro?',
        'modal-delete-message' => 'La información de <strong>:item</strong> será <strong>BORRADA</strong>...',
        'modal-delete-btn-confirm-label' => 'Borrar',
        'modal-delete-btn-confirm-class-name' => 'btn-danger',

        // ventana modal de confirmación de la acción del botón eliminar registros masivamente
        'modal-delete-massively-title' => 'Está seguro?',
        'modal-delete-massively-message' => 'La información de los elementos seleccionados será <strong>BORRADA</strong>...',
        'modal-delete-massively-btn-confirm-label' => 'Borrar Todos',
        'modal-delete-massively-btn-confirm-class-name' => 'btn-danger',

        // los valores por defecto de las ventanas modales generadas con el componente Bootbox
        'modal-default-title' => 'Está Seguro?',
        'modal-default-btn-confirmation-label' => 'Confirmar',
        'modal-default-btn-confirmation-className' => 'btn-primary',
        'modal-default-btn-cancel-label' => 'Cancelar',
        'modal-default-btn-cancel-className' => 'btn-default',

@else
        'delete-confirm-message' => 'Está seguro? Toda la información será BORRADA...',
        'delete-massively-confirm-message' => 'Está seguro? Todos los registros seleccionados serán BORRADOS...',

@endif
        // botones y otros strings de la taba del index
        'filters-button-label' => 'Más Filtros',
        'search-button-label' => 'Buscar',
        'clean-filter-button-label' => 'Limpiar filtros',
        'see-details-button-label' => 'Ver detalles',
        'edit-item-button-label' => 'Editar registro',
        'delete-item-button-label' => 'Borrar registro',
        'create-form-modal-title' => 'Crear Nuevo {!!$request->get('single_entity_name')!!}',
@if ($gen->hasDeletedAtColumn($fields))
        'restore-row-button-label' => 'Restaurar',
@endif  
        'table-actions-column' => 'Acciones',
        'no-records-found' => 'No se encontraron registros...',

@if ($gen->hasDateFields($fields) || $gen->hasDateTimeFields($fields))
        // para el componente Bootstrap dateRangePicker
        'dateRangePicker' => [
            'applyLabel' => 'Aplicar',
            'cancelLabel' => 'Limpiar',
            'fromLabel' => 'Desde',
            'toLabel' => 'Hasta',
            'separator' => ' - ',
            'weekLabel' => 'S',
            'customRangeLabel' => 'Personalizado',
            'daysOfWeek' => "['Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi','Sa']",
            'monthNames' => "['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre']",
            'firstDay' => '1',
            // rangos predeterminados
            'range_today' => 'Hoy',
            'range_yesterday' => 'Ayer',
            'range_last_7_days' => 'Últimos 7 días',
            'range_last_30_days' => 'Últimos 30 días',
            'range_this_month' => 'Este mes',
            'range_last_month' => 'Mes pasado',
        ],
@endif
    ],

    // vista create
    'create' => [
        'name' => 'Crear',
        'btn-create' => 'Crear'
    ],

    // vista edit
    'edit' => [
        'name' => 'Actualizar',
        'link-access' => 'Editar',
        'btn-edit' => 'Actualizar',
    ],

    // vista show
    'show' => [
        'name' => 'Detalles',
        'long-name' => 'Detalles de {!!$request->get('single_entity_name')!!}',
        'btn-trash' => 'Mover a Papelera',
        'btn-edit' => 'Editar',
        'modal-confirm-trash-title' => 'Está Seguro?',
        'modal-confirm-trash-body' => 'La información de <strong>:item</strong> será movida a la papelera, sus datos no estarán disponibles...',
        'modal-confirm-trash-btn-confirm' => 'Confirmar',
        'modal-confirm-trash-btn-cancel' => 'Cancelar',
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
    'search_form' => [
        'find' => 'Buscar...',
        'btn-search' => 'Buscar',
        'btn-clean' => 'Quitar Filtros',
    ],

    // otros mensajes
    'inputs-required-help' => 'Los campos marcados con <strong>*</strong> son requeridos.'

];