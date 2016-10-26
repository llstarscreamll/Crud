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

class Delete extends Index
{
    /**
     * El botón de mover a la papelera.
     *
     * @var  array
     */
    static $deleteBtn = 'Mover a papelera';
    static $deleteBtnElem = 'button.btn.btn-danger';

    /**
     * Mensaje de éxito al eliminar un registro.
     *
     * @var  array
     */
    static $msgSuccess = 'El libro ha sido movido a la papelera.';
    static $msgSuccessElem = '.alert.alert-success';

    public function __construct(FunctionalTester $I)
    {
        parent::__construct($I);
    }
}