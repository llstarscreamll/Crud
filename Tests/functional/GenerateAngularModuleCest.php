<?php

namespace Crud;

use Crud\FunctionalTester;
use Crud\Page\Functional\Generate as Page;

class GenerateAngularModuleCest
{
    /**
     * The path where the angular module will be generated.
     * @var string
     */
    private $angularModuleLocation;

    public function _before(FunctionalTester $I)
    {
        // page setup
        new Page($I);
        $I->amLoggedAs(Page::$adminUser);

        $I->amOnPage(Page::route('?table_name='.Page::$tableName));

        $this->angularModuleLocation = storage_path('app/copyTest/Angular/');
    }

    public function _after(FunctionalTester $I)
    {
        // copy generated code dirs to CrudExample folder
        $I->copyDir($this->angularModuleLocation."library", app_path('Containers/Crud/CrudExample/angular'));
        
        // delete old generated dirs
        $I->deleteDir(storage_path("app/crud/options/books.php"));
        $I->deleteDir(storage_path("app/copyTest/"));
    }

    public function generateAngularModule(FunctionalTester $I)
    {
        $data = Page::$formData;

        // copy the generated files to a folder
        $data['angular_module_location'] = $this->angularModuleLocation;
        $data['generate_angular_module'] = true;
        $data['generate_porto_container'] = false; // don't generate apiato container

        $this->package = studly_case(str_singular($data['is_part_of_package']));
        $this->entity = studly_case(str_singular($data['table_name']));

        // put session var to prevent create data with model factories on the
        // angular module
        $data['skip_angular_test_models'] = true;

        $I->submitForm('form[name=CRUD-form]', $data);
        $I->seeElement('.alert-success');

        $I->assertTrue(file_exists(storage_path('app/crud/options')), 'options output folder');
        $I->seeFileFound('books.php', storage_path('app/crud/options/'));

        // asserts for generated dirs and files
        $slugModule = str_slug($this->package, "-");
        $slugEntity = str_slug($this->entity, "-");

        $copyedModuleDir = $this->angularModuleLocation.$slugModule;
        $I->assertTrue(file_exists($copyedModuleDir), 'Angular copied dir');

        $moduleDir = $this->angularModuleLocation.$slugModule.'/';
        $I->assertTrue(file_exists($moduleDir), 'NG Module dir');

        $I->seeFileFound($slugModule.'.module.ts', $moduleDir);
        $I->seeFileFound($slugModule.'-routing.module.ts', $moduleDir);

        // models
        $modelsDir = $moduleDir.'models/';
        $I->assertTrue(file_exists($modelsDir), 'NG models dir');
        $I->seeFileFound('book.ts', $modelsDir);
        $I->seeFileFound('bookPagination.ts', $modelsDir);

        // translations
        $transDir = $moduleDir.'translations/es/';
        $I->assertTrue(file_exists($transDir), 'NG translations dir');
        $I->seeFileFound('book.ts', $transDir);
        $I->seeFileFound('index.ts', $transDir);

        // actions
        $actionsDir = $moduleDir.'actions/';
        $I->assertTrue(file_exists($actionsDir), 'NG actions dir');
        $I->seeFileFound('book.actions.ts', $actionsDir);

        // reducers
        $reducersDir = $moduleDir.'reducers/';
        $I->assertTrue(file_exists($reducersDir), 'NG reducers dir');
        $I->seeFileFound('book.reducer.ts', $reducersDir);

        // routes
        $routesDir = $moduleDir.'routes/';
        $I->seeFileFound('index.ts', $routesDir);
        $I->seeFileFound('book.routes.ts', $routesDir);

        // effects
        $effectsDir = $moduleDir.'effects/';
        $I->assertTrue(file_exists($effectsDir), 'NG effects dir');
        $I->seeFileFound('book.effects.ts', $effectsDir);
        $I->seeFileFound('index.ts', $effectsDir);

        // services
        $servicesDir = $moduleDir.'services/';
        $I->assertTrue(file_exists($servicesDir), 'NG services dir');
        $I->seeFileFound('book.service.ts', $servicesDir);
        $I->seeFileFound('index.ts', $servicesDir);

        // components
        $componentsDir = $moduleDir.'components/';
        $I->seeFileFound('index.ts', $componentsDir);
        $entityComponentsDir = $componentsDir.$slugEntity.'/';
        $I->assertTrue(file_exists($entityComponentsDir), 'NG components dir');
        $I->seeFileFound('book-abstract.component.ts', $entityComponentsDir);
        $I->seeFileFound('book-form.component.ts', $entityComponentsDir);
        $I->seeFileFound('book-form.component.html', $entityComponentsDir);
        $I->seeFileFound('book-form.component.spec.ts', $entityComponentsDir);
        $I->seeFileFound('book-search-basic.component.ts', $entityComponentsDir);
        $I->seeFileFound('book-search-basic.component.spec.ts', $entityComponentsDir);
        $I->seeFileFound('book-search-basic.component.html', $entityComponentsDir);
        $I->seeFileFound('book-search-advanced.component.ts', $entityComponentsDir);
        $I->seeFileFound('book-search-advanced.component.spec.ts', $entityComponentsDir);
        $I->seeFileFound('book-search-advanced.component.html', $entityComponentsDir);
        $I->seeFileFound('books-table.component.ts', $entityComponentsDir);
        $I->seeFileFound('books-table.component.spec.ts', $entityComponentsDir);
        $I->seeFileFound('books-table.component.html', $entityComponentsDir);
        $I->seeFileFound('index.ts', $entityComponentsDir);

        // pages
        $pagesDir = $moduleDir.'pages/';
        $I->seeFileFound('index.ts', $pagesDir);
        $entitypagesDir = $pagesDir.$slugEntity.'/';
        $I->assertTrue(file_exists($entitypagesDir), 'NG pages dir');
        $I->seeFileFound('book-abstract.page.ts', $entitypagesDir);
        $I->seeFileFound('list-and-search-books.page.ts', $entitypagesDir);
        $I->seeFileFound('list-and-search-books.page.spec.ts', $entitypagesDir);
        $I->seeFileFound('list-and-search-books.page.html', $entitypagesDir);
        $I->seeFileFound('book-form.page.ts', $entitypagesDir);
        $I->seeFileFound('book-form.page.spec.ts', $entitypagesDir);
        $I->seeFileFound('book-form.page.html', $entitypagesDir);
        $I->seeFileFound('index.ts', $entitypagesDir);

        // utils folder
        $utilsDir = $moduleDir.'utils/';
        $I->seeFileFound('book-testing.util.ts', $utilsDir);
    }
}
