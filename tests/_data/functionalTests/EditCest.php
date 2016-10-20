<?php
namespace Books;

use \FunctionalTester;
use Page\Functional\Books\Edit as Page;

class EditCest
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
     * Prueba la funcionalidad de editar la información de un modelo ya creado.
     * @param    FunctionalTester $I
     * @return  void
     */
    public function edit(FunctionalTester $I)
    {
        $I->am('admin de '.trans('book/views.module.name'));
        $I->wantTo('editar un registro en modulo de '.trans('book/views.module.name'));

        // creo el registro de prueba
        Page::haveBook($I);

        // voy a la página de detalles del registro
        $I->amOnPage(Page::route('/'.Page::$bookData['id']));
        // doy clic al enlace para ir al formulario de edición
        $I->click(Page::$linkToEdit['txt'], Page::$linkToEdit['selector']);

        // estoy en la página de edición
        $I->seeCurrentUrlEquals(Page::route('/'.Page::$bookData['id'].'/edit'));
        $I->see(Page::$title['txt'], Page::$title['selector']);

        // veo los datos en el formulario
        $I->seeInFormFields(Page::$form, Page::getUpdateFormData());

        // envío el formulario con los nuevos datos
        $I->submitForm(Page::$form, Page::getDataToUpdateForm());

        // soy redireccionado al index del módulo
        $I->seeCurrentUrlEquals(Page::route(''));
        // veo mensaje de confirmación
        $I->see(Page::$msgSuccess['txt'], Page::$msgSuccess['selector']);
        
        // voy a la página de detalles del registro
        $I->amOnPage(Page::route('/'.Page::$bookData['id']));
        
        // veo los datos actualizados en el formulario de sólo lectura
        $I->seeInFormFields('form', Page::getUpdatedDataToShowForm());
    }
}