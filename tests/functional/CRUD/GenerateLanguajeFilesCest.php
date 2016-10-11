<?php
namespace CRUD;

use \FunctionalTester;
use Page\Functional\CRUD\Generate as Page;

class GenerateLanguajeFilesCest
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
    public function checkLanguageFilesCode(FunctionalTester $I)
    {
        $I->am('Developer');
        $I->wantTo('revisar las lineas de codigo del controlador');

        $I->amOnPage('/showOptions?table_name=books');
        $I->see('CrudGenerator', 'h1');

        // envío el formulario de creación del CRUD
        $I->submitForm('form[name=CRUD-form]', Page::$formData);

        // reviso que se esté llamando a las clases de los modelos de las que
        // depende el controlador correctamente
        $I->openFile('resources/lang/es/book/views.php');

        // veo que los campos que son requeridos en la validación tienen un asterisco (*)
        $I->seeInThisFile("'reason_id' => 'Motivo *',");
        $I->seeInThisFile("'name' => 'Nombre *',");
        $I->seeInThisFile("'author' => 'Autor *',");
        $I->seeInThisFile("'genre' => 'Género *',");
        $I->seeInThisFile("'stars' => 'Estrellas *',");
        $I->seeInThisFile("'published_year' => 'Fecha De Publicación *',");
        $I->seeInThisFile("'status' => 'Estado *',");
        $I->seeInThisFile("'unlocking_word' => 'Palabra De Desbloqueo *',");
		$I->seeInThisFile("'unlocking_word_confirmation' => 'Confirmar Palabra De Desbloqueo *',");
    }
}
