<?php

namespace CrudGenerator;

use CrudGenerator\Page\Functional\Generate as Page;

class GenerateControllerCest
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
     * Comprueba las líneas de código generadas en el controlador del CRUD.
     *
     * @param FunctionalTester $I
     */
    public function checkControllerCode(FunctionalTester $I)
    {
        $I->wantTo('revisar el controlador generado');

        $I->openFile(base_path().'/app/Http/Controllers/BookController.php');

        $controller = file_get_contents(__DIR__.'/../_data/controllers/BookController.php');

        $I->seeInThisFile($controller);
    }
}
