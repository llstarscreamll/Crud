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
    public function _before(FunctionalTester $I)
    {
        new Page($I);
        $I->amLoggedAs(Page::$adminUser);
    }

    public function _after(FunctionalTester $I)
    {
    }

    /**
     * Prueba los datos mostrados en el index del módulo.
     * @param  FunctionalTester $I
     * @return void
     */
    public function index(FunctionalTester $I)
    {
        $I->am('admin de '.trans('{{$gen->getLangAccess()}}/views.module.name'));
        $I->wantTo('ver datos en el index del modulo '.trans('{{$gen->getLangAccess()}}/views.module.name'));
        
        // creo el registro de prueba
        Page::have{{$gen->modelClassName()}}($I);

        $I->amOnPage(Page::$moduleURL);
        $I->see(Page::$title['txt'], Page::$title['selector']);

        // veo los respectivos datos en la tabla
        foreach (Page::getIndexTableData() as $field => $value) {
            $I->see($value, Page::$table.' tbody tr.item-1 td.'.$field);
        }
    }
}