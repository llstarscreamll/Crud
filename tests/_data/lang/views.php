<?php

/**
 * Este archivo es parte del Módulo Libros.
 * (c) Johan Alvarez <llstarscreamll@hotmail.com>
 * Licensed under The MIT License (MIT).

 * @package    Módulo Libros.
 * @version    0.1
 * @author     Johan Alvarez.
 * @license    The MIT License (MIT).
 * @copyright  (c) 2015-2016, Johan Alvarez <llstarscreamll@hotmail.com>.
 * @link       https://github.com/llstarscreamll.
 */

return [

    /**
     * Los textos de las vistas como por ejemplo los labels de los campos del fomulario,
     * cabeceras de tablas, labels de botones, de links, etc...
     */
    
    // nombre del módulo
    'module' => [
        'name' => 'Libros',
        'short-name' => 'Libros',
        'name-singular' => 'Libro',
    ],

    // vista index
    'index' => [
        'name' => 'Index',

        // botonera
        'create-button-label' => 'Crear Libro',
        'delete-massively-button-label' => 'Borrar Libros seleccionados',
        'restore-massively-button-label' => 'Restaurar Seleccionados',

        // lineas de las opciones de filtros del fomulario de búsqueda
        'filter-with-trashed-label' => 'Con Reg. Borrados',
        'filter-only-trashed-label' => 'Sólo Reg. Borrados',

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

        // botones y otros strings de la taba del index
        'filters-button-label' => 'Más Filtros',
        'search-button-label' => 'Buscar',
        'clean-filter-button-label' => 'Limpiar filtros',
        'see-details-button-label' => 'Ver detalles',
        'edit-item-button-label' => 'Editar registro',
        'delete-item-button-label' => 'Borrar registro',
        'create-form-modal-title' => 'Crear Nuevo Libro',
        'restore-row-button-label' => 'Restaurar',
  
        'table-actions-column' => 'Acciones',
        'no-records-found' => 'No se encontraron registros...',

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

        'x-editable' => [
            'dafaultValue' => '---'
        ],
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
        'long-name' => 'Detalles de Libro',
        'btn-trash' => 'Mover a Papelera',
        'btn-edit' => 'Editar',
        'modal-confirm-trash-title' => 'Está Seguro?',
        'modal-confirm-trash-body' => 'La información de <strong>:item</strong> será movida a la papelera, sus datos no estarán disponibles...',
        'modal-confirm-trash-btn-confirm' => 'Confirmar',
        'modal-confirm-trash-btn-cancel' => 'Cancelar',
    ],
    
    // nombres de los elementos del formulario de creación/edición
    'form-fields' => [
        'id' => 'Id',
        'reason_id' => 'Motivo *',
        'name' => 'Nombre *',
        'author' => 'Autor *',
        'genre' => 'Género *',
        'stars' => 'Estrellas *',
        'published_year' => 'Fecha De Publicación *',
        'enabled' => 'Activado?',
        'status' => 'Estado *',
        'unlocking_word' => 'Palabra De Desbloqueo *',
        'unlocking_word_confirmation' => 'Confirmar Palabra De Desbloqueo *',
        'synopsis' => 'Sinopsis',
        'approved_at' => 'Fecha De Aprobación',
        'approved_by' => 'Usuario Que Aprobó',
        'approved_password' => 'Contraseña De Aprobación',
        'created_at' => 'Fecha De Creación',
        'updated_at' => 'Fecha De Actualización',
        'deleted_at' => 'Fecha De Eliminiación',
    ],

    // nombres cortos de los elementos del formulario, para la tabla del index
    'form-fields-short-name' => [
        'id' => 'Id',
        'reason_id' => 'Motivo',
        'name' => 'Nombre',
        'author' => 'Autor',
        'genre' => 'Género',
        'stars' => 'Estrellas',
        'published_year' => 'Fecha De Publicación',
        'enabled' => 'Activado?',
        'status' => 'Estado',
        'unlocking_word' => 'Palabra De Desbloqueo',
        'synopsis' => 'Sinopsis',
        'approved_at' => 'Fecha De Aprobación',
        'approved_by' => 'Usuario Que Aprobó',
        'approved_password' => 'Contraseña De Aprobación',
        'created_at' => 'Fecha De Creación',
        'updated_at' => 'Fecha De Actualización',
        'deleted_at' => 'Fecha De Eliminiación',
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