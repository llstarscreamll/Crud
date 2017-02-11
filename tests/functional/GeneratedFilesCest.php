<?php

namespace Crud;

use Crud\FunctionalTester;
use Crud\Page\Functional\Generate as Page;

class GeneratedFilesCest
{
    public function _before(FunctionalTester $I)
    {
        new Page($I);
        $I->amLoggedAs(Page::$adminUser);

        $I->amOnPage(Page::route('?table_name='.Page::$tableName));
        $I->see(Page::$title, Page::$titleElem);
    }

    public function checkPortoContainerFilesGeneration(FunctionalTester $I)
    {
        $I->wantTo('generate a Porto Container');

        $data = Page::$formData;
        $data['app_type'] = 'porto_container';
        
        $I->submitForm('form[name=CRUD-form]', $data);

        $package = studly_case(str_singular($data['is_part_of_package']));

        // los directorios deben estar creados correctamente
        $I->assertTrue(file_exists(app_path('Containers')), 'Containers folder');
        $I->assertTrue(file_exists(app_path('Containers/'.$package)), 'package container folder');
        $I->assertTrue(file_exists(app_path('Containers/'.$package.'/Actions')), 'Actions folder');
        // Data folders
        $I->assertTrue(file_exists(app_path('Containers/'.$package.'/Data')), 'Data folder');
        $I->assertTrue(file_exists(app_path('Containers/'.$package.'/Data/Criterias')), 'Data/Criterias folder');
        $I->assertTrue(file_exists(app_path('Containers/'.$package.'/Data/Factories')), 'Data/Factories folder');
        $I->assertTrue(file_exists(app_path('Containers/'.$package.'/Data/Migrations')), 'Data/Migrations folder');
        $I->assertTrue(file_exists(app_path('Containers/'.$package.'/Data/Repositories')), 'Data/Repositories folder');
        $I->assertTrue(file_exists(app_path('Containers/'.$package.'/Data/Seeders')), 'Data/Seeders folder');

        $I->assertTrue(file_exists(app_path('Containers/'.$package.'/Models')), 'Models folder');
        $I->assertTrue(file_exists(app_path('Containers/'.$package.'/Tasks')), 'Tasks folder');
        $I->assertTrue(file_exists(app_path('Containers/'.$package.'/UI')), 'UI folder');
        $I->assertTrue(file_exists(app_path('Containers/'.$package.'/Tests')), 'Tests folder');
        // API folders
        $I->assertTrue(file_exists(app_path('Containers/'.$package.'/UI/API')), 'UI/API folder');
        $I->assertTrue(file_exists(app_path('Containers/'.$package.'/UI/API/Controllers')), 'API/Controllers folder');
        $I->assertTrue(file_exists(app_path('Containers/'.$package.'/UI/API/Requests')), 'API/Requests folder');
        $I->assertTrue(file_exists(app_path('Containers/'.$package.'/UI/API/Routes')), 'API/Routes folder');
        $I->assertTrue(file_exists(app_path('Containers/'.$package.'/UI/API/Transformers')), 'API/Transformers folder');
        // WEB folders
        $I->assertTrue(file_exists(app_path('Containers/'.$package.'/UI/WEB')), 'UI/WEB folder');
        $I->assertTrue(file_exists(app_path('Containers/'.$package.'/UI/WEB/Controllers')), 'WEB/Controllers folder');
        $I->assertTrue(file_exists(app_path('Containers/'.$package.'/UI/WEB/Requests')), 'WEB/Requests folder');
        $I->assertTrue(file_exists(app_path('Containers/'.$package.'/UI/WEB/Routes')), 'WEB/Routes folder');
        $I->assertTrue(file_exists(app_path('Containers/'.$package.'/UI/WEB/Views')), 'WEB/Views folder');
        // CLI folders
        $I->assertTrue(file_exists(app_path('Containers/'.$package.'/UI/CLI')), 'UI/CLI folder');

        // generated Actions files/clases
        $I->seeFileFound('composer.json', app_path('Containers/'.$package));
        $I->seeFileFound('ListAndSearchBooksAction.php', app_path('Containers/'.$package.'/Actions'));
        $I->seeFileFound('CreateBookAction.php', app_path('Containers/'.$package.'/Actions'));
        $I->seeFileFound('UpdateBookAction.php', app_path('Containers/'.$package.'/Actions'));
        $I->seeFileFound('DeleteBookAction.php', app_path('Containers/'.$package.'/Actions'));
        $I->seeFileFound('RestoreBookAction.php', app_path('Containers/'.$package.'/Actions'));

        $I->seeFileFound('composer.json', app_path('Containers/'.$package));

        // generated Actions files/clases
        $I->seeFileFound('ListAndSearchBooksAction.php', app_path('Containers/'.$package.'/Actions'));
        $I->seeFileFound('CreateBookAction.php', app_path('Containers/'.$package.'/Actions'));
        $I->seeFileFound('UpdateBookAction.php', app_path('Containers/'.$package.'/Actions'));
        $I->seeFileFound('DeleteBookAction.php', app_path('Containers/'.$package.'/Actions'));
        $I->seeFileFound('RestoreBookAction.php', app_path('Containers/'.$package.'/Actions'));

        // generated Tasks files/clases
        $I->seeFileFound('ListBooksTask.php', app_path('Containers/'.$package.'/Tasks'));
        $I->seeFileFound('CreateBookTask.php', app_path('Containers/'.$package.'/Tasks'));
        $I->seeFileFound('UpdateBookTask.php', app_path('Containers/'.$package.'/Tasks'));
        $I->seeFileFound('DeleteBookTask.php', app_path('Containers/'.$package.'/Tasks'));
        $I->seeFileFound('RestoreBookTask.php', app_path('Containers/'.$package.'/Tasks'));

        // generated API route files
        $I->seeFileFound('ListBooks.v1.private.php', app_path('Containers/'.$package.'/UI/API/Routes'));
        $I->seeFileFound('CreateBook.v1.private.php', app_path('Containers/'.$package.'/UI/API/Routes'));
        $I->seeFileFound('UpdateBook.v1.private.php', app_path('Containers/'.$package.'/UI/API/Routes'));
        $I->seeFileFound('DeleteBook.v1.private.php', app_path('Containers/'.$package.'/UI/API/Routes'));
        $I->seeFileFound('RestoreBook.v1.private.php', app_path('Containers/'.$package.'/UI/API/Routes'));

        // generated API request files
        $I->seeFileFound('ListAllBooksRequest.php', app_path('Containers/'.$package.'/UI/API/Requests'));
        $I->seeFileFound('CreateBookRequest.php', app_path('Containers/'.$package.'/UI/API/Requests'));
        $I->seeFileFound('UpdateBookRequest.php', app_path('Containers/'.$package.'/UI/API/Requests'));
        $I->seeFileFound('DeleteBookRequest.php', app_path('Containers/'.$package.'/UI/API/Requests'));
        $I->seeFileFound('RestoreBookRequest.php', app_path('Containers/'.$package.'/UI/API/Requests'));
    }

    /**
     * Comprueba la funcionalidad de crear los ficheros requeridos para la CRUD app.
     *
     * @param FunctionalTester $I
     */
    public function checkLaravelAppFilesGeneration(FunctionalTester $I)
    {
        $I->wantTo('crear aplicacion Laravel App CRUD');

        $I->submitForm('form[name=CRUD-form]', Page::$formData);

        // veo los mensajes de operación exitosa
        $I->see('Los tests se han generado correctamente.', '.alert-success');
        $I->see('Modelo generado correctamente', '.alert-success');
        $I->see('Controlador generado correctamente', '.alert-success');
        // hay muchos otros mensajes

        // compruebo que los archivos de la app hayan sido generados
        $I->seeFileFound('Book.php', base_path('app/Models'));
        $I->seeFileFound('BookController.php', base_path('app/Http/Controllers'));
        $I->seeFileFound('BookService.php', base_path('app/Services'));
        $I->seeFileFound('BookRepository.php', base_path('app/Repositories/Contracts'));
        $I->seeFileFound('SearchBookCriteria.php', base_path('app/Repositories/Criterias'));
        $I->seeFileFound('BookEloquentRepository.php', base_path('app/Repositories'));
        $I->seeFileFound('book.php', base_path('/resources/lang/es'));
        // reviso que se hallan añadido las rutas en web.php
        $I->openFile(base_path('routes/web.php'));
        $I->seeInThisFile("Route::resource('books', 'BookController');");

        // los tests
        foreach (config('modules.crud.config.tests') as $test) {
            if ($test != 'Permissions') {
                $I->seeFileFound($test.'.php', base_path('tests/_support/Page/Functional/Books'));
            }
            $I->seeFileFound($test.'Cest.php', base_path('tests/functional/Books'));
        }

        // las vistas
        foreach (config('modules.crud.config.views') as $view) {
            if (strpos($view, 'partials/') === false) {
                $I->seeFileFound($view.'.blade.php', base_path('resources/views/books'));
            } else {
                $I->seeFileFound(
                    str_replace('partials/', '', $view).'.blade.php',
                    base_path('resources/views/books/partials')
                );
            }
        }
    }
}
