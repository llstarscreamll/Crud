<?php
namespace Books;

use \FunctionalTester;
use Page\Functional\Books\Create as Page;

class CreateCest
{
    /**
     * Las acciones a realizar antes de cada test.
     * @param    FunctionalTester $I
     * @return  void
     */
    public function _before(FunctionalTester $I)
    {
        new Page($I);
        $I->amLoggedAs(Page::$adminUser);
    }
    
    /**
     * Las acciones a realizar después de cada test.
     * @param    FunctionalTester $I
     * @return  void
     */
    public function _after(FunctionalTester $I)
    {
    }

    /**
     * Prueba la funcionalidad de crear un nuevo modelo.
     * @param    FunctionalTester $I
     * @return  void
     */
    public function create(FunctionalTester $I)
    {
        $I->am('admin de '.trans('book/views.module.name'));
        $I->wantTo('crear un registro en modulo de '.trans('book/views.module.name'));
        
        // voy a la página del módulo
        $I->amOnPage(Page::$URL);
        // veo el título de la página
        $I->see(Page::$moduleName['txt'], Page::$moduleName['selector']);
        $I->see(Page::$title['txt'], Page::$title['selector']);

        // envío el formulario
        $I->submitForm(Page::$form, Page::getCreateData(), Page::$formButton['txt']);

        // soy redirigido al index del módulo
        $I->seeCurrentUrlEquals(Page::$moduleURL);
        
        // veo mensajes de éxito en la operación
        $I->see(Page::$msgSuccess['txt'], Page::$msgSuccess['selector']);
    }

}