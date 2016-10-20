<?php

/**
 * Este archivo es parte de llstarscreamll\CrudGenerator, aquí se muestran todas
 * las opciones de configuración del paquete.
 *
 * @license MIT
 * @package llstarscreamll\CrudGenerator
 */

return $config = [

    /**
     * Información del paquete.
     */
    'module-info'   =>  [
        'name'      =>  'CrudGenerator',
    ],

    'supported_ui_themes' => ['Bootstrap', 'Inspinia'],

    /*
     * Las vistas que serán generadas.
     */
    'views' => [
        'partials/form-scripts',
        'partials/form-assets',
        'partials/heading',
        'partials/index-assets',
        'partials/index-buttons',
        'partials/form-fields',
        'partials/hidden-form-fields',
        'partials/index-create-form',
        'partials/index-table',
        'index',
        'edit',
        'show',
        'create',
    ],

    'tests' => [
        'Base',
        'Index',
        'Create',
        'Edit',
        'Show',
        'Delete'
    ],

    /*
     * El direcotrio que contiene las plantillas para generar vistas y clases.
     */
    'templates' => 'crud::GeneratorTemplates',

    /**
     * Aquí indicas si quieres que el formulario decreación de registro esté incluido en el index
     */
    'show-create-form-on-index'  => true,

    /**
     * La plantilla que las vistas generadas extenderán
     */
    'layout'    => 'core::layouts.app-sidebar',
    'layout-namespace'    => 'core::',
    'core-assets-namespase' => 'core/', // no olvidar el "/" si es que hay namespace

    // el namespace de las clases a generar
    'parent-app-namespace'  => 'App',

    // tipos de datos de tablas numéricos
    'numeric-input-types'   => ['int','unsigned_int','float','double'],

    // campos de control del sistema, para imprimir en vista show
    'system-fields' => ['created_at', 'updated_at', 'deleted_at'],
];
