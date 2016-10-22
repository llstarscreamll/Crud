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
     * Prueba los datos mostrados en el index del módulo.
     *
     * @param  FunctionalTester $I
     */
    public function index(FunctionalTester $I)
    {
        $I->wantTo('probar vista index de módulo '.Page::$moduleName);
        
        // creo el registro de prueba
        Page::have{{$gen->modelClassName()}}($I);

        $I->amOnPage(Page::$moduleURL);
        $I->see(Page::$moduleName, Page::$titleElem);

        // veo los respectivos datos en la tabla
        foreach (Page::getIndexTableData() as $field => $value) {
            $I->see($value, Page::$table.' tbody tr.item-1 td.'.$field);
        }
    }
}