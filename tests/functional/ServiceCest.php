<?php

namespace Crud;

use Crud\FunctionalTester;
use Crud\Page\Functional\Generate as Page;

class ServiceCest
{
    public function _before(FunctionalTester $I)
    {
        new Page($I);
        $I->amLoggedAs(Page::$adminUser);

        $I->seeAuthentication();
        $I->amOnPage(Page::route('?table_name='.Page::$tableName));
        $I->see(Page::$title, Page::$titleElem);

        // envío el formulario de creación del CRUD
        $I->submitForm('form[name=CRUD-form]', Page::$formData);
    }

    /**
     * Prueba el código del servicio generado.
     *
     * @param  FunctionalTester $I
     */
    public function generateService(FunctionalTester $I)
    {
        $I->wantTo('revisar código de servicio generado');

        $I->openFile(base_path().'/app/Services/BookService.php');
        $service = file_get_contents(__DIR__.'/../_data/BookService.php');

        $I->seeInThisFile($service);
    }
}
