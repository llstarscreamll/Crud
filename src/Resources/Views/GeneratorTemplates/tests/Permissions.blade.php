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
use {{$modelNamespace = config('modules.CrudGenerator.config.parent-app-namespace')."\Models\\".$gen->modelClassName()}};
use {{config('modules.CrudGenerator.config.role-model-namespace')}};
use {{config('modules.CrudGenerator.config.permission-model-namespace')}};
use Page\Functional\{{$gen->studlyCasePlural()}}\Index as Page;

class {{$test}}Cest
{
    /**
     * El id del registro de prueba.
     *
     * @var int
     */
    protected ${{$gen->modelVariableName()}}Id;

    /**
     * Las acciones a realizar antes de cada test.
     *
     * @param  FunctionalTester $I
     */
    public function _before(FunctionalTester $I)
    {
        new Page($I);
        $I->amLoggedAs(Page::$adminUser);

        $permissions = [
            '{{$gen->route()}}.create',
            '{{$gen->route()}}.edit',
            '{{$gen->route()}}.destroy',
@if($gen->hasDeletedAtColumn($fields))
            '{{$gen->route()}}.restore',
@endif
        ];

        // quitamos permisos de edición a los roles
        $permission = Permission::whereIn('{{config('modules.CrudGenerator.config.permission-slug-field-name')}}', $permissions)->get(['id'])->pluck('id')->toArray();
        Role::all()->each(function ($item) use ($permission) {
            $item->permissions()->detach($permission);
        });

        // creamos registro de prueba
        $this->{{$gen->modelVariableName()}}Id = Page::have{{$gen->modelClassName()}}($I);
    }

    /**
     * Prueba que las restricciones con los permisos de creación funcionen
     * correctamente.
     *
     * @param  FunctionalTester $I
     */
    public function createPermissions(FunctionalTester $I)
    {
        $I->wantTo('probar permisos de creación en módulo '.Page::$moduleName);

        // no debo ver link de acceso a página de creación en Index
        $I->amOnPage(Page::$moduleURL);
        $I->dontSee('Crear {!!$request->get('single_entity_name')!!}', 'button.btn.btn-default.btn-sm');
        $I->dontSee('Crear {!!$request->get('single_entity_name')!!}', 'a.btn.btn-default.btn-sm');

        // si intento acceder a la página soy redirigido al home de la app
        $I->amOnPage(Page::route('/create'));
        $I->seeCurrentUrlEquals('/home');
        $I->see('{{ config('modules.CrudGenerator.config.permissions-middleware-msg') }}', '.alert.alert-warning');
    }

    /**
     * Prueba que las restricciones con los permisos de edición funcionen
     * correctamente.
     *
     * @param  FunctionalTester $I
     */
    public function editPermissions(FunctionalTester $I)
    {
        $I->wantTo('probar permisos de edición en módulo '.Page::$moduleName);

        // no debo ver link de acceso a página de edición en Index
        $I->amOnPage(Page::$moduleURL);
        $I->dontSee('Editar', 'tbody tr td a.btn.btn-warning.btn-xs');

        // el la página de detalles del registro no debo ver el link a página de
        // edición
        $I->amOnPage(Page::route("/$this->{{$gen->modelVariableName()}}Id"));
        $I->dontSee('Editar', '.form-group a.btn.btn-warning');

        // si intento acceder a la página de edición de un registro soy
        // redirigido al home de la app
        $I->amOnPage(Page::route("/$this->{{$gen->modelVariableName()}}Id/edit"));
        $I->seeCurrentUrlEquals('/home');
        $I->see('{{ config('modules.CrudGenerator.config.permissions-middleware-msg') }}', '.alert.alert-warning');
    }

    /**
     * Prueba que las restricciones con los permisos de eliminación funcionen
     * correctamente.
     *
     * @param  FunctionalTester $I
     */
    public function deletePermissions(FunctionalTester $I)
    {
        $I->wantTo('probar permisos de eliminación en módulo '.Page::$moduleName);

        // no debo ver link de acceso a página de edición en Index
        $I->amOnPage(Page::$moduleURL);
        $I->dontSee('Mover a papelera', 'tbody tr td button.btn.btn-danger.btn-xs');
        $I->dontSee('Borrar {!!$request->get('plural_entity_name')!!} seleccionados', 'button.btn.btn-default.btn-sm');
        // en página de detalles del registro no debo ver botón "Mover a Papelera"
        $I->amOnPage(Page::route("/$this->{{$gen->modelVariableName()}}Id"));
        $I->dontSee('Mover a papelera', '.form-group button.btn.btn-danger');
    }

@if($gen->hasDeletedAtColumn($fields))
    /**
     * Prueba que las restricciones con los permisos de restauración de registros
     * registros en papelera funcionen correctamente.
     *
     * @param  FunctionalTester $I
     */
    public function restorePermissions(FunctionalTester $I)
    {
        $I->wantTo('probar permisos de restauración en módulo '.Page::$moduleName);

        // eliminamos el registro de prueba
        {{$gen->modelClassName()}}::destroy($this->{{$gen->modelVariableName()}}Id);

        // no debo ver link de acceso a página de edición en Index
        $I->amOnPage(Page::$moduleURL.'?trashed_records=withTrashed');
        $I->dontSee('Restaurar', 'tbody tr td button.btn.btn-success.btn-xs');
        $I->dontSee('Restaurar {{ $request->get('plural_entity_name') }} seleccionados', 'button.btn.btn-default.btn-sm');
    }

@endif
}