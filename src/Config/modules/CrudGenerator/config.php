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
        'partials/index-table-header',
        'partials/index-table-search',
        'partials/index-table-body',
        'index',
        'edit',
        'show',
        'create',
    ],

    'tests' => [
        'Index',
        'Create',
        'Edit',
        'Show',
        'Destroy',
        'Permissions'
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

    // los namespace del modelo de usuario
    'user-model-namespace' => 'llstarscreamll\Core\Models\User',
    'permission-model-namespace' => 'llstarscreamll\Core\Models\Permission',
    'role-model-namespace' => 'llstarscreamll\Core\Models\Role',
    // el nombre del seeder del usuario de prueba
    'test-users-seeder-class' => 'DefaultUsersTableSeeder',
    // el nombre del seeder de la tabla roles
    'test-roles-seeder-class' => 'RoleTableSeeder',
    'permission-slug-field-name' => 'slug',
    'permission-name-field-name' => 'name',

    'permissions-middleware' => 'permission',
    'permissions-middleware-msg' => 'No tienes permisos para realizar esta acción.',

    // tipos de datos de tablas numéricos
    'numeric-input-types'   => ['int','unsigned_int','float','double'],

    // campos de control del sistema, para imprimir en vista show
    'system-fields' => ['created_at', 'updated_at', 'deleted_at'],

    // docblock copyright info
    'author' => 'Johan Alvarez',
    'author_email' => 'llstarscreamll@hotmail.com',
    'license' => 'The MIT License (MIT)',
    'license_small' => 'MIT',
    'copyright' => '(c) 2015-'.date('Y').', Johan Alvarez <llstarscreamll@hotmail.com>',
    'link' => 'https://github.com/llstarscreamll',
];
