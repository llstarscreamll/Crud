<?php
/* @var $crud App\Containers\Crud\Providers\TestsGenerator */
/* @var $fields [] */
/* @var $test [] */
/* @var $request Request */
?>
<?='<?php'?>


<?= $crud->getClassCopyRightDocBlock() ?>


namespace <?= $crud->studlyCasePlural() ?>;

use <?= $modelNamespace = config('modules.crud.config.parent-app-namespace')."\Models\\".$crud->modelClassName() ?>;
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
     * Prueba la funcionalidad de <?= strtolower($crud->getDestroyBtnTxt()) ?> un registro.
     *
     * @param  FunctionalTester $I
<?php if (!empty($request->get('is_part_of_package'))) { ?>
     * @group  <?= $request->get('is_part_of_package')."\n" ?>
     */ 
<?php } else { ?>
     */
<?php } ?>
    public function <?= $crud->getDestroyVariableName() ?>(FunctionalTester $I)
    {
        $I->wantTo('<?= strtolower($crud->getDestroyBtnTxt()) ?> registro en módulo '.Page::$moduleName);

        // creo registro de prueba
        Page::have<?= $crud->modelClassName() ?>($I);

        // voy a la página de detalles del registro y doy clic al botón
        // "<?= $crud->getDestroyBtnTxt() ?>"
        $I->amOnPage(Page::route('/'.Page::$<?= $crud->modelVariableName() ?>Data['id']));
        $I->click(Page::$<?= $crud->getDestroyVariableName() ?>Btn, Page::$<?= $crud->getDestroyVariableName() ?>BtnElem);

        // soy redirigido al Index y debo ver mensaje de éxito en la operación
        $I->seeCurrentUrlEquals(Page::$moduleURL);
        $I->see(Page::$msgSuccess, Page::$msgSuccessElem);
        // no debe haber datos que mostrar
        $I->see(Page::$noDataFountMsg, Page::$noDataFountMsgElem);
    }

    /**
     * Prueba la funcionalidad de <?= strtolower($crud->getDestroyBtnTxt()) ?> varios registros a la vez.
     *
     * @param  FunctionalTester $I
<?php if (!empty($request->get('is_part_of_package'))) { ?>
     * @group  <?= $request->get('is_part_of_package')."\n" ?>
     */ 
<?php } else { ?>
     */
<?php } ?>
    public function <?= $crud->getDestroyVariableName() ?>Many(FunctionalTester $I)
    {
        $I->wantTo('<?= strtolower($crud->getDestroyBtnTxt()) ?> varios registros a la vez en módulo '.Page::$moduleName);

        // creo registros de prueba
        $<?= str_plural($crud->modelVariableName()) ?> = factory(<?= $crud->modelClassName() ?>::class, 10)->create();

        // cuando cargo el Index el botón "<?= $crud->getDestroyBtnTxt() ?>" debe
        // ser mostrado
        $I->amOnPage(Page::$moduleURL);
        $I->see(Page::$<?= $crud->getDestroyVariableName() ?>ManyBtn, Page::$<?= $crud->getDestroyVariableName() ?>ManyBtnElem);
        
        // cargo la ruta que "<?= $crud->getDestroyBtnTxt() ?>" los registros
        $I->submitForm('#deletemanyForm', [
            'id' => $<?= str_plural($crud->modelVariableName()) ?>->pluck('id')->toArray()
        ]);
        $I->dontSeeFormErrors();
        
        // soy redirigido al Index y no debe haber datos que mostrar
        $I->seeCurrentUrlEquals(Page::$moduleURL);
        $I->see(Page::$noDataFountMsg, Page::$noDataFountMsgElem);
    }
}