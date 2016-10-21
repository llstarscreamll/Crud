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

class Show extends Base
{
    // include url of current page
    public static $URL = '/books';

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
     * El selector del formulario de sólo lectura de los datos.
     * @var  string
     */
    static $form = 'form[name=show-books-form]';

    public function __construct(\FunctionalTester $I)
    {
        parent::__construct($I);

        self::$title = [
            'txt'       => trans('book/views.show.name'),
            'selector'  => '.content-header h1 small'
        ];
    }

    /**
     * Devuelve array con los datos a visualizar en el formulario de sólo lectura.
     * @return  array
     */
    public static function getReadOnlyFormData()
    {
        $data = self::$bookData;

        // los siguientes campos no se han de mostrar en la vista de sólo lectura
        foreach (self::$hiddenFields as $key => $value) {
            unset($data[$value]);
        }

        return $data;
    }
}