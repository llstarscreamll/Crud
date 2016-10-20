<?php

namespace CrudGenerator;

use CrudGenerator\FunctionalTester;
use CrudGenerator\Page\Functional\Generate as Page;

class GeneratePageObjectsTestsCest
{
    public function _before(FunctionalTester $I)
    {
        new Page($I);
        $I->amLoggedAs(Page::$adminUser);

        $I->amOnPage(Page::route('?table_name='.Page::$tableName));
        $I->see(Page::$title, Page::$titleElem);

        // envío el formulario de creación del CRUD
        $I->submitForm('form[name=CRUD-form]', Page::$formData);
    }

    /**
     * Comprueba las líneas de código generadas en las vistas del CRUD.
     *
     * @param FunctionalTester $I
     */
    public function checkTestsCode(FunctionalTester $I)
    {
        $I->wantTo('revisar los pageObjects generados');

        // abro el pageObject Base
        $I->openFile(base_path().'/tests/_support/Page/Functional/Books/Base.php');
        $pageObject = file_get_contents(__DIR__.'/../_data/pageObjects/Base.php');
        $I->seeInThisFile($pageObject);

        // abro el pageObject Create
        $I->openFile(base_path().'/tests/_support/Page/Functional/Books/Create.php');
        $pageObject = file_get_contents(__DIR__.'/../_data/pageObjects/Create.php');
        $I->seeInThisFile($pageObject);

        // abro el pageObject Delete
        $I->openFile(base_path().'/tests/_support/Page/Functional/Books/Delete.php');
        $pageObject = file_get_contents(__DIR__.'/../_data/pageObjects/Delete.php');
        $I->seeInThisFile($pageObject);

        // abro el pageObject Edit
        $I->openFile(base_path().'/tests/_support/Page/Functional/Books/Edit.php');
        $pageObject = file_get_contents(__DIR__.'/../_data/pageObjects/Edit.php');
        $I->seeInThisFile($pageObject);

        // abro el pageObject Index
        $I->openFile(base_path().'/tests/_support/Page/Functional/Books/Index.php');
        $pageObject = file_get_contents(__DIR__.'/../_data/pageObjects/Index.php');
        $I->seeInThisFile($pageObject);

        // abro el pageObject Show
        $I->openFile(base_path().'/tests/_support/Page/Functional/Books/Show.php');
        $pageObject = file_get_contents(__DIR__.'/../_data/pageObjects/Show.php');
        $I->seeInThisFile($pageObject);
    }
}
