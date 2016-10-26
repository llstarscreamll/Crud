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
     * Los mensajes de notificación cuando el usuario hace algún tipo de
     * transacción en el sistema, como crear/editar/borrar un registro.
     */
    
    // mesajes del método store() del controlador
    'create_book_success' => 'Libro creado correctamente.',
    'create_book_error' => 'Error creando libro.',

    // mesajes del método update() del controlador
    'update_book_success' => 'Libro actualizado correctamente.',
    'update_book_error' => 'Ocurrió un error actualizando el libro.',
    
    // mesajes del método destroy() del controlador
    'destroy_book_success' => 'El libro ha sido movido a la papelera.|Los libros han sido movidos a la papelera correctamente.',
    'destroy_book_error' => 'Ocurrió un problema moviendo el libro a la papelera.|Ocurrió un error moviendo los libros a la papelera.',

    // mesajes del método restore() del controlador
    'restore_book_success' => 'El libro ha sido restaurado correctamente.|Los libros han sido restaurados correctamente.',
    'restore_book_error' => 'Ocurrió un problema restaurando el libro.|Ocurrió un error restaurando los libros.',

];