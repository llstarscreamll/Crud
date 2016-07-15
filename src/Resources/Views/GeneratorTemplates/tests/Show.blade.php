<?php
/* @var $gen llstarscreamll\CrudGenerator\Providers\TestsGenerator */
/* @var $fields [] */
/* @var $test [] */
/* @var $request Request */
?>
<?='<?php'?>

namespace {{$gen->studlyCasePlural()}};

use \FunctionalTester;
use Page\Functional\{{$gen->studlyCasePlural()}}\{{$test}} as Page;

class {{$test}}Cest
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
     * Prueba la funcionalidad de consultar la información de un modelo, sólo lectura.
     * @param  FunctionalTester $I
     * @return void
     */
    public function show(FunctionalTester $I)
    {
        $I->am('admin de '.trans('{{$gen->getLangAccess()}}/views.module.name'));
        $I->wantTo('ver detalles de un registro en modulo de '.trans('{{$gen->getLangAccess()}}/views.module.name'));

        // creo el registro de prueba
        Page::have{{$gen->modelClassName()}}($I);

        // voy a la página de detalles del registro
        $I->amOnPage(Page::route('/'.Page::${{$gen->modelVariableName()}}Data['id']));
        // veo el título de la página
        $I->see(Page::$title['txt'], Page::$title['selector']);

        // veo los datos en el formulario de sólo lectura
        $I->seeInFormFields(Page::$form, Page::getReadOnlyFormData());
    }
}