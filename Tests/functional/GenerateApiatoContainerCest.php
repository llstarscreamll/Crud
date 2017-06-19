<?php

namespace Crud;

use Crud\FunctionalTester;
use Crud\Page\Functional\Generate as Page;

class GenerateApiatoContainerCest
{
    public function _before(FunctionalTester $I)
    {
        // page setup
        new Page($I);
        $I->amLoggedAs(Page::$adminUser);

        $I->amOnPage(Page::route('?table_name='.Page::$tableName));
    }

    public function _after(FunctionalTester $I)
    {
        // copy generated code dirs to CrudExample folder
        $I->copyDir(app_path('Containers/Library'), app_path('Containers/Crud/CrudExample/apiato'));
        
        // delete generated dirs/files
        $I->deleteDir(app_path("Containers/Library"));
    }

    public function generateApiatoContainer(FunctionalTester $I)
    {
        $data = Page::$formData;

        // copy the generated files to a folder
        $data['group_main_apiato_classes'] = true;
        $data['generate_angular_module'] = false;

        $this->package = studly_case(str_singular($data['is_part_of_package']));
        $this->entity = studly_case(str_singular($data['table_name']));

        // put session var to prevent create data with model factories on the
        // angular module
        $data['skip_angular_test_models'] = true;
        
        $this->setupCodeceptPrebuild($I);

        $I->submitForm('form[name=CRUD-form]', $data);
        $I->seeElement('.alert-success');

        // asserts for generated dirs and files
        $copyedPortoContainerDir = storage_path('app/copyTest/Porto/'.$this->package);
        //$I->assertTrue(file_exists($copyedPortoContainerDir), 'Porto container copied dir');

        // los directorios deben estar creados correctamente
        $containersDir = app_path('Containers/');
        $I->assertTrue(file_exists($containersDir), 'Porto Containers dir');
        $I->assertTrue(file_exists($containersDir.$this->package), 'package container dir');
        
        // generated entity Actions
        $actionsDir = $containersDir.$this->package.'/Actions/'.$this->entity;
        $I->assertTrue(file_exists($actionsDir), 'Actions dir');
        $I->seeFileFound('ListAndSearchBooksAction.php', $actionsDir);
        $I->seeFileFound('SelectListFromBookAction.php', $actionsDir);
        $I->seeFileFound('CreateBookAction.php', $actionsDir);
        $I->seeFileFound('GetBookAction.php', $actionsDir);
        $I->seeFileFound('UpdateBookAction.php', $actionsDir);
        $I->seeFileFound('DeleteBookAction.php', $actionsDir);
        $I->seeFileFound('RestoreBookAction.php', $actionsDir);

        // Configs folder
        $configsDir = $containersDir.$this->package.'/Configs';
        $I->assertTrue(file_exists($configsDir), 'Configs dir');
        $I->seeFileFound('book-form-model.php', $configsDir);

        // Data folders
        $dataDir = $containersDir.$this->package.'/Data';
        $I->assertTrue(file_exists($dataDir), 'Data dir');
        $I->assertTrue(file_exists($dataDir.'/Criterias'), 'Data/Criterias dir');
        $I->seeFileFound('AdvancedBookSearchCriteria.php', $dataDir.'/Criterias');
        $I->assertTrue(file_exists($dataDir.'/Factories'), 'Data/Factories dir');
        $I->assertTrue(file_exists($dataDir.'/Migrations'), 'Data/Migrations dir');
        $I->assertTrue(file_exists($dataDir.'/Repositories'), 'Data/Repositories dir');
        $I->seeFileFound('BookRepository.php', $dataDir.'/Repositories');

        // seeders
        $I->assertTrue(file_exists($dataDir.'/Seeders'), 'Data/Seeders dir');
        $I->seeFileFound('BookPermissionsSeeder.php', $dataDir.'/Seeders');

        // exceptions
        $exceptionsDir = $containersDir.$this->package.'/Exceptions/';
        $I->assertTrue(file_exists($exceptionsDir), 'Exceptions dir');
        $I->seeFileFound('BookCreationFailedException.php', $exceptionsDir);
        $I->seeFileFound('BookNotFoundException.php', $exceptionsDir);

        // generated Models
        $modelsDir = $containersDir.$this->package.'/Models';
        $I->assertTrue(file_exists($modelsDir), 'Models dir');
        $I->seeFileFound('Book.php', $modelsDir);

        // generated entity Tasks
        $tasksDir = $containersDir.$this->package."/Tasks/{$this->entity}";
        $I->assertTrue(file_exists($tasksDir), 'Tasks dir');
        $I->seeFileFound('ListAndSearchBooksTask.php', $tasksDir);
        $I->seeFileFound('CreateBookTask.php', $tasksDir);
        $I->seeFileFound('GetBookTask.php', $tasksDir);
        $I->seeFileFound('UpdateBookTask.php', $tasksDir);
        $I->seeFileFound('DeleteBookTask.php', $tasksDir);
        $I->seeFileFound('RestoreBookTask.php', $tasksDir);

        // tests
        $testDir = $containersDir.$this->package.'/tests/';
        $I->assertTrue(file_exists($testDir), 'tests dir');
        $I->assertTrue(file_exists($testDir.'acceptance'), 'acceptance test');
        $I->seeFileFound('acceptance.suite.yml', $testDir);
        $I->seeFileFound('LibraryHelper.php', $testDir.'_support/Helper');
        $I->assertTrue(file_exists($testDir.'functional'), 'functional test');
        $I->seeFileFound('functional.suite.yml', $testDir);
        $I->assertTrue(file_exists($testDir.'unit'), 'unit test');
        $I->seeFileFound('unit.suite.yml', $testDir);
        $I->assertTrue(file_exists($testDir.'api'), 'api test');
        $I->seeFileFound('api.suite.yml', $testDir);
        // API entity tests
        $apiTestsFolder = $testDir.'api/'.$this->entity;
        $I->assertTrue(file_exists($apiTestsFolder), 'entity api tests dir');
        $I->seeFileFound('BookFormModelCest.php', $apiTestsFolder);
        $I->seeFileFound('SelectListFromBookCest.php', $apiTestsFolder);
        $I->seeFileFound('ListAndSearch'.str_plural($this->entity).'Cest.php', $apiTestsFolder);
        $I->seeFileFound('Create'.$this->entity.'Cest.php', $apiTestsFolder);
        $I->seeFileFound('Get'.$this->entity.'Cest.php', $apiTestsFolder);
        $I->seeFileFound('Update'.$this->entity.'Cest.php', $apiTestsFolder);
        $I->seeFileFound('Delete'.$this->entity.'Cest.php', $apiTestsFolder);
        $I->seeFileFound('Restore'.$this->entity.'Cest.php', $apiTestsFolder);

        // UI
        $I->assertTrue(file_exists($containersDir.$this->package.'/UI'), 'UI dir');

        // UI/API
        $apiDir = $containersDir.$this->package.'/UI/API';
        $I->assertTrue(file_exists($apiDir), 'UI/API dir');
        $I->assertTrue(file_exists($apiDir.'/Controllers'), 'API/Controllers dir');
        $I->seeFileFound('BookController.php', $apiDir.'/Controllers');

        // generated entity API form requests
        $apiRequestsDir = $apiDir.'/Requests';
        $I->assertTrue(file_exists($apiRequestsDir), 'API/Requests dir');
        $I->seeFileFound('CreateBookRequest.php', $apiRequestsDir."/{$this->entity}");
        $I->seeFileFound('DeleteBookRequest.php', $apiRequestsDir."/{$this->entity}");
        $I->seeFileFound('FormModelFromBookRequest.php', $apiRequestsDir."/{$this->entity}");
        $I->seeFileFound('GetBookRequest.php', $apiRequestsDir."/{$this->entity}");
        $I->seeFileFound('ListAndSearchBooksRequest.php', $apiRequestsDir."/{$this->entity}");
        $I->seeFileFound('SelectListFromBookRequest.php', $apiRequestsDir."/{$this->entity}");
        $I->seeFileFound('RestoreBookRequest.php', $apiRequestsDir."/{$this->entity}");
        $I->seeFileFound('UpdateBookRequest.php', $apiRequestsDir."/{$this->entity}");
        
        // generated API routes
        $apiRoutesDir = $apiDir.'/Routes';
        $I->assertTrue(file_exists($apiRoutesDir), 'API/Routes dir');
        $I->seeFileFound('CreateBook.v1.private.php', $apiRoutesDir);
        $I->seeFileFound('DeleteBook.v1.private.php', $apiRoutesDir);
        $I->seeFileFound('FormModelFromBook.v1.private.php', $apiRoutesDir);
        $I->seeFileFound('GetBook.v1.private.php', $apiRoutesDir);
        $I->seeFileFound('ListAndSearchBooks.v1.private.php', $apiRoutesDir);
        $I->seeFileFound('RestoreBook.v1.private.php', $apiRoutesDir);
        $I->seeFileFound('SelectListFromBook.v1.private.php', $apiRoutesDir);
        $I->seeFileFound('UpdateBook.v1.private.php', $apiRoutesDir);

        $I->assertTrue(file_exists($apiDir.'/Transformers'), 'API/Transformers dir');
        $I->seeFileFound('BookTransformer.php', $apiDir.'/Transformers');

        // Other files
        $I->seeFileFound('composer.json', $containersDir.$this->package);
    }

    private function setupCodeceptPrebuild($I)
    {
        // create the Library container dir and copy a prebuild codecept setup
        // for the container
        if (!file_exists($dir = app_path("Containers/Library"))) {
            mkdir($dir);
        }

        $codeceptBootstrap = __DIR__."/../../CrudExample/codeceptSetup/tests";

        $I->copyDir($codeceptBootstrap, $dir."/tests");
    }
}
