<?php

namespace CRUD;

use CrudGenerator\FunctionalTester;
use CrudGenerator\Page\Functional\Generate as Page;

class GenerateLanguajeFilesCest
{
    public function _before(FunctionalTester $I)
    {
        new Page($I);
        $I->amLoggedAs(Page::$adminUser);

        $I->amOnPage(Page::route('?table_name='.Page::$tableName));
        $I->see(Page::$title, Page::$titleElem);
        $I->submitForm('form[name=CRUD-form]', Page::$formData);
    }

    /**
     * Comprueba las líneas de código generadas en el controlador del CRUD.
     *
     * @param FunctionalTester $I
     */
    public function checkLanguageFilesCode(FunctionalTester $I)
    {
        $I->wantTo('revisar archivo de lenguaje generado');

        $I->openFile(base_path().'/resources/lang/es/book/views.php');
        $langFile = file_get_contents(__DIR__.'/../_data/lang/views.php');
        $I->seeInThisFile($langFile);
    }
}
