<?php

/**
 * Este archivo es parte de llstarscreamll\CrudGenerator, aquí se muestran todas las opciones
 * de configuración del paquete.
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
        'version'   =>  '0.1',
        'enabled'   =>  true,
    ],

    /*
     * Las vistas que serán generadas.
     */
    'views' => [
        'partials/create-form',
        'partials/index-create-form',
        'index',
        'edit',
        'show',
        'create',
    ],

    /*
     * El direcotrio que contiene las plantillas.
     */
    'templates' => 'vendor.CrudGenerator.single-page-templates',

    /**
     * Aquí indicas si quieres que el formulario decreación de registro esté incluido en el index
     */
    'show-create-form-on-index'  => true,

    /**
     * La plantilla que las vistas generadas extenderán
     */
    'layout'    => 'CoreModule::app'
];
