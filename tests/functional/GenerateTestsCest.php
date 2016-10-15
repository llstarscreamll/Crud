<?php
namespace CRUD;

use CrudGenerator\FunctionalTester;
use CrudGenerator\Page\Functional\Generate as Page;

class GenerateTestsCest
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
     * Comprueba las líneas de código generadas en las vistas del CRUD.
     * @param  FunctionalTester $I
     * @return void
     */
    public function checkTestsCode(FunctionalTester $I)
    {
    	$I->am('Developer');
        $I->wantTo('revisar las lineas de codigo de los test generados');

        $I->amOnPage(Page::route('?table_name='.Page::$tableName));
        $I->see(Page::$title, Page::$titleElem);

        // envío el formulario de creación del CRUD
        $I->submitForm('form[name=CRUD-form]', Page::$formData);
        
        //$I->openFile('app/Http/Controllers/BookController.php');
        //$I->seeInThisFile("\$data['reason_id_list'] = Reason::lists('name', 'id')->all();");
    }
}
