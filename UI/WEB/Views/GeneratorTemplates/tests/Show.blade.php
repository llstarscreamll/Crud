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
     * Prueba la funcionalidad de consultar la información de un modelo, sólo
     * lectura.
     *
     * @param  FunctionalTester $I
     */
    public function show(FunctionalTester $I)
    {
        $I->wantTo('ver detalles de registro en módulo '.Page::$moduleName);

        // creo el registro de prueba
        Page::have<?= $crud->modelClassName() ?>($I);

        // voy a la página de detalles del registro
        $I->amOnPage(Page::route('/'.Page::$<?= $crud->modelVariableName() ?>Data['id']));
        // veo el título de la página
        $I->see(Page::$moduleName, Page::$titleElem);
        $I->see(Page::$title, Page::$titleSmallElem);

        // los datos del formulario
        $formData = Page::$<?= $crud->modelVariableName() ?>Data;
        $formData = Page::unsetHiddenFields($formData);

        // veo los campos correspondientes en el formulario
        foreach ($formData as $name => $value) {
            $I->seeElement("*[name=$name]");
        }

        // veo los datos del registro en el formulario de sólo lectura
        $I->seeInFormFields(Page::$form, $formData);
    }
}