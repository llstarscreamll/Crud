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

class Show extends Index
{
    /**
     * El título de la página.
     *
     * @var  string
     */
    static $title = 'Detalles';

    /**
     * El selector del formulario de sólo lectura de los datos.
     *
     * @var  string
     */
    static $form = 'form[name=show-books-form]';

    public function __construct(FunctionalTester $I)
    {
        parent::__construct($I);
    }
}
