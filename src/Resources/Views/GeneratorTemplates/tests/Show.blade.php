<?php
/* @var $gen llstarscreamll\CrudGenerator\Providers\TestsGenerator */
/* @var $fields [] */
/* @var $test [] */
/* @var $request Request */
?>
<?='<?php'?>


<?= $gen->getClassCopyRightDocBlock() ?>


namespace {{$gen->studlyCasePlural()}};

use FunctionalTester;
use Page\Functional\{{$gen->studlyCasePlural()}}\{{$test}} as Page;

class {{$test}}Cest
{
    /**
     * Las acciones a realizar antes de cada test.
     *
     * @param  FunctionalTester $I
     */
    public function _before(FunctionalTester $I)
    {
        new Page($I);
        $I->amLoggedAs(Page::$adminUser);
    }

    /**
     * Prueba la funcionalidad de consultar la información de un modelo, sólo
     * lectura.
     *
     * @param  FunctionalTester $I
     */
    public function show(FunctionalTester $I)
    {
        $I->wantTo('ver detalles de registro en módulo '.Page::$moduleName);

        // creo el registro de prueba
        Page::have{{$gen->modelClassName()}}($I);

        // voy a la página de detalles del registro
        $I->amOnPage(Page::route('/'.Page::${{$gen->modelVariableName()}}Data['id']));
        // veo el título de la página
        $I->see(Page::$moduleName, Page::$titleElem);
        $I->see(Page::$title, Page::$titleSmallElem);

        // veo los datos del registro en el formulario de sólo lectura
        $data = Page::${{$gen->modelVariableName()}}Data;
        $I->seeInFormFields(Page::$form, Page::unsetHiddenFields($data));
    }
}