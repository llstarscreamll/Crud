<?php
namespace CRUD;

use CrudGenerator\FunctionalTester;
use CrudGenerator\Page\Functional\Generate as Page;

class GeneratePageObjectsTestsCest
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
        $I->wantTo('revisar las lineas de codigo de los pageObjects de los test');

        $I->amOnPage(Page::route('?table_name='.Page::$tableName));
        $I->see(Page::$title, Page::$titleElem);

        // envío el formulario de creación del CRUD
        $I->submitForm('form[name=CRUD-form]', Page::$formData);

        // abro el archivo pageObject Base
        $I->openFile('tests/_support/Page/Functional/Books/Base.php');

        // veo el namespace del archivo
        $I->seeInThisFile("namespace Page\Functional\Books;");

        // es llamado el seeder de la tabla permissions con los permiso de acceso al módulo
        $I->seeInThisFile("\Artisan::call('db:seed', ['--class' => 'BookPermissionsSeeder']);");

        // son llamados los seeders de las tablas de las que depende el modelo, en este caso
        // la tabla reasons y users
        $I->seeInThisFile("\Artisan::call('db:seed', ['--class' => 'ReasonsTableSeeder']);");
        $I->seeInThisFile("\Artisan::call('db:seed', ['--class' => 'UsersTableSeeder']);");
    }
}
