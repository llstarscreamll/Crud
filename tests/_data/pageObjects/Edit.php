<?php
namespace Page\Functional\Books;

use Page\Functional\Books\Base;

class Edit extends Base
{
    // include url of current page
    public static $URL = '/books';

    /**
     * Declare UI map for this page here. CSS or XPath allowed.
     * public static $usernameField = '#username';
     * public static $formSubmitButton = "#mainForm input[type=submit]";
     */
    
    /**
     * Los atributos del link de acceso a la edición de capacitación.
     * @var  array
     */
    static $linkToEdit = array();
    
    /**
     * Los atributos del título de la página.
     * @var  array
     */
    static $title = array();

    /**
     * El selector del formulario de edición.
     * @var  string
     */
    static $form = 'form[name=edit-books-form]';

    /**
     * Los atributos del mensaje de confirmación de la operación.
     * @var  array
     */
    static $msgSuccess = array();

    public function __construct(\FunctionalTester $I)
    {
        parent::__construct($I);

        self::$linkToEdit = [
            'txt'       => trans('book/views.edit.link-access'),
            'selector'  => 'a.btn.btn-warning'
        ];

        self::$title = [
            'txt'       => trans('book/views.edit.name'),
            'selector'  => '.content-header h1 small'
        ];

        self::$msgSuccess = [
            'txt'       => trans('book/messages.update_book_success'),
            'selector'  => '.alert.alert-success'
        ];
    }

    /**
     * Devuelve un array con los datos que deben estar presentes en el formulario de edición
     * del modelo antes de su actualización.
     * @return  array
     */
    public static function getUpdateFormData()
    {
        $data = array();

        foreach (self::$bookData as $key => $value) {
            if (in_array($key, self::$updateFormFields)) {
                $data[$key] = $value;
            }
            if (in_array($key, self::$fieldsThatRequieresConfirmation)){
                $data[$key.'_confirmation'] = '';
            }
        }

        return $data;
    }

    /**
     * Devuelve un array con datos para actualización del formulario de edición del modelo.
     * @return  array
     */
    public static function getDataToUpdateForm()
    {
        $data = array();

        $data = [
            'reason_id' => 2,
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
     * Obtine los datos ya actualizados para comprobarlos en la vista de sólo lectura (show).
     * @return    array
     */
    public static function getUpdatedDataToShowForm()
    {
        $data = self::getDataToUpdateForm();

        // los siguientes campos no se han de mostrar en la vista de sólo lectura
        foreach (self::$hiddenFields as $key => $value) {
            unset($data[$value]);
            if (in_array($key, self::$fieldsThatRequieresConfirmation)) {
                unset($data[$value.'_confirmation']);
            }
        }

        return $data;
    }

}