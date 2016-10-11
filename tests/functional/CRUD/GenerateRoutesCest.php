<?php
namespace CRUD;

use \FunctionalTester;
use Page\Functional\CRUD\Generate as Page;

class GenerateRoutesCest
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
     * Comprueba las líneas de código generadas en el controlador del CRUD.
     * @param  FunctionalTester $I
     * @return void
     */
    public function checkRoutesCode(FunctionalTester $I)
    {
        $I->am('Developer');
        $I->wantTo('revisar las lineas de codigo del controlador');

        $I->amOnPage('/showOptions?table_name=books');
        $I->see('CrudGenerator', 'h1');

        // envío el formulario de creación del CRUD
        $I->submitForm('form[name=CRUD-form]', Page::$formData);

        // reviso que se esté llamando a las clases de los modelos de las que
        // depende el controlador correctamente
        $I->openFile('app/Http/routes.php');

        // veo el recurso generado
        $I->seeInThisFile("Route::resource('books','BookController');");
        // como tiene la columna deleted_at para softedeletes, debe tener ruta para
        // restablecer los registros en papelera
        $I->seeInThisFile("Route::put(\n\t'/books/restore/{books}',\n\t[\n\t'as'    =>  'books.restore',\n\t'uses'  =>  'BookController@restore'\n\t]\n);");
    }
}
