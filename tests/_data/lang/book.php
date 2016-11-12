<?php

/**
 * Este archivo es parte de Books.
 * (c) Johan Alvarez <llstarscreamll@hotmail.com>
 * Licensed under The MIT License (MIT).
 *
 * @package    Books
 * @version    0.1
 * @author     Johan Alvarez
 * @license    The MIT License (MIT)
 * @copyright  (c) 2015-2016, Johan Alvarez <llstarscreamll@hotmail.com>
 * @link       https://github.com/llstarscreamll
 */

return [

    /**
     * Líneas de idioma en español para la interfaz, mensajes de validación,
     * nombres de campos de validación, mensajes de transacciones, etc...
     */
    
    // nombre del módulo
    'module' => [
        'name' => 'Libros',
        'short-name' => 'Libros',
        'name-singular' => 'Libro',
    ],

    'index-create-btn' => 'Crear Libro',
    'index-create-form-modal-title' => 'Crear Nuevo Libro',
    
    // nombres de los elementos del formulario
    'form-labels' => [
        'id' => 'Id',
        'reason_id' => 'Motivo *',
        'name' => 'Nombre *',
        'author' => 'Autor *',
        'genre' => 'Género *',
        'stars' => 'Estrellas *',
        'published_year' => 'Fecha de publicación *',
        'enabled' => 'Activado?',
        'status' => 'Estado *',
        'status_values' => ['setting_documents','waiting_confirmation','reviewing','approved'],
        'unlocking_word' => 'Palabra de desbloqueo *',
        'unlocking_word_confirmation' => 'Confirmar palabra de desbloqueo *',
        'synopsis' => 'Sinopsis',
        'approved_at' => 'Fecha de aprobación',
        'approved_by' => 'Usuario que aprobó',
        'approved_password' => 'Contraseña de aprobación',
        'created_at' => 'Fecha de creación',
        'updated_at' => 'Fecha de actualización',
        'deleted_at' => 'Fecha de eliminiación',
    ],

    // nombres cortos de los elementos del formulario, para la tabla del index
    'table-columns' => [
        'id' => 'Id',
        'reason_id' => 'Motivo',
        'name' => 'Nombre',
        'author' => 'Autor',
        'genre' => 'Género',
        'stars' => 'Estrellas',
        'published_year' => 'Fecha de publicación',
        'enabled' => 'Activado?',
        'status' => 'Estado',
        'synopsis' => 'Sinopsis',
        'approved_at' => 'Fecha de aprobación',
        'approved_by' => 'Usuario que aprobó',
        'created_at' => 'Fecha de creación',
        'updated_at' => 'Fecha de actualización',
        'deleted_at' => 'Fecha de eliminiación',
    ],

    // Los nombres de los atributos de validación en Form Requests.
    'attributes' => [
        'id' => 'Id',
        'reason_id' => 'Motivo',
        'name' => 'Nombre',
        'author' => 'Autor',
        'genre' => 'Género',
        'stars' => 'Estrellas',
        'published_year' => 'Fecha de publicación',
        'published_year[from]' => 'Fecha de publicación inicial',
        'published_year[to]' => 'Fecha de publicación final',
        'enabled' => 'Activado?',
        'enabled_true' => 'Activado? si',
        'enabled_false' => 'Activado? no',
        'status' => 'Estado',
        'unlocking_word' => 'Palabra de desbloqueo',
        'unlocking_word_confirmation' => 'Confirmar Palabra de desbloqueo',
        'synopsis' => 'Sinopsis',
        'approved_at' => 'Fecha de aprobación',
        'approved_at[from]' => 'Fecha de aprobación inicial',
        'approved_at[to]' => 'Fecha de aprobación final',
        'approved_by' => 'Usuario que aprobó',
        'approved_password' => 'Contraseña de aprobación',
        'created_at' => 'Fecha de creación',
        'created_at[from]' => 'Fecha de creación inicial',
        'created_at[to]' => 'Fecha de creación final',
        'updated_at' => 'Fecha de actualización',
        'updated_at[from]' => 'Fecha de actualización inicial',
        'updated_at[to]' => 'Fecha de actualización final',
        'deleted_at' => 'Fecha de eliminiación',
        'deleted_at[from]' => 'Fecha de eliminiación inicial',
        'deleted_at[to]' => 'Fecha de eliminiación final',
    ],

    // Los mensajes personalizados de validación en Form Requests.
    'messages' => [
        'foo' => 'msg'
    ],

    // mensajes de transacciones
    'store_book_success' => 'Libro creado correctamente.',
    'update_book_success' => 'Libro actualizado correctamente.',
    'destroy_book_success' => 'El libro ha sido movido a la papelera.|Los libros han sido movidos a la papelera correctamente.',
    'restore_book_success' => 'El libro ha sido restaurado correctamente.|Los libros han sido restaurados correctamente.',

];
