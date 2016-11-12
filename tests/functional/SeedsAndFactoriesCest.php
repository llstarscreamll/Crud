<?php

namespace Crud;

use Crud\Page\Functional\Generate as Page;

class SeedsAndFactoriesCest
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
    public function checkModelFactoryAndSeedsCode(FunctionalTester $I)
    {
        $I->wantTo('revisar ModelFactory y Seeds generados');

        // model factory
        $I->openFile(database_path('factories/BookFactory.php'));
        $factory = file_get_contents(__DIR__.'/../_data/BookFactory.php');
        $I->seeInThisFile($factory);

        // seed de permisos
        $I->openFile(database_path('seeds/BookPermissionsSeeder.php'));
        $permisSeed = file_get_contents(__DIR__.'/../_data/BookPermissionsSeeder.php');
        $I->seeInThisFile($permisSeed);

        // seed de datos de prueba para tabla
        $I->openFile(database_path('seeds/BooksTableSeeder.php'));
        $tableSeed = file_get_contents(__DIR__.'/../_data/BooksTableSeeder.php');
        $I->seeInThisFile($tableSeed);
    }
}
