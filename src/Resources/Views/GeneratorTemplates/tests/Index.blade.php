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
     * Crea 10 y mueve a papelera 2 registros de prueba en la base de datos.
     *
     * @return Illuminate\Database\Eloquent\Collection
     */
    private function createAndSoftDeleteSomeRecords()
    {
        // creo registros de prueba
        factory({{ $gen->modelClassName() }}::class, 10)->create();

        return {{ $gen->modelClassName() }}::all(['id'])->take(2)
            ->each(function ($item, $key) {
                $item->delete();
            });
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

    /**
     * Prueba que sean mostrados los registros en papelera en la tabla del index
     * según le comvenga al usuario, sólo los registros en papelea o registros
     * "normales" junto con los registros en papelera.
     *
     * @param  FunctionalTester $I
     */
    public function seeTrashedData(FunctionalTester $I)
    {
        $I->wantTo('ver registros en papelera en index de módulo '.Page::$moduleName);
        
        // creo registros de prueba y elimino algunos
        {{ $gen->modelVariableNameFromClass($modelNamespace, 'plural') }}Trashed = $this->createAndSoftDeleteSomeRecords();

        {{ $gen->modelVariableNameFromClass($modelNamespace, 'plural') }} = {{ $gen->modelClassName() }}::all();

        // con registros en papelera
        $I->amOnPage(Page::$moduleURL.'?trashed_records=withTrashed');

        // las filas de los registros que están en papelera deben aparecer con
        // la clase danger, es decir con un fondo rojo, las filas que no están
        // eliminadas no tienen la clase danger
        foreach ({{ $gen->modelVariableNameFromClass($modelNamespace, 'plural') }}Trashed as $item) {
            $I->see($item->id, 'tbody tr.danger td.id');
        }
        foreach ({{ $gen->modelVariableNameFromClass($modelNamespace, 'plural') }} as $item) {
            $I->see($item->id, 'tbody tr td.id');
        }

        // sólo registros en papelera
        $I->amOnPage(Page::$moduleURL.'?trashed_records=onlyTrashed');

        foreach ({{ $gen->modelVariableNameFromClass($modelNamespace, 'plural') }}Trashed as $item) {
            $I->see($item->id, 'tbody tr.danger td.id');
        }

        foreach ({{ $gen->modelVariableNameFromClass($modelNamespace, 'plural') }} as $item) {
            $I->dontSee($item->id, 'tbody tr td.id');
        }
    }

    /**
     * Prueba que el botón para restablecer los registros en papelera sean
     * mostrados si es que el usuario consulta tales registros.
     *
     * @param  FunctionalTester $I
     */
    public function seeRestoreButtonIfShownTrashedRecords(FunctionalTester $I)
    {
        $I->wantTo('ver botón restablecer si hay registros en papelera index de módulo '.Page::$moduleName);

        // creo registros de prueba y elimino algunos
        {{ $gen->modelVariableNameFromClass($modelNamespace, 'plural') }}Trashed = $this->createAndSoftDeleteSomeRecords();

        // si el usuario no desea mostrar los registros en papelera, el botón no
        // debe ser mostrado
        $I->amOnPage(Page::$moduleURL);
        $I->dontSee('Restaurar Seleccionados', 'button.btn.btn-default.btn-sm');

        // si ha decidido mostrar los registros en papelera, el botón debe ser
        // mostrado
        $I->amOnPage(Page::$moduleURL.'?trashed_records=withTrashed');
        $I->see('Restaurar Seleccionados', 'button.btn.btn-default.btn-sm');
        $I->amOnPage(Page::$moduleURL.'?trashed_records=onlyTrashed');
        $I->see('Restaurar Seleccionados', 'button.btn.btn-default.btn-sm');
        // las filas borradas de la tabla también deben mostrar el botón
        $I->see('Restaurar', 'tbody tr.danger td button.btn.btn-success.btn-xs');
    }

    /**
     * Prueba que el botón de mover registros a "papelera" se muestre sólo
     * cuando haya algo que mover, por ejemplo para el caso en que son
     * mostrados sólo los registros de la papelera, en ese caso es
     * inecesario mostrar dicho botón.
     *
     * @param  FunctionalTester $I
     */
    public function dontSeeTrashButtonIfShownOnlyTrashedData(FunctionalTester $I)
    {
        $I->wantTo('ocultar botón "mover a papelera" si no hay registros que mover en index de módulo '.Page::$moduleName);

        // creo registros de prueba y elimino algunos
        {{ $gen->modelVariableNameFromClass($modelNamespace, 'plural') }}Trashed = $this->createAndSoftDeleteSomeRecords();

        // sólo se oculta el botón si lo unico que se desea consultar son los
        // registros en papelera
        $I->amOnPage(Page::$moduleURL.'?trashed_records=onlyTrashed');
        $I->dontSee('Borrar {!!$request->get('plural_entity_name')!!} seleccionados', 'button.btn.btn-default.btn-sm');
        $I->amOnPage(Page::$moduleURL);
        $I->see('Borrar {!!$request->get('plural_entity_name')!!} seleccionados', 'button.btn.btn-default.btn-sm');
        $I->amOnPage(Page::$moduleURL.'?trashed_records=withTrashed');
        $I->see('Borrar {!!$request->get('plural_entity_name')!!} seleccionados', 'button.btn.btn-default.btn-sm');
    }
}