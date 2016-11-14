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
use Page\Functional\Books\Destroy as Page;

class DestroyCest
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
     * Prueba la funcionalidad de mover a papelera un registro.
     *
     * @param    FunctionalTester $I
     * @group    Books
     */ 
    public function trash(FunctionalTester $I)
    {
        $I->wantTo('mover a papelera registro en módulo '.Page::$moduleName);

        // creo registro de prueba
        Page::haveBook($I);

        // voy a la página de detalles del registro y doy clic al botón
        // "Mover a Papelera"
        $I->amOnPage(Page::route('/'.Page::$bookData['id']));
        $I->click(Page::$trashBtn, Page::$trashBtnElem);

        // soy redirigido al Index y debo ver mensaje de éxito en la operación
        $I->seeCurrentUrlEquals(Page::$moduleURL);
        $I->see(Page::$msgSuccess, Page::$msgSuccessElem);
        // no debe haber datos que mostrar
        $I->see(Page::$noDataFountMsg, Page::$noDataFountMsgElem);
    }

    /**
     * Prueba la funcionalidad de mover a papelera varios registros a la vez.
     *
     * @param    FunctionalTester $I
     * @group    Books
     */ 
    public function trashMany(FunctionalTester $I)
    {
        $I->wantTo('mover a papelera varios registros a la vez en módulo '.Page::$moduleName);

        // creo registros de prueba
        $books = factory(Book::class, 10)->create();

        // cuando cargo el Index el botón "Mover a Papelera" debe
        // ser mostrado
        $I->amOnPage(Page::$moduleURL);
        $I->see(Page::$trashManyBtn, Page::$trashManyBtnElem);
        
        // cargo la ruta que "Mover a Papelera" los registros
        $I->submitForm('#deletemanyForm', [
            'id' => $books->pluck('id')->toArray()
        ]);
        $I->dontSeeFormErrors();
        
        // soy redirigido al Index y no debe haber datos que mostrar
        $I->seeCurrentUrlEquals(Page::$moduleURL);
        $I->see(Page::$noDataFountMsg, Page::$noDataFountMsgElem);
    }
}