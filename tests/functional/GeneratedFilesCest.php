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

    /**
     * Cleans the generated Container directory.
     */
    public function _after(FunctionalTester $I)
    {
        // $I->deleteDir(app_path('Containers/'.$this->package));
    }

    public function checkPortoContainerFilesGeneration(FunctionalTester $I)
    {
        $I->wantTo('generate a Porto Container');

        $data = Page::$formData;
        $data['app_type'] = 'porto_container';
        $this->package = studly_case(str_singular($data['is_part_of_package']));
        $this->entity = studly_case(str_singular($data['table_name']));
        
        $I->submitForm('form[name=CRUD-form]', $data);

        // los directorios deben estar creados correctamente
        $I->assertTrue(file_exists(app_path('Containers')), 'Containers folder');
        $I->assertTrue(file_exists(app_path('Containers/'.$this->package)), 'package container folder');
        
        // generated entity Actions
        // TODO: actions should be wrapped on entity folder, like Actions/Book/CreateBookAction.php
        $actionsDir = app_path('Containers/'.$this->package.'/Actions');
        $I->assertTrue(file_exists($actionsDir), 'Actions folder');
        $I->seeFileFound('ListAndSearchBooksAction.php', $actionsDir);
        $I->seeFileFound('CreateBookAction.php', $actionsDir);
        $I->seeFileFound('UpdateBookAction.php', $actionsDir);
        $I->seeFileFound('DeleteBookAction.php', $actionsDir);
        $I->seeFileFound('RestoreBookAction.php', $actionsDir);

        // Data folders
        $dataDir = app_path('Containers/'.$this->package.'/Data');
        $I->assertTrue(file_exists($dataDir), 'Data folder');
        $I->assertTrue(file_exists($dataDir.'/Criterias'), 'Data/Criterias folder');
        $I->assertTrue(file_exists($dataDir.'/Factories'), 'Data/Factories folder');
        $I->assertTrue(file_exists($dataDir.'/Migrations'), 'Data/Migrations folder');
        $I->assertTrue(file_exists($dataDir.'/Repositories'), 'Data/Repositories folder');
        $I->assertTrue(file_exists($dataDir.'/Seeders'), 'Data/Seeders folder');

        // generated Models
        $I->assertTrue(file_exists(app_path('Containers/'.$this->package.'/Models')), 'Models folder');

        // generated entity Tasks
        // TODO: tasks should be wrapped on entity folder, like Tasks/Book/CreateBookTask.php
        $tasksDir = app_path('Containers/'.$this->package.'/Tasks');
        $I->assertTrue(file_exists($tasksDir), 'Tasks folder');
        $I->seeFileFound('ListBooksTask.php', $tasksDir);
        $I->seeFileFound('CreateBookTask.php', $tasksDir);
        $I->seeFileFound('UpdateBookTask.php', $tasksDir);
        $I->seeFileFound('DeleteBookTask.php', $tasksDir);
        $I->seeFileFound('RestoreBookTask.php', $tasksDir);

        // tests
        $I->assertTrue(file_exists(app_path('Containers/'.$this->package.'/tests')), 'tests folder');
        $I->assertTrue(file_exists(app_path('Containers/'.$this->package.'/tests/acceptance')), 'acceptance test');
        $I->seeFileFound('acceptance.suite.yml', app_path('Containers/'.$this->package.'/tests'));
        $I->assertTrue(file_exists(app_path('Containers/'.$this->package.'/tests/functional')), 'functional test');
        $I->seeFileFound('functional.suite.yml', app_path('Containers/'.$this->package.'/tests'));
        $I->assertTrue(file_exists(app_path('Containers/'.$this->package.'/tests/unit')), 'unit test');
        $I->seeFileFound('unit.suite.yml', app_path('Containers/'.$this->package.'/tests'));
        $I->assertTrue(file_exists(app_path('Containers/'.$this->package.'/tests/api')), 'api test');
        $I->seeFileFound('api.suite.yml', app_path('Containers/'.$this->package.'/tests'));
        // API entity tests
        $apiTestsFolder = app_path('Containers/'.$this->package.'/tests/api/'.$this->entity);
        $I->assertTrue(file_exists($apiTestsFolder), 'entity api tests folder');
        $I->seeFileFound('List'.str_plural($this->entity).'Test.php', $apiTestsFolder);
        $I->seeFileFound('Create'.$this->entity.'Test.php', $apiTestsFolder);
        $I->seeFileFound('Update'.$this->entity.'Test.php', $apiTestsFolder);
        $I->seeFileFound('Delete'.$this->entity.'Test.php', $apiTestsFolder);
        $I->seeFileFound('Restore'.$this->entity.'Test.php', $apiTestsFolder);

        // UI
        $I->assertTrue(file_exists(app_path('Containers/'.$this->package.'/UI')), 'UI folder');

        // UI/API
        $I->assertTrue(file_exists(app_path('Containers/'.$this->package.'/UI/API')), 'UI/API folder');
        $I->assertTrue(file_exists(app_path('Containers/'.$this->package.'/UI/API/Controllers')), 'API/Controllers folder');

        // generated entity API requests
        $I->assertTrue(file_exists(app_path('Containers/'.$this->package.'/UI/API/Requests')), 'API/Requests folder');
        $I->seeFileFound('ListAllBooksRequest.php', app_path('Containers/'.$this->package.'/UI/API/Requests'));
        $I->seeFileFound('CreateBookRequest.php', app_path('Containers/'.$this->package.'/UI/API/Requests'));
        $I->seeFileFound('UpdateBookRequest.php', app_path('Containers/'.$this->package.'/UI/API/Requests'));
        $I->seeFileFound('DeleteBookRequest.php', app_path('Containers/'.$this->package.'/UI/API/Requests'));
        $I->seeFileFound('RestoreBookRequest.php', app_path('Containers/'.$this->package.'/UI/API/Requests'));
        
        // generated API routes
        $apiRoutesDir = app_path('Containers/'.$this->package.'/UI/API/Routes');
        $I->assertTrue(file_exists($apiRoutesDir), 'API/Routes folder');
        $I->seeFileFound('ListBooks.v1.private.php', $apiRoutesDir);
        $I->seeFileFound('CreateBook.v1.private.php', $apiRoutesDir);
        $I->seeFileFound('UpdateBook.v1.private.php', $apiRoutesDir);
        $I->seeFileFound('DeleteBook.v1.private.php', $apiRoutesDir);
        $I->seeFileFound('RestoreBook.v1.private.php', $apiRoutesDir);

        $I->assertTrue(file_exists(app_path('Containers/'.$this->package.'/UI/API/Transformers')), 'API/Transformers folder');

        // WEB folders
        $uiWebDir = app_path('Containers/'.$this->package.'/UI/WEB');
        $I->assertTrue(file_exists($uiWebDir), 'UI/WEB folder');
        $I->assertTrue(file_exists($uiWebDir.'/Controllers'), 'WEB/Controllers folder');
        $I->assertTrue(file_exists($uiWebDir.'/Requests'), 'WEB/Requests folder');
        $I->assertTrue(file_exists($uiWebDir.'/Routes'), 'WEB/Routes folder');
        $I->assertTrue(file_exists($uiWebDir.'/Views'), 'WEB/Views folder');

        // CLI folders
        $I->assertTrue(file_exists(app_path('Containers/'.$this->package.'/UI/CLI')), 'UI/CLI folder');

        // Other files
        $I->seeFileFound('composer.json', app_path('Containers/'.$this->package));
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
