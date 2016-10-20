<?php

namespace CrudGenerator;

use CrudGenerator\Page\Functional\Generate as Page;

class GenerateViewsCest
{
    public function _before(FunctionalTester $I)
    {
        new Page($I);
        $I->amLoggedAs(Page::$adminUser);

        $I->amOnPage(Page::route('?table_name='.Page::$tableName));
        $I->see(Page::$title, Page::$titleElem);

        // envío el formulario de creación del CRUD
        $I->submitForm('form[name=CRUD-form]', Page::$formData);
    }

    /**
     * Comprueba las líneas de código generadas en las vistas del CRUD.
     *
     * @param FunctionalTester $I
     */
    public function checkViewsCode(FunctionalTester $I)
    {
        $I->am('Developer');
        $I->wantTo('revisar las lineas de codigo de las vistas');

        // la vista create
        $I->openFile(base_path().'/resources/views/books/create.blade.php');
        $view = file_get_contents(__DIR__.'/../_data/views/create.blade.php');
        $I->seeInThisFile($view);

        // la vista edit
        $I->openFile(base_path().'/resources/views/books/edit.blade.php');
        $view = file_get_contents(__DIR__.'/../_data/views/edit.blade.php');
        $I->seeInThisFile($view);

        // la vista index
        $I->openFile(base_path().'/resources/views/books/index.blade.php');
        $view = file_get_contents(__DIR__.'/../_data/views/index.blade.php');
        $I->seeInThisFile($view);

        // la vista show
        $I->openFile(base_path().'/resources/views/books/show.blade.php');
        $view = file_get_contents(__DIR__.'/../_data/views/show.blade.php');
        $I->seeInThisFile($view);

        // partial form-fields
        $I->openFile(base_path().'/resources/views/books/partials/form-fields.blade.php');
        $view = file_get_contents(__DIR__.'/../_data/views/partials/form-fields.blade.php');
        $I->seeInThisFile($view);

        // partial hidden-form-fields
        $I->openFile(base_path().'/resources/views/books/partials/hidden-form-fields.blade.php');
        $view = file_get_contents(__DIR__.'/../_data/views/partials/hidden-form-fields.blade.php');
        $I->seeInThisFile($view);

        // partial index-create-form
        $I->openFile(base_path().'/resources/views/books/partials/index-create-form.blade.php');
        $view = file_get_contents(__DIR__.'/../_data/views/partials/index-create-form.blade.php');
        $I->seeInThisFile($view);

        // partial index-table
        $I->openFile(base_path().'/resources/views/books/partials/index-table.blade.php');
        $view = file_get_contents(__DIR__.'/../_data/views/partials/index-table.blade.php');
        $I->seeInThisFile($view);
    }
}
