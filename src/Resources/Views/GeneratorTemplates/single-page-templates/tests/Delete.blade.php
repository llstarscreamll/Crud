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
     * Pruea la funcionalidad de eliminar un modelo.
     * @param  FunctionalTester $I
     * @return void
     */
    public function delete(FunctionalTester $I)
    {
        $I->am('admin de '.trans('{{$gen->getLangAccess()}}/views.module.name'));
        $I->wantTo('eliminar un registro en modulo de '.trans('{{$gen->getLangAccess()}}/views.module.name'));

        // creo el registro de prueba
        Page::have{{$gen->modelClassName()}}($I);

        // voy a la página de detalles del registro
        $I->amOnPage(Page::route('/1'));
        // veo el botón que abre la ventana modal para la confirmación de eliminación
        $I->see(Page::$deleteBtn['txt'], Page::$deleteBtn['selector']);
        // doy click al botón de confirmación de ventana modal para borrar el registro
        $I->click(Page::$deleteBtnConfirm['txt'], Page::$deleteBtnConfirm['selector']);

        // soy redireccionado al index y veo mensaje de confirmación
        $I->seeCurrentUrlEquals(Page::$URL);
        $I->see(Page::$msgSuccess['txt'], Page::$msgSuccess['selector']);
        // veo mensaje de que no hay datos de capacitaciones
        $I->see(Page::$msgNoDataFount['txt'], Page::$msgNoDataFount['selector']);
    }
}