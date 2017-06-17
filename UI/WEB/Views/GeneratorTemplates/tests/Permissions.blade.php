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
use <?= $modelNamespace = config('modules.crud.config.parent-app-namespace')."\Models\\".$crud->modelClassName() ?>;
use <?= config('modules.crud.config.role-model-namespace') ?>;
use <?= config('modules.crud.config.permission-model-namespace') ?>;
use Page\Functional\<?= $crud->studlyCasePlural() ?>\Index as Page;
use Page\Functional\<?= $crud->studlyCasePlural() ?>\Destroy as DestroyPage;
use Page\Functional\<?= $crud->studlyCasePlural() ?>\Create as CreatePage;
use Page\Functional\<?= $crud->studlyCasePlural() ?>\Edit as EditPage;

class <?= $test ?>Cest
{
    /**
     * El id del registro de prueba.
     *
     * @var int
     */
    protected $<?= $crud->modelVariableName() ?>Id;

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
            '<?= $crud->route() ?>.create',
            '<?= $crud->route() ?>.edit',
            '<?= $crud->route() ?>.destroy',
<?php if($crud->hasDeletedAtColumn($fields)) { ?>
            '<?= $crud->route() ?>.restore',
<?php } ?>
        ];

        // quitamos permisos de edición a los roles
        $permission = Permission::whereIn('<?= config('modules.crud.config.permission-slug-field-name') ?>', $permissions)
            ->get(['id'])
            ->pluck('id')
            ->toArray();

        Role::all()->each(function ($item) use ($permission) {
            $item->permissions()->detach($permission);
        });

        // creamos registro de prueba
        $this-><?= $crud->modelVariableName() ?>Id = Page::have<?= $crud->modelClassName() ?>($I);
    }

    /**
     * Prueba que las restricciones con los permisos de creación funcionen
     * correctamente.
     *
     * @param  FunctionalTester $I
<?php if(!empty($request->get('is_part_of_package'))) { ?>
     * @group  <?= $request->get('is_part_of_package')."\n" ?>
     */ 
<?php } else { ?>
     */
<?php } ?>
    public function createPermissions(FunctionalTester $I)
    {
        $I->wantTo('probar permisos de creación en módulo '.Page::$moduleName);

        // no debo ver link de acceso a página de creación en Index
        $I->amOnPage(Page::$moduleURL);
        $I->dontSee(CreatePage::$createBtn, CreatePage::$createBtnElem);

        // si intento acceder a la página soy redirigido al home de la app
        $I->amOnPage(Page::route('/create'));
        $I->seeCurrentUrlEquals(Page::$homeUrl);
        $I->see(Page::$badPermissionsMsg, Page::$badPermissionsMsgElem);
    }

    /**
     * Prueba que las restricciones con los permisos de edición funcionen
     * correctamente.
     *
     * @param  FunctionalTester $I
<?php if(!empty($request->get('is_part_of_package'))) { ?>
     * @group  <?= $request->get('is_part_of_package')."\n" ?>
     */ 
<?php } else { ?>
     */
<?php } ?>
    public function editPermissions(FunctionalTester $I)
    {
        $I->wantTo('probar permisos de edición en módulo '.Page::$moduleName);

        // no debo ver link de acceso a página de edición en Index
        $I->amOnPage(Page::$moduleURL);
        $I->dontSee(EditPage::$linkToEdit, 'tbody tr td '.EditPage::$linkToEditElem);

        // el la página de detalles del registro no debo ver el link a página de
        // edición
        $I->amOnPage(Page::route("/$this-><?= $crud->modelVariableName() ?>Id"));
        $I->dontSee(EditPage::$linkToEdit, '.form-group '.EditPage::$linkToEditElem);

        // si intento acceder a la página de edición de un registro soy
        // redirigido al home de la app
        $I->amOnPage(Page::route("/$this-><?= $crud->modelVariableName() ?>Id/edit"));
        $I->seeCurrentUrlEquals(Page::$homeUrl);
        $I->see(Page::$badPermissionsMsg, Page::$badPermissionsMsgElem);
    }

    /**
     * Prueba que las restricciones con los permisos de <?= strtolower($crud->getDestroyBtnTxt()) ?>
     * funcionen correctamente.
     *
     * @param  FunctionalTester $I
<?php if(!empty($request->get('is_part_of_package'))) { ?>
     * @group  <?= $request->get('is_part_of_package')."\n" ?>
     */ 
<?php } else { ?>
     */
<?php } ?>
    public function <?= $crud->getDestroyVariableName() ?>Permissions(FunctionalTester $I)
    {
        $I->wantTo('probar permisos de <?= strtolower($crud->getDestroyBtnTxt()) ?> en módulo '.Page::$moduleName);

        // no debo ver link de acceso a página de edición en Index
        $I->amOnPage(Page::$moduleURL);
        $I->dontSee(DestroyPage::$<?= $crud->getDestroyVariableName() ?>Btn, DestroyPage::$<?= $crud->getDestroyVariableName() ?>BtnElem);
        $I->dontSee(DestroyPage::$<?= $crud->getDestroyVariableName() ?>ManyBtn, DestroyPage::$<?= $crud->getDestroyVariableName() ?>ManyBtnElem);
        // en página de detalles del registro no debo ver botón "Mover a Papelera"
        $I->amOnPage(Page::route("/$this-><?= $crud->modelVariableName() ?>Id"));
        $I->dontSee(DestroyPage::$<?= $crud->getDestroyVariableName() ?>Btn, DestroyPage::$<?= $crud->getDestroyVariableName() ?>BtnElem);
    }

<?php if($crud->hasDeletedAtColumn($fields)) { ?>
    /**
     * Prueba que las restricciones con los permisos de restauración de
     * registros en papelera funcionen correctamente.
     *
     * @param  FunctionalTester $I
<?php if(!empty($request->get('is_part_of_package'))) { ?>
     * @group  <?= $request->get('is_part_of_package')."\n" ?>
     */
<?php } else { ?>
     */
<?php } ?>
    public function restorePermissions(FunctionalTester $I)
    {
        $I->wantTo('probar permisos de restauración en módulo '.Page::$moduleName);

        // eliminamos el registro de prueba
        <?= $crud->modelClassName() ?>::destroy($this-><?= $crud->modelVariableName() ?>Id);

        // no debo ver link de acceso a página de edición en Index
        $I->amOnPage(
            route(
                '<?= $crud->modelPluralVariableName() ?>.index',
                [Page::$searchFieldsPrefix => ['trashed_records' => 'withTrashed']]
            )
        );
        $I->dontSee(Page::$restoreBtn, Page::$restoreBtnElem);
        $I->dontSee(Page::$restoreManyBtn, Page::$restoreManyBtnElem);
    }
<?php } ?>
}