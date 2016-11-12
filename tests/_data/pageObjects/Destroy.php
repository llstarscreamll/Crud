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

class Destroy extends Index
{
    /**
     * El botón de mover a papelera.
     *
     * @var  string
     */
    public static $trashBtn = 'Mover a Papelera';
    public static $trashBtnElem = 'button.btn.btn-danger';

    /**
     * Botón de mover a papelera varios registros.
     *
     * @var  string
     */
    public static $trashManyBtn = 'Mover seleccionados a papelera';
    public static $trashManyBtnElem = 'button.btn.btn-default.btn-sm';

    /**
     * Mensaje de éxito al mover a papelera un registro.
     *
     * @var  string
     */
    public static $msgSuccess = 'El libro ha sido movido a la papelera.';
    public static $msgSuccessElem = '.alert.alert-success';

    public function __construct(FunctionalTester $I)
    {
        parent::__construct($I);
    }
}