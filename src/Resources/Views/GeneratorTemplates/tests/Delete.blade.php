<?php
/* @var $gen llstarscreamll\CrudGenerator\Providers\TestsGenerator */
/* @var $fields [] */
/* @var $test [] */
/* @var $request Request */
?>
<?='<?php'?>


<?= $gen->getClassCopyRightDocBlock() ?>


namespace {{$gen->studlyCasePlural()}};

use \FunctionalTester;
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
     * Prueba la funcionalidad de eliminar un modelo.
     *
     * @param  FunctionalTester $I
     */
    public function delete(FunctionalTester $I)
    {
        $I->wantTo('eliminar registro en módulo '.Page::$moduleName);

        // creo el registro de prueba
        Page::have{{$gen->modelClassName()}}($I);

        // voy a la página de detalles del registro
        $I->amOnPage(Page::route('/'.Page::${{$gen->modelVariableName()}}Data['id']));
        // doy clic al botón para mover registro a papelera
        $I->click(Page::$deleteBtn, Page::$deleteBtnElem);

        // soy redireccionado al index y veo mensaje de confirmación
        $I->seeCurrentUrlEquals(Page::$moduleURL);
        $I->see(Page::$msgSuccess, Page::$msgSuccessElem);
        // veo mensaje de que no hay datos de capacitaciones
        $I->see(Page::$noDataFountMsg, Page::$noDataFountMsgElem);
    }
}