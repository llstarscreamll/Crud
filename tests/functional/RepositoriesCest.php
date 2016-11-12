<?php

namespace Crud;

use Crud\FunctionalTester;
use Crud\Page\Functional\Generate as Page;

class RepositoriesCest
{
    public function _before(FunctionalTester $I)
    {
        new Page($I);
        $I->amLoggedAs(Page::$adminUser);

        $I->seeAuthentication();
        $I->amOnPage(Page::route('?table_name='.Page::$tableName));
        $I->see(Page::$title, Page::$titleElem);

        // envío el formulario de creación del CRUD
        $I->submitForm('form[name=CRUD-form]', Page::$formData);
    }

    /**
     * Prueba el código del servicio generado.
     *
     * @param  FunctionalTester $I
     */
    public function generateRepositories(FunctionalTester $I)
    {
        $I->wantTo('revisar código de los repositorios generados');

        // el contrato del repositorio
        $I->openFile(base_path().'/app/Repositories/Contracts/BookRepository.php');
        $repo = file_get_contents(__DIR__.'/../_data/repositories/Contracts/BookRepository.php');
        $I->seeInThisFile($repo);

        // la implementación del contrato
        $I->openFile(base_path().'/app/Repositories/BookEloquentRepository.php');
        $implementation = file_get_contents(__DIR__.'/../_data/repositories/BookEloquentRepository.php');
        $I->seeInThisFile($implementation);

        // la clase que aplica la búsqueda en el modelo "SearchCriteria"
        $I->openFile(base_path().'/app/Repositories/Criterias/SearchBookCriteria.php');
        $criteria = file_get_contents(__DIR__.'/../_data/repositories/Criterias/SearchBookCriteria.php');
        $I->seeInThisFile($criteria);
    }
}
