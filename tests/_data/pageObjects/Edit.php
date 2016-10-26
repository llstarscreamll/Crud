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

namespace Page\Functional\Books;

use FunctionalTester;
use App\Models\Reason;

class Edit extends Index
{
    /**
     * El link de acceso a la edición del registro.
     *
     * @var  array
     */
    static $linkToEdit = 'Editar';
    static $linkToEditElem = 'a.btn.btn-warning';
    
    /**
     * El título de la página.
     *
     * @var  string
     */
    static $title = 'Actualizar';

    /**
     * El selector del formulario de edición.
     *
     * @var  string
     */
    static $form = 'form[name=edit-books-form]';

    /**
     * Mensaje de éxito al actualizar un registro.
     *
     * @var  array
     */
    static $msgSuccess = 'Libro actualizado correctamente.';
    static $msgSuccessElem = '.alert.alert-success';

    public function __construct(FunctionalTester $I)
    {
        parent::__construct($I);
    }

    /**
     * Devuelve array con los datos que deben estar presentes en el formulario
     * de edición antes de la operación de actualización.
     *
     * @return  array
     */
    public static function getUpdateFormData()
    {
        $data = array();

        foreach (static::$bookData as $key => $value) {
            if (in_array($key, static::$editFormFields)) {
                $data[$key] = $value;
            }
            if (in_array($key, static::$fieldsThatRequieresConfirmation)){
                $data[$key.'_confirmation'] = '';
            }
        }

        return $data;
    }

    /**
     * Devuelve array con datos para actualización de registro en formulario de
     * edición.
     *
     * @return  array
     */
    public static function getDataToUpdateForm()
    {
        $data = array();

        $data = [
            'reason_id' => Reason::all(['id'])->last()->id,
            'name' => "El Coronel No Tiene Quien Le Escriba",
            'author' => "Gabriel García Márquez",
            'genre' => "Thriller",
            'stars' => "5",
            'published_year' => "2016-05-05",
            'enabled' => true,
            'status' => "approved",
            'unlocking_word' => "asdfghjklñ",
            'unlocking_word_confirmation' => "asdfghjklñ",
            'synopsis' => "Esta es una prueba de actualización de sinopsis...",
        ];

        return $data;
    }

    /**
     * Obtiene array de datos del registro actualizado para comprobarlos en la
     * vista de sólo lectura (show).
     *
     * @return    array
     */
    public static function getUpdatedDataToShowForm()
    {
        $data = static::getDataToUpdateForm();

        // los campos ocultos no deben ser mostrados en la vista de sólo lectura
        foreach (static::$hiddenFields as $key => $value) {
            unset($data[$value]);
            if (in_array($key, static::$fieldsThatRequieresConfirmation)) {
                unset($data[$value.'_confirmation']);
            }
        }

        return $data;
    }
}