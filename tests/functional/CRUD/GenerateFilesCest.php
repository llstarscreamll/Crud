<?php
namespace CRUD;

use \FunctionalTester;
use Page\Functional\CRUD\Generate as Page;

class GenerateFilesCest
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
     * Comprueba la funcionalidad de crear los ficheros requeridos para la CRUD app.
     * @param  FunctionalTester $I
     * @return void
     */
    public function checkFilesGeneration(FunctionalTester $I)
    {
        $I->am('Developer');
        $I->wantTo('crear aplicacion CRUD');

        $I->amOnPage('/showOptions?table_name=books');
        $I->see('CrudGenerator', 'h1');

        // envío el formulario de creación del CRUD
        $I->submitForm('form[name=CRUD-form]', Page::$formData);

        // veo los mensajes de operación exitosa
        $I->see('Los tests se han generado correctamente.', '.alert-success');
        $I->see('Modelo generado correctamente.', '.alert-success');
        $I->see('Controlador generado correctamente.', '.alert-success');
        // los sigientes mensajes no aparecen si se corre mas de una vez el test
        //$I->see('Model Binding para el Controlador generado correctamente.', '.alert-success');
        //$I->see('La ruta se ha generado correctamente.', '.alert-success');
        
        // compruebo la existencia de los archivos
        // el modelo
        $I->seeFileFound('Book.php','app/Models');

        // el controlador
        $I->seeFileFound('BookController.php','app/Http/Controllers');

        // los tests funcionales y pageObjects
        foreach (config('llstarscreamll.CrudGenerator.config.tests') as $test) {
            
            if ($test != 'Base'){
                $I->seeFileFound($test.'Cest.php','tests/functional/Books');
            }

            $I->seeFileFound($test.'.php','tests/_support/Page/Functional/Books');
        }

        // las vistas
        foreach (config('llstarscreamll.CrudGenerator.config.views') as $view) {
            
            if (strpos($view, 'partials/') === false){
                $I->seeFileFound($view.'.blade.php','resources/views/books');
                continue;
            }else{
                $I->seeFileFound(str_replace('partials/', '', $view).'.blade.php','resources/views/books/partials');
            }
        }

        // el model binding sólo puede ser creado si la entidad no hace uso de
        // la propiedad softDeletes, es decir si no tiene la columna deleted_at
        $I->openFile('app/Providers/RouteServiceProvider.php');
        $I->dontSeeInThisFile("\$router->model('books', 'App\Models\Book');");

        // reviso que se halla añadido el route resource en routes.php
        $I->openFile('app/Http/routes.php');
        $I->seeInThisFile("Route::resource('books','BookController');");
    }
}
