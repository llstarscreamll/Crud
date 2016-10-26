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

class Create extends Index
{
    /**
     * La URL de la página.
     *
     * @var  string
     */
    public static $URL = '/books/create';

    /**
     * El título de la página.
     *
     * @var  string
     */
    static $title = 'Crear';

    /**
     * El selector del formulario.
     *
     * @var  string
     */
    static $form = 'form[name=create-books-form]';

    /**
     * El botón submit del formulario.
     *
     * @var  array
     */
    static $formBtnElem = 'button.btn.btn-primary';

    /**
     * Mensaje de éxito al crear un registro.
     *
     * @var  array
     */
    static $msgSuccess = 'Libro creado correctamente.';
    static $msgSuccessElem = '.alert.alert-success';

    public function __construct(FunctionalTester $I)
    {
        parent::__construct($I);
    }
}