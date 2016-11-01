<?php
/* @var $gen llstarscreamll\CrudGenerator\Providers\TestsGenerator */
/* @var $fields [] */
/* @var $test [] */
/* @var $request Request */
?>
<?='<?php'?>


<?= $gen->getClassCopyRightDocBlock() ?>


namespace {{$gen->studlyCasePlural()}};

use {{$modelNamespace = config('modules.CrudGenerator.config.parent-app-namespace')."\Models\\".$gen->modelClassName()}};
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
     * Prueba la funcionalidad de {{ strtolower($gen->getDestroyBtnTxt()) }} un registro.
     *
     * @param  FunctionalTester $I
@if(!empty($request->get('is_part_of_package')))
     * @group  {{$request->get('is_part_of_package')}}
     */ 
@else
     */
@endif
    public function {{ $gen->getDestroyVariableName() }}(FunctionalTester $I)
    {
        $I->wantTo('{{ strtolower($gen->getDestroyBtnTxt()) }} registro en módulo '.Page::$moduleName);

        // creo registro de prueba
        Page::have{{$gen->modelClassName()}}($I);

        // voy a la página de detalles del registro y doy clic al botón
        // "{{ $gen->getDestroyBtnTxt() }}"
        $I->amOnPage(Page::route('/'.Page::${{$gen->modelVariableName()}}Data['id']));
        $I->click(Page::${{ $gen->getDestroyVariableName() }}Btn, Page::${{ $gen->getDestroyVariableName() }}BtnElem);

        // soy redirigido al Index y debo ver mensaje de éxito en la operación
        $I->seeCurrentUrlEquals(Page::$moduleURL);
        $I->see(Page::$msgSuccess, Page::$msgSuccessElem);
        // no debe haber datos que mostrar
        $I->see(Page::$noDataFountMsg, Page::$noDataFountMsgElem);
    }

    /**
     * Prueba la funcionalidad de {{ strtolower($gen->getDestroyBtnTxt()) }} varios registros a la vez.
     *
     * @param  FunctionalTester $I
@if(!empty($request->get('is_part_of_package')))
     * @group  {{$request->get('is_part_of_package')}}
     */ 
@else
     */
@endif
    public function {{ $gen->getDestroyVariableName() }}Many(FunctionalTester $I)
    {
        $I->wantTo('{{ strtolower($gen->getDestroyBtnTxt()) }} varios registros a la vez en módulo '.Page::$moduleName);

        // creo registros de prueba
        $books = factory({{ $gen->modelClassName() }}::class, 10)->create();

        // cuando cargo el Index el botón "{{ $gen->getDestroyBtnTxt() }}" debe
        // ser mostrado
        $I->amOnPage(Page::$moduleURL);
        $I->see(Page::${{ $gen->getDestroyVariableName() }}ManyBtn, Page::${{ $gen->getDestroyVariableName() }}ManyBtnElem);
        
        // cargo la ruta que "{{ $gen->getDestroyBtnTxt() }}" los registros
        $I->destroyMany('{{ $gen->route() }}.destroy', $books->pluck('id')->toArray());
        
        // soy redirigido al Index y no debe haber datos que mostrar
        $I->seeCurrentUrlEquals(Page::$moduleURL);
        $I->see(Page::$noDataFountMsg, Page::$noDataFountMsgElem);
    }
}