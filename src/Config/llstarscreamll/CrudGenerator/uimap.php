<?php

/**
 * Este archivo es parte de llstarscreamll\CrudGenerator, aquí se muestran todas las opciones
 * de configuración del paquete.
 *
 * @license MIT
 * @package llstarscreamll\CrudGenerator
 */

return $uimap = [
	// para la vista index
	'module-title-selector'				=> '.content-header h1',
	'index-table-selector'				=> '.table.table-hover',

	// para la vista create
	'title-selector'					=> '.content-header h1 small',
	'create-form-button-selector'		=> 'button.btn.btn-primary',
	'msg-success-selector'		  		=> '.alert.alert-success',
	'msg-error-selector'		  		=> '.alert.alert-danger',

	// para la vista edit
	'edit-link-access-selector' 		=> 'a.btn.btn-warning',
	'edit-title-selector' 				=> '.content-header h1 small',
	'edit-message-success-selector'		=> '.alert.alert-success',

	// para la vista show
	'show-title-selector'				=> '.content-header h1 small',

	// para acciones de eliminación
	'delete-message-success-selector'	=> '.alert.alert-success',
	'no-data-found-selector'			=> 'table .alert.alert-warning',
];
