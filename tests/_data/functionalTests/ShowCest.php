<?php
namespace Books;

use \FunctionalTester;
use Page\Functional\Books\Show as Page;

class ShowCest
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
     * Prueba la funcionalidad de consultar la información de un modelo, sólo lectura.
     * @param    FunctionalTester $I
     * @return  void
     */
    public function show(FunctionalTester $I)
    {
        $I->am('admin de '.trans('book/views.module.name'));
        $I->wantTo('ver detalles de un registro en modulo de '.trans('book/views.module.name'));

        // creo el registro de prueba
        Page::haveBook($I);

        // voy a la página de detalles del registro
        $I->amOnPage(Page::route('/'.Page::$bookData['id']));
        // veo el título de la página
        $I->see(Page::$title['txt'], Page::$title['selector']);

        // veo los datos en el formulario de sólo lectura
        $I->seeInFormFields(Page::$form, Page::getReadOnlyFormData());
    }
}