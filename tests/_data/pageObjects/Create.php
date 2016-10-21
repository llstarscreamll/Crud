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

namespace Page\Functional\Books;

use Page\Functional\Books\Base;

class Create extends Base
{
    // include url of current page
    public static $URL = '/books/create';

    /**
     * Declare UI map for this page here. CSS or XPath allowed.
     * public static $usernameField = '#username';
     * public static $formSubmitButton = "#mainForm input[type=submit]";
     */

    /**
     * Los atributos del título de la página.
     * @var  array
     */
    static $title = array();

    /**
     * El selector del formulario.
     * @var  string
     */
    static $form;

    /**
     * Los atributos del botón del formulario.
     * @var  array
     */
    static $formButton = array();

    /**
     * Mensaje de éxito al crear un registro.
     * @var  array
     */
    static $msgSuccess = array();

    public function __construct(\FunctionalTester $I)
    {
        parent::__construct($I);

        $this->initUIMap();
    }

    /**
     * Inicializa las variables del mapeo de la UI.
     * @return  void
     */
    public function initUIMap()
    {
        self::$title = [
            'txt' => trans('book/views.create.name'),
            'selector'  => '.content-header h1 small'
        ];
        self::$form = 'form[name=create-books-form]';
        self::$formButton = [
            'txt' => trans('book/views.create.form-button'),
            'selector' => 'button.btn.btn-primary',
        ];
        self::$msgSuccess = [
            'txt' => trans('book/messages.create_book_success'),
            'selector' => '.alert.alert-success'
        ];
    }
}