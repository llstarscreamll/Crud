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

use FunctionalTester;
use Page\Functional\Books\Create as Page;

class CreateCest
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
     * Prueba la funcionalidad de crear un nuevo registro.
     *
     * @param    FunctionalTester $I
     * @group    Books
     */ 
    public function create(FunctionalTester $I)
    {
        $I->wantTo('crear registro en módulo '.Page::$moduleName);
        
        // voy a la página de creación
        $I->amOnPage(Page::$URL);
        // veo el título de la página
        $I->see(Page::$moduleName, Page::$titleElem);
        $I->see(Page::$title, Page::$titleSmallElem);

        // los datos a enviar en el formulario
        $formData = Page::getCreateData();

        // veo los campos correspondientes en el formulario
        foreach ($formData as $name => $value) {
            $I->seeElement("*[name=$name]");
        }

        // envío el formulario
        $I->submitForm(Page::$form, $formData, Page::$formBtnElem);
        $I->dontSeeFormErrors();

        // soy redirigido al Index del módulo
        $I->seeCurrentUrlEquals(Page::$moduleURL);
        // veo mensaje de éxito en la operación
        $I->see(Page::$msgSuccess, Page::$msgSuccessElem);
        $formData = Page::unsetConfirmationFields($formData);
        $I->seeRecord('books', null_empty_fields($formData));
    }
}