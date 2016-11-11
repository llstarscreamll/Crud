<?php
namespace Crud;

use Crud\FunctionalTester;
use Crud\Page\Functional\Generate as Page;

class GenerateRoutesCest
{
    public function _before(FunctionalTester $I)
    {
        new Page($I);
        $I->amLoggedAs(Page::$adminUser);

        $I->am('Developer');
        $I->wantTo('revisar las lineas de codigo del controlador');

        $I->amOnPage(Page::route('?table_name='.Page::$tableName));
        $I->see(Page::$title, Page::$titleElem);

        // envío el formulario de creación del CRUD
        $I->submitForm('form[name=CRUD-form]', Page::$formData);
    }

    public function _after(FunctionalTester $I)
    {
    }

    /**
     * Comprueba las líneas de código generadas en el controlador del CRUD.
     *
     * @param  FunctionalTester $I
     */
    public function checkRoutesCode(FunctionalTester $I)
    {
        $I->wantTo('comprobar las rutas generadas');

        $I->openFile(base_path().'/routes/web.php');
        $routes = file_get_contents(__DIR__.'/../_data/routes/bookRoutes.php');
        $I->seeInThisFile($routes);
    }
}
