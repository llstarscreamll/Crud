<?php

namespace CrudGenerator;

use CrudGenerator\FunctionalTester;
use CrudGenerator\Page\Functional\Generate as Page;

class GenerateFilesCest
{
    public function _before(FunctionalTester $I)
    {
        new Page($I);
        $I->amLoggedAs(Page::$adminUser);

        $I->amOnPage(Page::route('?table_name='.Page::$tableName));
        $I->see(Page::$title, Page::$titleElem);
        $I->submitForm('form[name=CRUD-form]', Page::$formData);
    }

    public function _after(FunctionalTester $I)
    {
    }

    /**
     * Comprueba la funcionalidad de crear los ficheros requeridos para la CRUD app.
     *
     * @param FunctionalTester $I
     */
    public function checkFilesGeneration(FunctionalTester $I)
    {
        $I->wantTo('crear aplicacion CRUD');

        // veo los mensajes de operación exitosa
        $I->see('Los tests se han generado correctamente.', '.alert-success');
        $I->see('Modelo generado correctamente.', '.alert-success');
        $I->see('Controlador generado correctamente.', '.alert-success');

        // compruebo que los archivos hayan sido generados
        $I->seeFileFound('Book.php', base_path().'/app/Models');
        $I->seeFileFound('BookController.php', base_path().'/app/Http/Controllers');
        // los tests
        foreach (config('modules.CrudGenerator.config.tests') as $test) {
            if ($test != 'Permissions') {
                $I->seeFileFound($test.'.php', base_path().'/tests/_support/Page/Functional/Books');
            }

            $I->seeFileFound($test.'Cest.php', base_path().'/tests/functional/Books');
        }

        // las vistas
        foreach (config('modules.CrudGenerator.config.views') as $view) {
            if (strpos($view, 'partials/') === false) {
                $I->seeFileFound($view.'.blade.php', base_path().'/resources/views/books');
                continue;
            } else {
                $I->seeFileFound(str_replace('partials/', '', $view).'.blade.php', base_path().'/resources/views/books/partials');
            }
        }

        // los archivos de idioma
        $I->seeFileFound('messages.php', base_path('/resources/lang/es/book'));
        $I->seeFileFound('views.php', base_path('/resources/lang/es/book'));
        $I->seeFileFound('validation.php', base_path('/resources/lang/es/book'));

        // el model binding sólo puede ser creado si la entidad no hace uso de
        // la propiedad softDeletes, es decir si no tiene la columna deleted_at
        $I->openFile(base_path().'/app/Providers/RouteServiceProvider.php');
        $I->dontSeeInThisFile("\$router->model('books', 'App\Models\Book');");

        // reviso que se halla añadido el route resource en routes.php
        $I->openFile(base_path().'/routes/web.php');
        $I->seeInThisFile("Route::resource('books','BookController');");
    }
}
