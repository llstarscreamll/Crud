<?php

namespace Crud;

use Crud\Page\Functional\Generate as Page;

class GenerateViewsCest
{
    /**
     * El tema de las vistas seleccionado.
     *
     * @var string
     */
    protected $theme;

    public function _before(FunctionalTester $I)
    {
        new Page($I);
        $I->amLoggedAs(Page::$adminUser);
    }

    /**
     * Comprueba que hayan sido genearados los archivos de las vistas con el tema
     * Bootstrap.
     *
     * @param FunctionalTester $I
     */
    public function createBootstrapThemeViews(FunctionalTester $I)
    {
        $I->wantTo('comprobar las vistas creadas con el tema Bootstrap');

        // el tema seleccionado, Bootstrap por defecto
        $this->theme = Page::$formData['UI_theme'];

        $I->amOnPage(Page::route('?table_name='.Page::$tableName));
        $I->see(Page::$title, Page::$titleElem);
        $I->submitForm('form[name=CRUD-form]', Page::$formData);

        $this->checkGeneratedViews($I);
    }

    /**
     * Comprueba que hayan sido genearados los archivos de las vistas con el tema
     * Inspinia.
     *
     * @param FunctionalTester $I
     */
    public function createInspiniaThemeViews(FunctionalTester $I)
    {
        $I->wantTo('comprobar las vistas creadas con el tema Inspinia');

        $formData = Page::$formData;

        // el tema seleccionado, Inspinia
        $this->theme = ($formData['UI_theme'] = 'Inspinia');

        $I->amOnPage(Page::route('?table_name='.Page::$tableName));
        $I->see(Page::$title, Page::$titleElem);
        $I->submitForm('form[name=CRUD-form]', $formData);

        $this->checkGeneratedViews($I);
    }

    private function checkGeneratedViews(FunctionalTester $I)
    {
        // la vista create
        $I->openFile(base_path()."/resources/views/books/create.blade.php");
        $view = file_get_contents(__DIR__."/../_data/views/$this->theme/create.blade.php");
        $I->seeInThisFile($view);

        // la vista edit
        $I->openFile(base_path()."/resources/views/books/edit.blade.php");
        $view = file_get_contents(__DIR__."/../_data/views/$this->theme/edit.blade.php");
        $I->seeInThisFile($view);

        // la vista index
        $I->openFile(base_path()."/resources/views/books/index.blade.php");
        $view = file_get_contents(__DIR__."/../_data/views/$this->theme/index.blade.php");
        $I->seeInThisFile($view);

        // la vista show
        $I->openFile(base_path()."/resources/views/books/show.blade.php");
        $view = file_get_contents(__DIR__."/../_data/views/$this->theme/show.blade.php");
        $I->seeInThisFile($view);

        // partial form-assets
        $I->openFile(base_path()."/resources/views/books/partials/form-assets.blade.php");
        $view = file_get_contents(__DIR__."/../_data/views/$this->theme/partials/form-assets.blade.php");
        $I->seeInThisFile($view);

        // partial form-fields
        $I->openFile(base_path()."/resources/views/books/partials/form-fields.blade.php");
        $view = file_get_contents(__DIR__."/../_data/views/$this->theme/partials/form-fields.blade.php");
        $I->seeInThisFile($view);

        // partial form-scripts
        $I->openFile(base_path()."/resources/views/books/partials/form-scripts.blade.php");
        $view = file_get_contents(__DIR__."/../_data/views/$this->theme/partials/form-scripts.blade.php");
        $I->seeInThisFile($view);

        // partial heading
        $I->openFile(base_path()."/resources/views/books/partials/heading.blade.php");
        $view = file_get_contents(__DIR__."/../_data/views/$this->theme/partials/heading.blade.php");
        $I->seeInThisFile($view);

        // partial hidden-form-fields
        $I->openFile(base_path()."/resources/views/books/partials/hidden-form-fields.blade.php");
        $view = file_get_contents(__DIR__."/../_data/views/$this->theme/partials/hidden-form-fields.blade.php");
        $I->seeInThisFile($view);

        // partial index-assets
        $I->openFile(base_path()."/resources/views/books/partials/index-assets.blade.php");
        $view = file_get_contents(__DIR__."/../_data/views/$this->theme/partials/index-assets.blade.php");
        $I->seeInThisFile($view);

        // partial index-buttons
        $I->openFile(base_path()."/resources/views/books/partials/index-buttons.blade.php");
        $view = file_get_contents(__DIR__."/../_data/views/$this->theme/partials/index-buttons.blade.php");
        $I->seeInThisFile($view);

        // partial index-create-form
        $I->openFile(base_path()."/resources/views/books/partials/index-create-form.blade.php");
        $view = file_get_contents(__DIR__."/../_data/views/$this->theme/partials/index-create-form.blade.php");
        $I->seeInThisFile($view);

        // partial index-table
        $I->openFile(base_path()."/resources/views/books/partials/index-table.blade.php");
        $view = file_get_contents(__DIR__."/../_data/views/$this->theme/partials/index-table.blade.php");
        $I->seeInThisFile($view);
    }
}
