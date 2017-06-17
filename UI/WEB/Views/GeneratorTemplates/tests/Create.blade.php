<?php
/* @var $crud App\Containers\Crud\Providers\TestsGenerator */
/* @var $fields [] */
/* @var $test [] */
/* @var $request Request */
?>
<?='<?php'?>


<?= $crud->getClassCopyRightDocBlock() ?>


namespace <?= $crud->studlyCasePlural() ?>;

use FunctionalTester;
use Page\Functional\<?= $crud->studlyCasePlural() ?>\<?= $test ?> as Page;

class <?= $test ?>Cest
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
<?php if (!empty($request->get('is_part_of_package'))) { ?>
     * @group  <?= $request->get('is_part_of_package')."\n" ?>
     */ 
<?php } else { ?>
     */
<?php } ?>
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
        $I->dontSeeFormErrors();

        // soy redirigido al Index del módulo
        $I->seeCurrentUrlEquals(Page::$moduleURL);
        // veo mensaje de éxito en la operación
        $I->see(Page::$msgSuccess, Page::$msgSuccessElem);
        $formData = Page::unsetConfirmationFields($formData);
        $I->seeRecord('<?= $crud->table_name ?>', null_empty_fields($formData));
    }
}