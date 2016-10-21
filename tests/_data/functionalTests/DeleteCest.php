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

namespace Books;

use \FunctionalTester;
use Page\Functional\Books\Delete as Page;

class DeleteCest
{
    public function _before(FunctionalTester $I)
    {
        new Page($I);
        $I->amLoggedAs(Page::$adminUser);
    }

    public function _after(FunctionalTester $I)
    {
    }

    /**
     * Prueba la funcionalidad de eliminar un modelo.
     * @param    FunctionalTester $I
     * @return  void
     */
    public function delete(FunctionalTester $I)
    {
        $I->am('admin de '.trans('book/views.module.name'));
        $I->wantTo('eliminar un registro en modulo de '.trans('book/views.module.name'));

        // creo el registro de prueba
        Page::haveBook($I);

        // voy a la página de detalles del registro
        $I->amOnPage(Page::route('/'.Page::$bookData['id']));
        // veo el botón que abre la ventana modal para la confirmación de eliminación
        $I->see(Page::$deleteBtn['txt'], Page::$deleteBtn['selector']);
        // doy clic al botón de confirmación de ventana modal para borrar el registro
        $I->click(Page::$deleteBtnConfirm['txt'], Page::$deleteBtnConfirm['selector']);

        // soy redireccionado al index y veo mensaje de confirmación
        $I->seeCurrentUrlEquals(Page::$URL);
        $I->see(Page::$msgSuccess['txt'], Page::$msgSuccess['selector']);
        // veo mensaje de que no hay datos de capacitaciones
        $I->see(Page::$msgNoDataFount['txt'], Page::$msgNoDataFount['selector']);
    }
}