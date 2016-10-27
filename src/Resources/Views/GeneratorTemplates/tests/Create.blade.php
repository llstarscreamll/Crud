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
     * Prueba la funcionalidad de crear un nuevo registro.
     *
     * @param  FunctionalTester $I
@if(!empty($request->get('is_part_of_package')))
     * @group  {{$request->get('is_part_of_package')}}
     */ 
@else
     */
@endif
    public function create(FunctionalTester $I)
    {
        $I->wantTo('crear registro en módulo '.Page::$moduleName);
        
        // voy a la página de creación
        $I->amOnPage(Page::$URL);
        // veo el título de la página
        $I->see(Page::$moduleName, Page::$titleElem);
        $I->see(Page::$title, Page::$titleSmallElem);

        // los datos a enviar en el formulario
        $formData = Page::getCreateData();

        // veo los campos correspondientes en el formulario
        foreach ($formData as $name => $value) {
            $I->seeElement("*[name=$name]");
        }

        // envío el formulario
        $I->submitForm(Page::$form, $formData, Page::$formBtnElem);

        // soy redirigido al Index del módulo
        $I->seeCurrentUrlEquals(Page::$moduleURL);
        // veo mensaje de éxito en la operación
        $I->see(Page::$msgSuccess, Page::$msgSuccessElem);
        $formData = Page::unsetConfirmationFields($formData);
        $I->seeRecord('<?= $gen->table_name ?>', $formData);
    }

}