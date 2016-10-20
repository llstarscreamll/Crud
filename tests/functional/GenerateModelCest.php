<?php

namespace CRUD;

use CrudGenerator\FunctionalTester;
use CrudGenerator\Page\Functional\Generate as Page;

class GenerateModelCest
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

    public function _after(FunctionalTester $I)
    {
    }

    /**
     * Comprueba las líneas de código generadas en el modelo del CRUD.
     *
     * @param FunctionalTester $I
     */
    public function checkModelCode(FunctionalTester $I)
    {
        $I->wantTo('revisar el modelo generado');

        $I->openFile(base_path().'/app/Models/Book.php');
        $model = file_get_contents(__DIR__.'/../_data/models/Book.php');
        $I->seeInThisFile($model);
    }
}
