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
     * Prueba la funcionalidad de crear un nuevo modelo.
     *
     * @param  FunctionalTester $I
     */
    public function create(FunctionalTester $I)
    {
        $I->wantTo('crear registro en módulo '.Page::$moduleName);
        
        // voy a la página del módulo
        $I->amOnPage(Page::$URL);
        // veo el título de la página
        $I->see(Page::$moduleName, Page::$titleElem);
        $I->see(Page::$title, Page::$titleSmallElem);

        // envío el formulario
        $I->submitForm(Page::$form, Page::getCreateData(), Page::$formBtnElem);

        // soy redirigido al index del módulo
        $I->seeCurrentUrlEquals(Page::$moduleURL);
        
        // veo mensajes de éxito en la operación
        $I->see(Page::$msgSuccess, Page::$msgSuccessElem);
    }

}