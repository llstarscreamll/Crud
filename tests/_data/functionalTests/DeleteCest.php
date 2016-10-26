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

namespace Books;

use App\Models\Book;
use FunctionalTester;
use Page\Functional\Books\Delete as Page;

class DeleteCest
{
    /**
     * Las acciones a realizar antes de cada test.
     *
     * @param    FunctionalTester $I
     */
    public function _before(FunctionalTester $I)
    {
        new Page($I);
        $I->amLoggedAs(Page::$adminUser);
    }

    /**
     * Prueba la funcionalidad de eliminar un registro.
     *
     * @param    FunctionalTester $I
     * @group    Books
     */ 
    public function delete(FunctionalTester $I)
    {
        $I->wantTo('eliminar registro en módulo '.Page::$moduleName);

        // creo registro de prueba
        Page::haveBook($I);

        // voy a la página de detalles del registro y doy clic al botón "Enviar
        // a Papelera"
        $I->amOnPage(Page::route('/'.Page::$bookData['id']));
        $I->click(Page::$deleteBtn, Page::$deleteBtnElem);

        // soy redirigido al Index y debo ver mensaje de éxito en la operación
        $I->seeCurrentUrlEquals(Page::$moduleURL);
        $I->see(Page::$msgSuccess, Page::$msgSuccessElem);
        // no debe haber datos que mostrar
        $I->see(Page::$noDataFountMsg, Page::$noDataFountMsgElem);
    }

    /**
     * Prueba la funcionalidad de mover a la papelera varios registros a la vez.
     *
     * @param    FunctionalTester $I
     * @group    Books
     */ 
    public function deleteMany(FunctionalTester $I)
    {
        $I->wantTo('eliminar varios registros a la vez en módulo '.Page::$moduleName);

        // creo registros de prueba
        $books = factory(Book::class, 10)->create();

        // cuando cargo el Index el botón "Mover a la Papelera" debe ser mostrado
        $I->amOnPage(Page::$moduleURL);
        $I->see('Borrar Libros seleccionados', 'button.btn.btn-default.btn-sm');
        
        // cargo la ruta que "Mueve a Papelera" los registros
        $I->destroyMany('books.destroy', $books->pluck('id')->toArray());
        
        // soy redirigido al Index y no debe haber datos que mostrar
        $I->seeCurrentUrlEquals(Page::$moduleURL);
        $I->see('No se encontraron registros...', '.alert.alert-warning');
    }
}